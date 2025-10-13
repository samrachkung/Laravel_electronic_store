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
        $code = 'invoice_code';
        $invoice_code = "ODIDCODE" . "-";

        // Use 'orderItems' instead of 'items' and make sure to load the product relationship
        $orders = Order::where('user_id', Auth::id())
                      ->latest()
                      ->with(['orderItems.product', 'address'])
                      ->get();

        return view('frontend.myorder.myorder', compact('orders', 'invoice_code'));
    }

    public function printInvoice($orderId)
    {
        // Use 'orderItems' instead of 'items' and load the product relationship
        $order = Order::with(['orderItems.product', 'address'])->find($orderId);

        if (!$order) {
            return redirect()->back()->with('error', 'Order not found');
        }

        // Verify the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized access');
        }

        $code = 'invoice_code';
        $invoice_code = "ODIDCODE" . "-";

        // Load the view and pass the necessary data
        $pdf = PDF::loadView('frontend.printInvoice.printInvoice', compact('order', 'invoice_code'));

        // Download the PDF
        return $pdf->download('invoice_' . $invoice_code . $order->id . '.pdf');
    }
}
