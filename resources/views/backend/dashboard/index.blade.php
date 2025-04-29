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
        <!-- Quick Stats Row -->
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3 bg-primary">
                    <span class="info-box-icon"><i class="fas fa-cash-register"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Earning</span>
                        <span class="info-box-number">{{ format_currency($totalSales) }}</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3 bg-success">
                    <span class="info-box-icon"><i class="fas fa-boxes"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Products Sold</span>
                        <span class="info-box-number">{{ $totalProductsSold }}</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3 bg-warning">
                    <span class="info-box-icon"><i class="fas fa-percentage"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Avg. Order Value</span>
                        <span class="info-box-number">{{ format_currency($averageOrderValue) }}</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3 bg-danger">
                    <span class="info-box-icon"><i class="fas fa-exclamation-triangle"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Low Stock Items</span>
                        <span class="info-box-number">{{ $lowquantityProducts->count() }}</span>

                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Row -->
        <div class="row">
            <!-- Left Column -->
            <div class="col-lg-8">
                <!-- Sales Overview -->
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
                        <div class="position-relative mb-4">
                            <canvas id="visitors-chart" height="100"></canvas>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div>

                                @if($salesChangePercentage > 0)
                                <span class="text-success">
                                    <i class="fas fa-arrow-up"></i> {{ $salesChangePercentage }}%
                                </span>
                                @elseif($salesChangePercentage < 0) <span class="text-danger">
                                    <i class="fas fa-arrow-down"></i> {{ abs($salesChangePercentage) }}%
                                    </span>
                                    @else
                                    <span class="text-muted">0%</span>
                                    @endif



                            </div>
                            <div>
                                <span class="text-muted">Total: </span>
                                <span class="font-weight-bold">{{ format_currency($currentPeriodSales) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Performance -->
                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="card-title">Product Performance</h3>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-striped table-valign-middle">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Sold</th>
                                    <th>Revenue</th>
                                    <th>Stock</th>
                                    <th>Trend</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topProducts as $product)
                                <tr>
                                    <td>
                                        <img src="{{ $product->image ? asset('storage/'.$product->image) : asset('backend/dist/img/default-150x150.png') }}" alt="{{ $product->name }}" class="img-circle img-size-32 mr-2">
                                        {{ $product->name }}
                                    </td>
                                    <td>{{ format_currency($product->price) }}</td>
                                    <td>{{ $product->total_sold }}</td>
                                    <td>{{ format_currency($product->total_revenue) }}</td>
                                    <td>
                                        <div class="progress progress-xs">
                                            <div class="progress-bar bg-{{ $product->quantity  <= 10 ? 'danger' : 'success' }}" style="width: {{ ($product->quantity ) * 100 }}%">


                                            </div>
                                        </div>
                                        <small>{{ $product->quantity }} remaining</small>

                                    </td>
                                    <td class="text-center">
                                        @if($product->sales_trend > 0)
                                        <span class="text-success"><i class="fas fa-arrow-up"></i> {{ $product->sales_trend }}%</span>
                                        @elseif($product->sales_trend < 0) <span class="text-danger"><i class="fas fa-arrow-down"></i> {{ abs($product->sales_trend) }}%</span>
                                            @else
                                            <span class="text-muted">-</span>
                                            @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-lg-4">
                <!-- Income Breakdown -->
                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="card-title">Income Breakdown</h3>
                    </div>
                    <div class="card-body">
                        <div class="position-relative mb-4">
                            <canvas id="sales-chart" height="150"></canvas>
                        </div>
                        <div class="row">
                            @foreach($paymentMethods as $method)
                            <div class="col-6">
                                <div class="bg-{{ $method->color }} p-2 mb-2 text-center">
                                    <span class="text-white">Pay By : {{ $method->name }}</span>
                                    <br>
                                    <span class="text-white">ToTal : {{ format_currency($method->total) }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Recent Transactions -->
                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="card-title">Recent Transactions</h3>
                    </div>
                    <div class="card-body p-0">
                        <ul class="products-list product-list-in-card pl-2 pr-2">
                            @foreach($recentOrders as $order)
                            <li class="item">
                                <div class="product-info">
                                    <a href="{{ route('orders.show', $order->id) }}" class="product-title">
                                        Order #{{ $order->id }}
                                        <span class="badge badge-{{ getOrderStatusColor($order->status) }} float-right">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </a>
                                    <span class="product-description">
                                        {{ $order->user->name ?? 'Guest' }} -
                                        {{ format_currency($order->grand_total) }} -
                                        {{ $order->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Low Stock Alert -->
                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="card-title">Low Stock Alert</h3>
                    </div>
                    <div class="card-body p-0">
                        <ul class="products-list product-list-in-card pl-2 pr-2">
                            @foreach($lowquantityProducts as $product)

                            <li class="item">
                                <div class="product-info">
                                    <a href="{{url('product/'.$product->id)}}" class="product-title">

                                        {{ $product->name }}
                                        <span class="badge badge-danger float-right">{{ $product->quantity }} left</span>
                                    </a>
                                </div>
                            </li>
                            @endforeach
                        </ul>
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

        // Income Breakdown Chart
        const incomeCtx = document.getElementById('sales-chart').getContext('2d');
        const incomeChart = new Chart(incomeCtx, {
            type: 'doughnut'
            , data: {
                labels: @json($paymentMethods->pluck('name'))
                , datasets: [{
                    data: @json($paymentMethods -> pluck('total'))
                    , backgroundColor: @json($paymentMethods -> pluck('color')).map(color => {
                        const colors = {
                            primary: '#007bff'
                            , success: '#28a745'
                            , info: '#17a2b8'
                            , warning: '#ffc107'
                            , danger: '#dc3545'
                        };
                        return colors[color] || '#6c757d';
                    })
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

    const ctx = document.getElementById('visitors-chart').getContext('2d');
    const salesTrendChart = new Chart(ctx, {
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

</script>
@endsection
