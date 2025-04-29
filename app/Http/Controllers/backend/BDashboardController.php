<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BDashboardController extends Controller
{
    public function index()
    {
        // Today's statistics
        $today = Carbon::today();
        $todayOrders = Order::whereDate('created_at', $today)->count();
        $todayRevenue = Order::whereDate('created_at', $today)->sum('grand_total');

        // New customers (last 7 days)
        $newCustomers = User::where('created_at', '>=', Carbon::now()->subDays(7))->count();

        // Conversion rate (orders vs visitors - modify according to your analytics)
        $conversionRate = 0; // Add your conversion logic

        // Top selling products
        $topProducts = OrderItem::with('product')
            ->selectRaw('product_id, sum(quantity) as total_sold, sum(total_amount) as total_revenue')
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        // Sales trend data
        $salesTrend = $this->getSalesTrend('month');
        $orderStatus = $this->getOrderStatusData();

        return view('backend.dashboard.index', array_merge(
            compact(
                'todayOrders',
                'todayRevenue',
                'newCustomers',
                'conversionRate',
                'topProducts'
            ),
            $salesTrend,
            $orderStatus
        ));
    }

    private function getSalesTrend($timeframe)
    {
        $end = Carbon::now();
        $format = 'Y-m-d';

        switch ($timeframe) {
            case 'week':
                $start = $end->copy()->subWeek();
                break;
            case 'year':
                $start = $end->copy()->subYear();
                $format = 'Y-m';
                break;
            default: // month
                $start = $end->copy()->subMonth();
                $format = 'Y-m-d';
        }

        $data = Order::whereBetween('created_at', [$start, $end])
            ->selectRaw("DATE_FORMAT(created_at, '{$format}') as period, sum(grand_total) as total")
            ->groupBy('period')
            ->orderBy('period')
            ->get();

        return [
            'salesTrendLabels' => $data->pluck('period'),
            'salesTrendData' => $data->pluck('total')->map(function ($value) {
                return $value ?? 0; // Replace NULL with 0
            }),
            'currentPeriodSales' => $data->sum('total'),
            'salesChangePercentage' => $this->calculateSalesChange($start, $end)
        ];

    }

    private function calculateSalesChange($start, $end)
    {
        $previousStart = $start->copy()->subDays($end->diffInDays($start))->addDay();
        $previousEnd = $start->copy()->subDay();

        $currentSales = Order::whereBetween('created_at', [$start, $end])->sum('grand_total');
        $previousSales = Order::whereBetween('created_at', [$previousStart, $previousEnd])->sum('grand_total');

        if ($previousSales == 0)
            return 0;

        return round(($currentSales - $previousSales) / $previousSales * 100, 2);
    }

    private function getOrderStatusData()
    {
        $statuses = Order::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->get();

        return [
            'orderStatusLabels' => $statuses->pluck('status'),
            'orderStatusData' => $statuses->pluck('count')
        ];
    }

    public function getChartData()
    {
        $timeframe = request('timeframe', 'month');
        $data = $this->getSalesTrend($timeframe);

        return response()->json([
            'labels' => $data['salesTrendLabels'],
            'values' => $data['salesTrendData']
        ]);
    }
}
