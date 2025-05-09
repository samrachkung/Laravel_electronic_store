<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

class IncomeController extends Controller
{
    /**
     * Display income dashboard with analytics
     */
    public function index()
    {
        $today = Carbon::today();

        $totalIncome = Order::sum('grand_total');
        $todayIncome = Order::whereDate('created_at', $today)->sum('grand_total');
        $monthIncome = Order::whereMonth('created_at', $today->month)
            ->whereYear('created_at', $today->year)
            ->sum('grand_total');

        $recentOrders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $statusCounts = Order::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');

        $monthlyIncome = Order::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(grand_total) as total')
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $chartLabels = [];
        $chartData = [];

        foreach ($monthlyIncome as $income) {
            $monthName = Carbon::createFromDate($income->year, $income->month, 1)->format('M Y');
            $chartLabels[] = $monthName;
            $chartData[] = $income->total;
        }

        return view('backend.income.income', compact(
            'totalIncome',
            'todayIncome',
            'monthIncome',
            'recentOrders',
            'statusCounts',
            'chartLabels',
            'chartData'
        ));
    }

    /**
     * Show specific order
     */
    public function show(Order $order)
    {
        return view('backend.income.show', compact('order'));
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:new,processing,shipped,delivered,canceled'
        ]);

        $order->update($validated);

        return back()->with('success', 'Order status updated successfully');
    }

    /**
     * Return chart data for AJAX based on range
     */
    public function getIncomeData(Request $request)
    {
        $range = $request->input('range', 'monthly');

        switch ($range) {
            case 'weekly':
                $data = Order::selectRaw('
                        YEAR(created_at) as year,
                        WEEK(created_at) as week,
                        SUM(grand_total) as total')
                    ->groupBy('year', 'week')
                    ->orderBy('year', 'asc')
                    ->orderBy('week', 'asc')
                    ->get();

                $labels = $data->map(function ($item) {
                    return 'Week ' . $item->week . ' ' . $item->year;
                });
                break;

            case 'daily':
                $data = Order::selectRaw('
                        DATE(created_at) as date,
                        SUM(grand_total) as total')
                    ->groupBy('date')
                    ->orderBy('date', 'asc')
                    ->get();

                $labels = $data->map(function ($item) {
                    return Carbon::parse($item->date)->format('M d');
                });
                break;

            default: // monthly
                $data = Order::selectRaw('
                        YEAR(created_at) as year,
                        MONTH(created_at) as month,
                        SUM(grand_total) as total')
                    ->groupBy('year', 'month')
                    ->orderBy('year', 'asc')
                    ->orderBy('month', 'asc')
                    ->get();

                $labels = $data->map(function ($item) {
                    return Carbon::createFromDate($item->year, $item->month, 1)->format('M Y');
                });
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data->pluck('total')
        ]);
    }

}
