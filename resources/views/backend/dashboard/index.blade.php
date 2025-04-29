@extends('backend.layout.master')
@section('d_menu-open','menu-open')
@section('d_active','active')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- Order Statistics -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="card-title">Order Statistics</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="info-box mb-3 bg-info">
                                    <span class="info-box-icon"><i class="fas fa-shopping-cart"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Today's Orders</span>
                                        <span class="info-box-number">{{ $todayOrders }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="info-box mb-3 bg-success">
                                    <span class="info-box-icon"><i class="fas fa-dollar-sign"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Today's Revenue</span>
                                        <span class="info-box-number">{{ format_currency($todayRevenue) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="info-box mb-3 bg-warning">
                                    <span class="info-box-icon"><i class="fas fa-users"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">New Customers</span>
                                        <span class="info-box-number">{{ $newCustomers }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="info-box mb-3 bg-danger">
                                    <span class="info-box-icon"><i class="fas fa-percentage"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Conversion Rate</span>
                                        <span class="info-box-number">{{ $conversionRate }}%</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Status Chart -->
                        <div class="position-relative mb-4">
                            <canvas id="order-status-chart" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sales Overview -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">Sales Overview</h3>
                            <div class="btn-group">
                                <button type="button" class="btn btn-xs btn-default timeframe-btn" data-timeframe="week">Week</button>
                                <button type="button" class="btn btn-xs btn-default timeframe-btn active" data-timeframe="month">Month</button>
                                <button type="button" class="btn btn-xs btn-default timeframe-btn" data-timeframe="year">Year</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                            <p class="d-flex flex-column">
                                <span class="text-bold text-lg">{{ format_currency($currentPeriodSales) }}</span>
                                <span>Current Period Sales</span>
                            </p>
                            <p class="ml-auto d-flex flex-column text-right">
                                <span class="{{ $salesChangePercentage >= 0 ? 'text-success' : 'text-danger' }}">
                                    <i class="fas fa-arrow-{{ $salesChangePercentage >= 0 ? 'up' : 'down' }}"></i>
                                    {{ abs($salesChangePercentage) }}%
                                </span>
                                <span class="text-muted">vs Previous Period</span>
                            </p>
                        </div>
                        <div class="position-relative mb-4">
                            <canvas id="visitors-chart" height="200"></canvas>
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
    document.addEventListener('DOMContentLoaded', function() {
        // Sales Trend Chart
        const salesCtx = document.getElementById('visitors-chart').getContext('2d');
        const salesChart = new Chart(salesCtx, {
            type: 'line'
            , data: {
                labels: @json($salesTrendLabels)
                , datasets: [{
                    label: 'Sales'
                    , data: @json($salesTrendData)
                    , borderColor: '#007bff'
                    , backgroundColor: 'rgba(0, 123, 255, 0.1)'
                    , fill: true
                }]
            }
            , options: {
                responsive: true
                , scales: {
                    y: {
                        beginAtZero: true
                        , ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });

        // Order Status Chart
        const statusCtx = document.getElementById('order-status-chart').getContext('2d');
        const statusChart = new Chart(statusCtx, {
            type: 'doughnut'
            , data: {
                labels: @json($orderStatusLabels)
                , datasets: [{
                    data: @json($orderStatusData)
                    , backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b']
                }]
            }
        });

        // Timeframe selector
        document.querySelectorAll('.timeframe-btn').forEach(button => {
            button.addEventListener('click', function() {
                document.querySelectorAll('.timeframe-btn').forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                const timeframe = this.dataset.timeframe;

                fetch(`/admin/dashboard/data?timeframe=${timeframe}`)
                    .then(response => response.json())
                    .then(data => {
                        salesChart.data.labels = data.labels;
                        salesChart.data.datasets[0].data = data.values;
                        salesChart.update();
                    });
            });
        });
    });

</script>
@endsection
