<?php

namespace App\Http\Controllers\frontend;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class MyOrderController extends Controller
{
    public function myOrder()
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('frontend.login')->with('error', 'Please login to view your orders.');
        }

        $invoice_code = "ODIDCODE" . "-";

        // Use with() to eager load relationships and handle null cases
        $orders = Order::where('user_id', Auth::id())
                      ->latest()
                      ->with(['orderItems.product', 'address'])
                      ->get();

        return view('frontend.myorder.myorder', compact('orders', 'invoice_code'));
    }

public function printInvoice($orderId)
{
    // Use 'orderItems' instead of 'items'
    $order = Order::with(['orderItems.product', 'address'])
                 ->where('user_id', Auth::id())
                 ->find($orderId);

    if (!$order) {
        return redirect()->back()->with('error', 'Order not found');
    }

    $invoice_code = "ODIDCODE" . "-";

    $pdf = PDF::loadView('frontend.printInvoice.printInvoice', compact('order', 'invoice_code'));

    return $pdf->download('invoice_' . $invoice_code . $order->id . '.pdf');
}
}
