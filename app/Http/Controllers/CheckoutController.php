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

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('frontend.login')->with('error', 'Please login to checkout.');
        }

        // Get selected cart items from query parameters
        $selectedIds = $request->query('selected', []);

        // Use the cart relationship from User model
        if (!empty($selectedIds)) {
            $cartItems = $user->cart()->whereIn('id', $selectedIds)->with('product')->get();
        } else {
            $cartItems = $user->cart()->with('product')->get();
        }

        if ($cartItems->isEmpty()) {
            return redirect()->route('frontend.cart')->with('error', 'Your cart is empty or selected items are no longer available.');
        }

        $cartTotal = $cartItems->sum(function($item) {
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

            // Get selected cart items from the request
            $selectedIds = $request->input('selected_items', []);

            Log::info('Selected items from request:', ['selected_ids' => $selectedIds]);

            // Get cart items based on selection
            if (!empty($selectedIds)) {
                $cartItems = $user->cart()->whereIn('id', $selectedIds)->with('product')->get();
            } else {
                $cartItems = $user->cart()->with('product')->get();
            }

            if ($cartItems->isEmpty()) {
                return response()->json(['error' => 'Your cart is empty.'], 400);
            }

            $grandTotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

            // Validate address fields
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email',
                'phone' => 'required|string|max:20',
                'address' => 'required|string',
                'city' => 'required|string|max:255',
                'state' => 'required|string|max:255',
                'zip_code' => 'required|string|max:20',
            ]);

            // Store cart item IDs for later removal
            $cartItemIds = $cartItems->pluck('id')->toArray();

            // Create Order
            $order = Order::create([
                'user_id' => $user->id,
                'grand_total' => $grandTotal,
                'payment_method' => 'stripe',
                'payment_status' => 'pending',
                'status' => 'new',
                'currency' => 'USD',
                'shipping_amount' => 0,
                'shipping_method' => 'standard',
                'notes' => 'Cart items: ' . implode(',', $cartItemIds)
            ]);

            Log::info('Order created:', ['order_id' => $order->id]);

            // Save Address
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

            // Save Order Items and prepare line items for Stripe
            $lineItems = [];
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product->id,
                    'quantity' => $item->quantity,
                    'unit_amount' => $item->product->price,
                    'total_amount' => $item->product->price * $item->quantity,
                ]);

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

            // Stripe Payment Session
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

            // Store stripe session ID in order
            $order->update(['stripe_session_id' => $session->id]);

            DB::commit();

            Log::info('Stripe session created', ['order_id' => $order->id]);
            return response()->json(['url' => $session->url]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout error: ' . $e->getMessage());
            return response()->json(['error' => 'Something went wrong. ' . $e->getMessage()], 500);
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
            $order = Order::with(['orderItems.product', 'address'])->findOrFail($orderId);

            // Verify order belongs to user
            if ($order->user_id !== Auth::id()) {
                return redirect()->route('frontend.cart')->with('error', 'Order not found.');
            }

            // Check if payment is already processed
            if ($order->payment_status === 'paid') {
                return view('frontend.checkout.checkout_success', compact('order'))
                       ->with('success', 'Payment was already processed successfully!');
            }

            // Verify Stripe payment
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
                // UPDATE PAYMENT STATUS
                $order->update([
                    'payment_status' => 'paid',
                    'status' => 'processing',
                ]);

                Log::info('Payment marked as paid', ['order_id' => $order->id]);

                // UPDATE PRODUCT STOCK
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

                // REMOVE CART ITEMS
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
                    // Fallback: remove all cart items
                    $removedCount = Cart::where('user_id', Auth::id())->delete();
                }

                Log::info('Cart items removed', ['count' => $removedCount]);

                // SEND TELEGRAM NOTIFICATION
                $this->sendTelegramNotification($order);

                DB::commit();

                return view('frontend.checkout.checkout_success', compact('order'))
                       ->with('success', 'Payment successful! Your order has been placed.');

            } else {
                DB::rollBack();
                Log::warning('Payment verification failed', ['order_id' => $orderId]);
                return redirect()->route('frontend.checkout.index')->with('error', 'Payment verification failed. Please contact support.');
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

    /**
     * Send Telegram notification for successful payment using direct API
     */
    private function sendTelegramNotification(Order $order)
    {
        try {
            $botToken = env('TELEGRAM_BOT_TOKEN');
            $chatId = env('TELEGRAM_CHAT_ID');

            if (!$botToken || !$chatId) {
                Log::warning('Telegram bot token or chat ID not configured');
                return false;
            }

            // Build API URL using the full bot token
            $apiUrl = "https://api.telegram.org/{$botToken}/sendMessage";

            // Helper function to escape HTML entities
            $escape = function($text) {
                return str_replace(
                    ['&', '<', '>'],
                    ['&amp;', '&lt;', '&gt;'],
                    $text
                );
            };

            // Build message with proper HTML formatting
            $message = "💰 <b>You Have an Order!</b>\n\n";
            $message .= "🆔 <b>Order ID:</b> #" . $order->id . "\n";
            $message .= "👤 <b>Customer:</b> " . $escape($order->address->first_name . " " . $order->address->last_name) . "\n";
            $message .= "📧 <b>Email:</b> " . $escape($order->user->email ?? 'N/A') . "\n";
            $message .= "📞 <b>Phone:</b> " . $escape($order->address->phone ?? 'N/A') . "\n";
            $message .= "💵 <b>Amount:</b> $" . number_format($order->grand_total, 2) . "\n";
            $message .= "📦 <b>Items:</b> " . $order->orderItems->count() . "\n";
            $message .= "🕒 <b>Date:</b> " . now()->format('Y-m-d H:i:s') . "\n\n";

            // Add order items details
            $message .= "📋 <b>Order Items:</b>\n";
            foreach ($order->orderItems as $item) {
                $message .= "  • " . $escape($item->product->name) . " (Qty: " . $item->quantity . ") - $" . number_format($item->total_amount, 2) . "\n";
            }

            $message .= "\n📍 <b>Shipping Address:</b>\n";
            $message .= $escape($order->address->street_address . ", " . $order->address->city . ", " . $order->address->state . " " . $order->address->zip_code);

            // Build HTTP client with conditional SSL verification
            $httpClient = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]);

            // Disable SSL verification only in local environment
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
