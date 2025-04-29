<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BSaleController extends Controller
{
    /**
     * Display sales dashboard
     */
    public function index()
    {
        // Date ranges with proper start/end times
        $todayStart = Carbon::today()->startOfDay();
        $todayEnd = Carbon::today()->endOfDay();
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $startOfYear = Carbon::now()->startOfYear();
        $endOfYear = Carbon::now()->endOfYear();

        // Sales calculations with corrected date ranges
        $salesData = [
            'today' => $this->getSalesData($todayStart, $todayEnd),
            'week' => $this->getSalesData($startOfWeek, $endOfWeek),
            'month' => $this->getSalesData($startOfMonth, $endOfMonth),
            'year' => $this->getSalesData($startOfYear, $endOfYear),
            'total' => [
                'transactions' => Order::where('payment_status', 'paid')->count(),
                'amount' => Order::where('payment_status', 'paid')->sum('grand_total')
            ]
        ];

        // Sales trends for chart
        $salesTrends = $this->getSalesTrends();

        return view('backend.sale.sale', compact('salesData', 'salesTrends'));
    }

    protected function getSalesData($startDate, $endDate)
    {
        return [
            'transactions' => Order::where('payment_status', 'paid')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count(),
            'amount' => Order::where('payment_status', 'paid')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('grand_total')
        ];
    }


    protected function getSalesTrends()
    {
        $sales = Order::where('payment_status', 'paid')
            ->selectRaw('DATE(created_at) as date,
                        COUNT(*) as transactions,
                        SUM(grand_total) as amount')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'labels' => $sales->pluck('date')->map(function ($date) {
                return Carbon::parse($date)->format('M d');
            }),
            'transactions' => $sales->pluck('transactions'),
            'amounts' => $sales->pluck('amount')
        ];
    }

    public function getChartData($range)
    {
        switch ($range) {
            case 'weekly':
                $data = Order::where('payment_status', 'paid')
                    ->selectRaw('YEARWEEK(created_at) as period,
                               COUNT(*) as transactions,
                               SUM(grand_total) as amount')
                    ->groupBy('period')
                    ->orderBy('period')
                    ->get();

                $labels = $data->map(function ($item) {
                    return 'Week ' . Carbon::createFromFormat('Y-m-d', substr($item->period, 0, 4) . '-01-01')
                        ->addWeeks(substr($item->period, 4))->format('W, Y');
                });
                break;

            case 'monthly':
                $data = Order::where('payment_status', 'paid')
                    ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as period,
                               COUNT(*) as transactions,
                               SUM(grand_total) as amount')
                    ->groupBy('period')
                    ->orderBy('period')
                    ->get();

                $labels = $data->map(function ($item) {
                    return Carbon::createFromFormat('Y-m', $item->period)->format('M Y');
                });
                break;

            default: // daily
                $data = Order::where('payment_status', 'paid')
                    ->selectRaw('DATE(created_at) as period,
                               COUNT(*) as transactions,
                               SUM(grand_total) as amount')
                    ->groupBy('period')
                    ->orderBy('period')
                    ->get();

                $labels = $data->map(function ($item) {
                    return Carbon::parse($item->period)->format('M d');
                });
        }

        return response()->json([
            'labels' => $labels,
            'transactions' => $data->pluck('transactions'),
            'amounts' => $data->pluck('amount')
        ]);
    }
}
