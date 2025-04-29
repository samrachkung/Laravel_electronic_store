@extends('backend.layout.master')
@section('title', 'Sales Dashboard')
@section('sale_menu-open','menu-open')
@section('sale_active','active')
@section('content')

@php
    use App\Models\Order;
@endphp
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Sales Dashboard</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Sales</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ number_format($salesData['today']['transactions']) }}</h3>
                        <p>Today's Transactions</p>
                        <div class="mt-3">
                            <h4>{{ format_currency($salesData['today']['amount']) }}</h4>
                            <p>Today's Sales</p>
                        </div>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ number_format($salesData['week']['transactions']) }}</h3>
                        <p>Weekly Transactions</p>
                        <div class="mt-3">
                            <h4>{{ format_currency($salesData['week']['amount']) }}</h4>
                            <p>Weekly Sales</p>
                        </div>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar-week"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ number_format($salesData['month']['transactions']) }}</h3>
                        <p>Monthly Transactions</p>
                        <div class="mt-3">
                            <h4>{{ format_currency($salesData['month']['amount']) }}</h4>
                            <p>Monthly Sales</p>
                        </div>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ number_format($salesData['year']['transactions']) }}</h3>
                        <p>Yearly Transactions</p>
                        <div class="mt-3">
                            <h4>{{ format_currency($salesData['year']['amount']) }}</h4>
                            <p>Yearly Sales</p>
                        </div>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Sales Trends</h3>
                        <div class="card-tools">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-default range-btn active" data-range="daily">Daily</button>
                                <button type="button" class="btn btn-sm btn-default range-btn" data-range="weekly">Weekly</button>
                                <button type="button" class="btn btn-sm btn-default range-btn" data-range="monthly">Monthly</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="visitors-chart" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Recent Transactions</h3>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Payment Method</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(Order::with('user')->latest()->take(10)->get() as $order)
                                <tr>
                                    <td>#{{ $order->id }}</td>
                                    <td>{{ $order->user->name ?? 'Guest' }}</td>
                                    <td>{{ format_currency($order->grand_total) }}</td>
                                    <td>
                                        <span class="badge badge-{{ getOrderStatusColor($order->status) }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>{{ ucfirst($order->payment_method) }}</td>
                                    <td>{{ $order->created_at->format('M d, Y H:i') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('backend/plugins/chart.js/Chart.min.js') }}"></script>
<script>
    $(function() {
        const ctx = document.getElementById('visitors-chart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar'
            , data: {
                labels: @json($salesTrends['labels'])
                , datasets: [{
                        label: 'Transactions'
                        , data: @json($salesTrends['transactions'])
                        , backgroundColor: 'rgba(54, 162, 235, 0.2)'
                        , borderColor: 'rgba(54, 162, 235, 1)'
                        , borderWidth: 1
                        , yAxisID: 'y-transactions'
                    }
                    , {
                        label: 'Sales Amount'
                        , data: @json($salesTrends['amounts'])
                        , borderColor: 'rgba(255, 99, 132, 1)'
                        , backgroundColor: 'rgba(255, 99, 132, 0.2)'
                        , type: 'line'
                        , yAxisID: 'y-amount'
                    }
                ]
            }
            , options: {
                responsive: true
                , scales: {
                    'y-transactions': {
                        type: 'linear'
                        , display: true
                        , position: 'left'
                        , title: {
                            display: true
                            , text: 'Transactions'
                        }
                    }
                    , 'y-amount': {
                        type: 'linear'
                        , display: true
                        , position: 'right'
                        , title: {
                            display: true
                            , text: 'Sales Amount'
                        }
                        , grid: {
                            drawOnChartArea: false
                        }
                        , ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });

        $('.range-btn').click(function() {
            $('.range-btn').removeClass('active');
            $(this).addClass('active');
            const range = $(this).data('range');

            $.get('/admin/sales/chart-data?range=' + range, function(response) {
                chart.data.labels = response.labels;
                chart.data.datasets[0].data = response.transactions;
                chart.data.datasets[1].data = response.amounts;
                chart.update();
            });
        });
    });

</script>
@endsection
