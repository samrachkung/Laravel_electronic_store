<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BDashboardController extends Controller
{
    public function index()
    {
        // Existing stats
        $todayOrders = Order::whereDate('created_at', today())->count();
        $todayRevenue = Order::whereDate('created_at', today())->sum('grand_total');

        // New metrics
        $totalSales = Order::where('payment_status', 'paid')->sum('grand_total');
        $totalProductsSold = OrderItem::sum('quantity');
        $averageOrderValue = Order::where('payment_status', 'paid')->avg('grand_total');

        $currentPeriodSales = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [now()->subMonth(), now()])
            ->sum('grand_total');

        $previousPeriodSales = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [now()->subMonths(2), now()->subMonth()])
            ->sum('grand_total');

        $salesChangePercentage = $previousPeriodSales > 0
            ? round((($currentPeriodSales - $previousPeriodSales) / $previousPeriodSales) * 100, 2)
            : 0;

        $salesTrendData = Order::selectRaw('DATE(created_at) as date, SUM(grand_total) as total')
            ->where('payment_status', 'paid')
            ->whereBetween('created_at', [now()->subMonth(), now()])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $salesTrendLabels = $salesTrendData->pluck('date')->map(function ($date) {
            return Carbon::parse($date)->format('M d');
        });

        $salesTrendValues = $salesTrendData->pluck('total');

        // Product data
        $topProducts = OrderItem::with('product')
            ->selectRaw('product_id, sum(quantity) as total_sold, sum(total_amount) as total_revenue')
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->take(10)
            ->get()
            ->map(function ($item) {
                $product = $item->product;
                return (object) [
                    'name' => $product->name,
                    'price' => $product->price,
                    'total_sold' => $item->total_sold,
                    'total_revenue' => $item->total_revenue,
                    'quantity' => $product->quantity,
                    'initial_quantity' => $product->initial_quantity,
                    'sales_trend' => $this->calculateProductTrend($product->id),
                    'image' => $product->image
                ];
            });

        // Payment methods breakdown
        $paymentMethods = Order::selectRaw('payment_method as name,
            count(*) as count,
            sum(grand_total) as total,
            case
                when payment_method = "credit_card" then "primary"
                when payment_method = "paypal" then "info"
                else "success"
            end as color')
            ->groupBy('payment_method')
            ->get();

        // Low quantity products
        $lowquantityProducts = Product::where('quantity', '<=', 10)
            ->orderBy('quantity')
            ->take(5)
            ->get();


        // Recent orders
        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('backend.dashboard.index', compact(
            'todayOrders',
            'todayRevenue',
            'totalSales',
            'totalProductsSold',
            'averageOrderValue',
            'topProducts',
            'paymentMethods',
            'lowquantityProducts',
            'recentOrders',
            'salesChangePercentage',
            'currentPeriodSales',
            'salesTrendLabels',
            'salesTrendData'
        ));

    }

    private function calculateProductTrend($productId)
    {
        $currentPeriod = OrderItem::whereHas('order', function ($q) {
            $q->whereBetween('created_at', [now()->subMonth(), now()]);
        })
            ->where('product_id', $productId)
            ->sum('quantity');

        $previousPeriod = OrderItem::whereHas('order', function ($q) {
            $q->whereBetween('created_at', [now()->subMonths(2), now()->subMonth()]);
        })
            ->where('product_id', $productId)
            ->sum('quantity');

        if ($previousPeriod == 0)
            return 0;

        return round(($currentPeriod - $previousPeriod) / $previousPeriod * 100, 2);
    }
}
