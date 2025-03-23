<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Address;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = Auth::user()->cart ?? collect();
        $cartTotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity) ?? 0;

        return view('frontend.checkout.checkout', compact('cartItems', 'cartTotal'));
    }

    public function placeOrder(Request $request)
    {
        DB::beginTransaction();
        try {
            $cartItems = Auth::user()->cart ?? collect();
            if ($cartItems->isEmpty()) {
                return response()->json(['error' => 'Your cart is empty.'], 400);
            }

            $grandTotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

            // Create Order
            $order = Order::create([
                'user_id' => Auth::id(),
                'grand_total' => $grandTotal,
                'payment_method' => 'Stripe',
                'payment_status' => 'pending',
                'status' => 'new',
                'currency' => 'USD',
                'expected_arrival' => now(),
            ]);

            // Save Address
            Address::create([
                'order_id' => $order->id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'street_address' => $request->address,
                'city' => $request->city,
                'state' => $request->state ?? 'Unknown', // Ensure fallback
                'zip_code' => $request->zip_code ?? '00000', // Ensure fallback
            ]);

            // Save Order Items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product->id,
                    'quantity' => $item->quantity,
                    'unit_amount' => $item->product->price,
                    'total_amount' => $item->product->price * $item->quantity,
                ]);
            }

            // Prepare Stripe Items
            $lineItems = [];
            foreach ($cartItems as $item) {
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $item->product->name,
                        ],
                        'unit_amount' => $item->product->price * 100,
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
                'success_url' => route('checkout.success', ['order' => $order->id], true),
                'cancel_url' => route('checkout.cancel', ['order' => $order->id], true),
            ]);

            DB::commit();
            return response()->json(['url' => $session->url]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Something went wrong. ' . $e->getMessage()], 500);
        }
    }


    private function processStripePayment($order)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $cartItems = Auth::user()->cart;
        $lineItems = [];

        foreach ($cartItems as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $item->product->name,
                    ],
                    'unit_amount' => $item->product->price * 100, // Convert to cents
                ],
                'quantity' => $item->quantity,
            ];
        }

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success', ['order' => $order->id], true),
            'cancel_url' => route('checkout.cancel', ['order' => $order->id], true),
        ]);

        return redirect($session->url);
    }

    public function success(Request $request)
    {
        $orderId = $request->order;
        $order = Order::findOrFail($orderId);

        // Update order payment status
        $order->update([
            'payment_status' => 'paid',
            'payment_method' => 'Stripe',
            'status' => 'processing',
        ]);

        // Clear cart after successful payment
        Cart::where('user_id', Auth::id())->delete();

        return view('frontend.checkout.checkout_success')->with('success', 'Payment successful! Your order has been placed.');
    }

    public function cancel(Request $request)
    {

        return redirect()->route('checkout.index')->with('error', 'Payment was canceled. Please try again.');
    }
}
