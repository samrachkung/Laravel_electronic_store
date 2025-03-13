<?php

namespace App\Http\Controllers\frontend;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
}
