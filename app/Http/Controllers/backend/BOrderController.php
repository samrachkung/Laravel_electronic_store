<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class BOrderController extends Controller
{
    /**
     * Display a listing of all orders (Admin View).
     */
    public function index()
    {
        $code = 'teacher_code';
        $currentdate = now();
        $format_date = $currentdate->format('Ym');
        $invoice_code = "ODIDCODE" . $format_date . "-";
        $orders = Order::with(['items.product', 'address', 'user'])->latest()->get();
        return view('backend.orders.index', compact('orders', 'invoice_code'));
    }

    /**
     * Display the orders for the authenticated user.
     */
    public function userOrders()
    {
        $orders = Order::where('user_id', Auth::id())->with(['items.product', 'address'])->latest()->get();
        return view('frontend.orders.index', compact('orders'));
    }
    public function show($id)
    {
        $order = Order::with(['items.product', 'address', 'user'])->findOrFail($id);
        return view('backend.orders.show', compact('order'));
    }

    /**
     * Store a new order.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip_code' => 'required',
            'payment_method' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => Auth::id(),
                'grand_total' => $request->cartTotal,
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'status' => 'new',
                'currency' => 'USD',
                'shipping_amount' => 5.00,
                'shipping_method' => 'Standard',
            ]);

            $address = new Address([
                'order_id' => $order->id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'street_address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'zip_code' => $request->zip_code,
            ]);
            $order->address()->save($address);

            foreach ($request->cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_amount' => $item['price'],
                    'total_amount' => $item['price'] * $item['quantity'],
                ]);
            }

            DB::commit();
            return response()->json(['message' => 'Order placed successfully!', 'order_id' => $order->id], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Something went wrong!'], 500);
        }
    }

    /**
     * Update the order status.
     */
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();
        return redirect()->back()->with('success', 'Order status updated successfully!');
    }

    /**
     * Delete an order.
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->back()->with('success', 'Order deleted successfully!');
    }
}

