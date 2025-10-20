<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Address;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmationMail;
use App\Services\KHQRService;

class CheckoutController extends Controller
{
    protected $khqrService;

    public function __construct(KHQRService $khqrService)
    {
        $this->khqrService = $khqrService;
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('frontend.login')->with('error', 'Please login to checkout.');
        }

        $selectedIds = $request->query('selected', []);

        if (!empty($selectedIds)) {
            $cartItems = $user->cart()->whereIn('id', $selectedIds)->with('product')->get();
        } else {
            $cartItems = $user->cart()->with('product')->get();
        }

        if ($cartItems->isEmpty()) {
            return redirect()->route('frontend.cart')->with('error', 'Your cart is empty or selected items are no longer available.');
        }

        $cartTotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('frontend.checkout.checkout', compact('cartItems', 'cartTotal', 'selectedIds'));
    }

    public function placeOrder(Request $request)
    {
        DB::beginTransaction();
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['error' => 'User not authenticated.'], 401);
            }

            $selectedIds = $request->input('selected_items', []);
            Log::info('Selected items from request:', ['selected_ids' => $selectedIds]);

            if (!empty($selectedIds)) {
                $cartItems = $user->cart()->whereIn('id', $selectedIds)->with('product')->get();
            } else {
                $cartItems = $user->cart()->with('product')->get();
            }

            if ($cartItems->isEmpty()) {
                return response()->json(['error' => 'Your cart is empty.'], 400);
            }

            $grandTotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email',
                'phone' => 'required|string|max:20',
                'address' => 'required|string',
                'city' => 'required|string|max:255',
                'state' => 'required|string|max:255',
                'zip_code' => 'required|string|max:20',
                'payment_method' => 'required|in:stripe,khqr'
            ]);

            $cartItemIds = $cartItems->pluck('id')->toArray();

            $order = Order::create([
                'user_id' => $user->id,
                'grand_total' => $grandTotal,
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'pending',
                'status' => 'new',
                'currency' => 'USD',
                'shipping_amount' => 0,
                'shipping_method' => 'standard',
                'notes' => 'Cart items: ' . implode(',', $cartItemIds)
            ]);

            Log::info('Order created:', ['order_id' => $order->id, 'payment_method' => $validated['payment_method']]);

            Address::create([
                'order_id' => $order->id,
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'phone' => $validated['phone'],
                'street_address' => $validated['address'],
                'city' => $validated['city'],
                'state' => $validated['state'],
                'zip_code' => $validated['zip_code'],
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product->id,
                    'quantity' => $item->quantity,
                    'unit_amount' => $item->product->price,
                    'total_amount' => $item->product->price * $item->quantity,
                ]);
            }

            // Handle payment method
            if ($validated['payment_method'] === 'khqr') {
                return $this->handleKHQRPayment($order, $grandTotal);
            } else {
                return $this->handleStripePayment($order, $cartItems, $user);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout error: ' . $e->getMessage());
            return response()->json(['error' => 'Something went wrong. ' . $e->getMessage()], 500);
        }
    }

    protected function handleKHQRPayment($order, $amount)
    {
        try {
            $result = $this->khqrService->generateMerchantQR(
                amount: $amount,
                currency: 'USD',
                billNumber: 'ORD-' . $order->id,
                storeLabel: config('khqr.merchant_name')
            );

            if (!$result['success']) {
                DB::rollBack();
                return response()->json(['error' => $result['error']], 500);
            }

            $expiryMinutes = config('khqr.qr_expiry_minutes', 10);
            $order->update([
                'khqr_code' => $result['qr'],
                'khqr_md5' => $result['md5'],
                'khqr_expires_at' => now()->addMinutes($expiryMinutes)
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'payment_method' => 'khqr',
                'redirect_url' => route('frontend.checkout.khqr', ['order' => $order->id])
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('KHQR Payment Error: ' . $e->getMessage());
            return response()->json(['error' => 'KHQR payment initialization failed.'], 500);
        }
    }

    protected function handleStripePayment($order, $cartItems, $user)
    {
        try {
            $lineItems = [];
            foreach ($cartItems as $item) {
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $item->product->name,
                        ],
                        'unit_amount' => round($item->product->price * 100),
                    ],
                    'quantity' => $item->quantity,
                ];
            }

            Stripe::setApiKey(env('STRIPE_SECRET'));

            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('frontend.checkout.success', ['order' => $order->id]) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('frontend.checkout.cancel', ['order' => $order->id]),
                'metadata' => [
                    'order_id' => $order->id,
                    'user_id' => $user->id,
                ]
            ]);

            $order->update(['stripe_session_id' => $session->id]);

            DB::commit();

            Log::info('Stripe session created', ['order_id' => $order->id]);
            return response()->json(['url' => $session->url]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Stripe Payment Error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function showKHQR(Request $request, $orderId)
    {
        try {
            $order = Order::with(['orderItems.product', 'address', 'user'])->findOrFail($orderId);

            if ($order->user_id !== Auth::id()) {
                return redirect()->route('frontend.cart')->with('error', 'Order not found.');
            }

            if ($order->payment_method !== 'khqr') {
                return redirect()->route('frontend.cart')->with('error', 'Invalid payment method.');
            }

            if ($order->isKHQRExpired()) {
                return redirect()->route('frontend.checkout.khqr.expired', ['order' => $orderId]);
            }

            return view('frontend.checkout.khqr_payment', compact('order'));

        } catch (\Exception $e) {
            Log::error('KHQR Display Error: ' . $e->getMessage());
            return redirect()->route('frontend.cart')->with('error', 'Unable to display payment QR code.');
        }
    }

public function checkKHQRStatus(Request $request, $orderId)
{
    try {
        $order = Order::findOrFail($orderId);

        if ($order->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // If already paid, redirect to success
        if ($order->payment_status === 'paid') {
            return response()->json([
                'status' => 'paid',
                'redirect_url' => route('frontend.checkout.success', ['order' => $orderId])
            ]);
        }

        // Check if expired
        if ($order->isKHQRExpired()) {
            return response()->json([
                'status' => 'expired',
                'redirect_url' => route('frontend.checkout.khqr.expired', ['order' => $orderId])
            ]);
        }

        // Check transaction status with Bakong API
        $result = $this->khqrService->checkTransactionByMD5($order->khqr_md5);

        Log::info('KHQR Status Check Result', [
            'order_id' => $orderId,
            'md5' => $order->khqr_md5,
            'result' => $result
        ]);

        if ($result['success']) {
            $responseData = $result['data'];

            // Check if response has data (payment found)
            // According to Bakong API: responseCode = 0 means success
            if (isset($responseData->responseCode) && $responseData->responseCode === 0) {

                // Check if transaction data exists
                if (isset($responseData->data) && !empty($responseData->data)) {

                    // Payment confirmed - process the order
                    $this->processKHQRPayment($order);

                    Log::info('KHQR Payment Confirmed', [
                        'order_id' => $orderId,
                        'transaction_data' => $responseData->data
                    ]);

                    return response()->json([
                        'status' => 'paid',
                        'redirect_url' => route('frontend.checkout.success', ['order' => $orderId])
                    ]);
                }
            }

            // Payment not found yet - still pending
            return response()->json(['status' => 'pending']);
        }

        // API call failed but not critical - keep checking
        Log::warning('KHQR Status Check Failed', [
            'order_id' => $orderId,
            'error' => $result['error'] ?? 'Unknown error'
        ]);

        return response()->json(['status' => 'pending']);

    } catch (\Exception $e) {
        Log::error('KHQR Status Check Error: ' . $e->getMessage(), [
            'order_id' => $orderId,
            'trace' => $e->getTraceAsString()
        ]);
        return response()->json(['error' => 'Status check failed'], 500);
    }
}


    protected function processKHQRPayment($order)
    {
        DB::beginTransaction();
        try {
            $order->update([
                'payment_status' => 'paid',
                'status' => 'processing',
            ]);

            Log::info('KHQR payment marked as paid', ['order_id' => $order->id]);

            foreach ($order->orderItems as $orderItem) {
                $product = Product::find($orderItem->product_id);
                if ($product) {
                    $oldStock = $product->quantity;
                    $newStock = max(0, $oldStock - $orderItem->quantity);
                    $product->update(['quantity' => $newStock]);

                    Log::info('Stock updated', [
                        'product_id' => $product->id,
                        'old_stock' => $oldStock,
                        'new_stock' => $newStock
                    ]);
                }
            }

            $cartItemIds = [];
            if (preg_match('/Cart items: ([\d,]+)/', $order->notes, $matches)) {
                $cartItemIds = array_filter(explode(',', $matches[1]));
            }

            $removedCount = 0;
            if (!empty($cartItemIds)) {
                $removedCount = Cart::where('user_id', $order->user_id)
                    ->whereIn('id', $cartItemIds)
                    ->delete();
            } else {
                $removedCount = Cart::where('user_id', $order->user_id)->delete();
            }

            Log::info('Cart items removed', ['count' => $removedCount]);

            try {
                Mail::to($order->user->email)->send(new OrderConfirmationMail($order));
                Log::info('Order confirmation email sent', [
                    'order_id' => $order->id,
                    'email' => $order->user->email
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to send order confirmation email: ' . $e->getMessage());
            }

            $this->sendTelegramNotification($order);

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Process KHQR Payment Error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function khqrExpired(Request $request, $orderId)
    {
        try {
            $order = Order::findOrFail($orderId);

            if ($order->user_id !== Auth::id()) {
                return redirect()->route('frontend.cart')->with('error', 'Order not found.');
            }

            if ($order->payment_status === 'pending') {
                $order->update(['status' => 'cancelled']);
            }

            return view('frontend.checkout.khqr_expired', compact('order'));

        } catch (\Exception $e) {
            Log::error('KHQR Expired Error: ' . $e->getMessage());
            return redirect()->route('frontend.cart')->with('error', 'Unable to process request.');
        }
    }

    public function success(Request $request, $orderId)
    {
        Log::info('Checkout Success Accessed', [
            'order_id' => $orderId,
            'user_id' => Auth::id(),
            'session_id' => $request->get('session_id')
        ]);

        DB::beginTransaction();
        try {
            $order = Order::with(['orderItems.product', 'address', 'user'])->findOrFail($orderId);

            if ($order->user_id !== Auth::id()) {
                return redirect()->route('frontend.cart')->with('error', 'Order not found.');
            }

            if ($order->payment_status === 'paid') {
                return view('frontend.checkout.checkout_success', compact('order'))
                    ->with('success', 'Payment was already processed successfully!');
            }

            // Handle Stripe payment verification
            if ($order->payment_method === 'stripe') {
                $sessionId = $request->get('session_id');
                $paymentVerified = false;

                if ($sessionId) {
                    try {
                        Stripe::setApiKey(env('STRIPE_SECRET'));
                        $session = Session::retrieve($sessionId);

                        if ($session->payment_status === 'paid') {
                            $paymentVerified = true;
                            Log::info('Stripe payment verified', ['order_id' => $orderId]);
                        }
                    } catch (\Exception $e) {
                        Log::error('Stripe session retrieval failed: ' . $e->getMessage());
                    }
                }

                if ($paymentVerified) {
                    $order->update([
                        'payment_status' => 'paid',
                        'status' => 'processing',
                    ]);

                    Log::info('Payment marked as paid', ['order_id' => $order->id]);

                    foreach ($order->orderItems as $orderItem) {
                        $product = Product::find($orderItem->product_id);
                        if ($product) {
                            $oldStock = $product->quantity;
                            $newStock = max(0, $oldStock - $orderItem->quantity);
                            $product->update(['quantity' => $newStock]);

                            Log::info('Stock updated', [
                                'product_id' => $product->id,
                                'old_stock' => $oldStock,
                                'new_stock' => $newStock
                            ]);
                        }
                    }

                    $cartItemIds = [];
                    if (preg_match('/Cart items: ([\d,]+)/', $order->notes, $matches)) {
                        $cartItemIds = array_filter(explode(',', $matches[1]));
                    }

                    $removedCount = 0;
                    if (!empty($cartItemIds)) {
                        $removedCount = Cart::where('user_id', Auth::id())
                            ->whereIn('id', $cartItemIds)
                            ->delete();
                    } else {
                        $removedCount = Cart::where('user_id', Auth::id())->delete();
                    }

                    Log::info('Cart items removed', ['count' => $removedCount]);

                    try {
                        Mail::to($order->user->email)->send(new OrderConfirmationMail($order));
                        Log::info('Order confirmation email sent', [
                            'order_id' => $order->id,
                            'email' => $order->user->email
                        ]);
                    } catch (\Exception $e) {
                        Log::error('Failed to send order confirmation email: ' . $e->getMessage());
                    }

                    $this->sendTelegramNotification($order);

                    DB::commit();

                    return view('frontend.checkout.checkout_success', compact('order'))
                        ->with('success', 'Payment successful! Your order has been placed. A confirmation email has been sent to ' . $order->user->email);

                } else {
                    DB::rollBack();
                    Log::warning('Payment verification failed', ['order_id' => $orderId]);
                    return redirect()->route('frontend.checkout.index')->with('error', 'Payment verification failed. Please contact support.');
                }
            }

            // Handle KHQR payment (already verified in processKHQRPayment)
            if ($order->payment_method === 'khqr') {
                DB::commit();
                return view('frontend.checkout.checkout_success', compact('order'))
                    ->with('success', 'Payment successful! Your order has been placed.');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout success error: ' . $e->getMessage());
            return redirect()->route('frontend.cart')->with('error', 'Unable to process order: ' . $e->getMessage());
        }
    }

    public function cancel(Request $request, $orderId)
    {
        Log::info('Checkout cancelled', ['order_id' => $orderId]);

        try {
            $order = Order::find($orderId);

            if ($order && $order->user_id === Auth::id()) {
                if ($order->payment_status === 'pending') {
                    $order->update(['status' => 'cancelled']);
                }
            }

            return redirect()->route('frontend.cart')->with('error', 'Payment was cancelled.');

        } catch (\Exception $e) {
            Log::error('Cancel method error: ' . $e->getMessage());
            return redirect()->route('frontend.cart')->with('error', 'Unable to process cancellation.');
        }
    }

    private function sendTelegramNotification(Order $order)
    {
        try {
            $botToken = env('TELEGRAM_BOT_TOKEN');
            $chatId = env('TELEGRAM_CHAT_ID');

            if (!$botToken || !$chatId) {
                Log::warning('Telegram bot token or chat ID not configured');
                return false;
            }

            $apiUrl = "https://api.telegram.org/{$botToken}/sendMessage";

            $escape = function ($text) {
                return str_replace(
                    ['&', '<', '>'],
                    ['&amp;', '&lt;', '&gt;'],
                    $text
                );
            };

            $message = "💰 <b>You Have an Order!</b>\n\n";
            $message .= "🆔 <b>Order ID:</b> #" . $order->id . "\n";
            $message .= "💳 <b>Payment Method:</b> " . strtoupper($order->payment_method) . "\n";
            $message .= "👤 <b>Customer:</b> " . $escape($order->address->first_name . " " . $order->address->last_name) . "\n";
            $message .= "📧 <b>Email:</b> " . $escape($order->user->email ?? 'N/A') . "\n";
            $message .= "📞 <b>Phone:</b> " . $escape($order->address->phone ?? 'N/A') . "\n";
            $message .= "💵 <b>Amount:</b> $" . number_format($order->grand_total, 2) . "\n";
            $message .= "📦 <b>Items:</b> " . $order->orderItems->count() . "\n";
            $message .= "🕒 <b>Date:</b> " . now()->format('Y-m-d H:i:s') . "\n\n";

            $message .= "📋 <b>Order Items:</b>\n";
            foreach ($order->orderItems as $item) {
                $message .= "  • " . $escape($item->product->name) . " (Qty: " . $item->quantity . ") - $" . number_format($item->total_amount, 2) . "\n";
            }

            $message .= "\n📍 <b>Shipping Address:</b>\n";
            $message .= $escape($order->address->street_address . ", " . $order->address->city . ", " . $order->address->state . " " . $order->address->zip_code);

            $httpClient = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]);

            if (app()->environment('local')) {
                $httpClient = $httpClient->withoutVerifying();
            }

            $response = $httpClient->post($apiUrl, [
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'HTML',
                'disable_web_page_preview' => false,
                'disable_notification' => false,
            ]);

            if ($response->successful()) {
                $responseData = $response->json();
                $messageId = $responseData['result']['message_id'] ?? null;

                Log::info('Telegram notification sent successfully', [
                    'order_id' => $order->id,
                    'message_id' => $messageId
                ]);

                return true;
            } else {
                Log::error('Telegram API error', [
                    'order_id' => $order->id,
                    'response' => $response->body(),
                    'status' => $response->status()
                ]);
                return false;
            }

        } catch (\Exception $e) {
            Log::error('Failed to send Telegram notification: ' . $e->getMessage());
            return false;
        }
    }
}
