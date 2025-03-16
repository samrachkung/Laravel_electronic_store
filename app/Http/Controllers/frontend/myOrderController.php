<?php

namespace App\Http\Controllers\frontend;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class myOrderController extends Controller
{
    public function myOrder()
    {
        $code = 'teacher_code';
        $currentdate = now();
        $format_date = $currentdate->format('Ym');
        $invoice_code = "ODIDCODE" . $format_date . "-";
        $orders = Order::where('user_id', Auth::id())->latest()->with(['items.product', 'address'])->get();
        return view('frontend.myorder.myorder', compact('orders' , 'invoice_code'));
    }
    public function printInvoice($orderId)
    {
        $order = Order::with('items', 'address')->find($orderId);
        if (!$order) {
            return redirect()->back()->with('error', 'Order not found');
        }
        $code = 'teacher_code';
        $currentdate = now();
        $format_date = $currentdate->format('Ym');
        $invoice_code = "ODIDCODE" . $format_date . "-";

        // Load the view and pass the necessary data
        $pdf = PDF::loadView('frontend.printInvoice.printInvoice', compact('order', 'invoice_code'));

        // Download the PDF
        return $pdf->download('invoice_' . $invoice_code . $order->id . '.pdf');
    }
}
