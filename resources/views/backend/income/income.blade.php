@extends('backend.layout.master')
@section('title', 'Income Dashboard')
@section('in_menu-open','menu-open')
@section('in_active','active')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Income</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Income</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat boxes) -->
        <div class="row">
            <div class="col-lg-4 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>$ {{ number_format($totalIncome, 2) }}</h3>
                        <p>Total Income</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-4 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>$ {{ number_format($todayIncome, 2) }}</h3>
                        <p>Today's Income</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-4 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>$ {{ number_format($monthIncome, 2) }}</h3>
                        <p>Monthly Income</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <div class="col-lg-12">
                <!-- Income Chart -->
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">Income Overview</h3>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-default range-btn" data-range="daily" id="daily-btn">Daily</button>
                                <button type="button" class="btn btn-sm btn-default range-btn" data-range="weekly" id="weekly-btn">Weekly</button>
                                <button type="button" class="btn btn-sm btn-default range-btn active" data-range="monthly" id="monthly-btn">Monthly</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="position-relative mb-4">
                            <canvas id="sales-chart" height="300"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="card-title">Recent Orders</h3>
                        <div class="card-tools">
                            <a href="#" class="btn btn-tool btn-sm">
                                <i class="fas fa-download"></i>
                            </a>
                            <a href="#" class="btn btn-tool btn-sm">
                                <i class="fas fa-bars"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-striped table-valign-middle">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                <tr>
                                    <td>#{{ $order->id }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>{{ number_format($order->grand_total, 2) }}</td>
                                    <td>
                                        <span class="badge badge-{{ getStatusColor($order->status) }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="text-muted">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(function() {
        'use strict'
        // Income Chart
        var incomeChart = new Chart($('#sales-chart'), {
            type: 'line'
            , data: {
                labels: @json($chartLabels)
                , datasets: [{
                    label: 'Income'
                    , backgroundColor: 'rgba(60,141,188,0.9)'
                    , borderColor: 'rgba(60,141,188,0.8)'
                    , pointRadius: false
                    , pointColor: '#3b8bba'
                    , pointStrokeColor: 'rgba(60,141,188,1)'
                    , pointHighlightFill: '#fff'
                    , pointHighlightStroke: 'rgba(60,141,188,1)'
                    , data: @json($chartData)
                }]
            }
            , options: {
                maintainAspectRatio: false
                , responsive: true
                , legend: {
                    display: false
                }
                , scales: {
                    xAxes: [{
                        gridLines: {
                            display: false
                        }
                    }]
                    , yAxes: [{
                        gridLines: {
                            display: false
                        }
                        , ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    }]
                }
            }
        });

        // Status Chart (Pie)
        var statusChart = new Chart($('#status-chart'), {
            type: 'doughnut'
            , data: {
                labels: @json(array_keys($statusCounts -> toArray()))
                , datasets: [{
                    data: @json(array_values($statusCounts -> toArray()))
                    , backgroundColor: [
                        @foreach($statusCounts as $status => $count)
                        '{{ getStatusColor($status) }}'
                        , @endforeach
                    ]
                }]
            }
            , options: {
                maintainAspectRatio: false
                , responsive: true
                , legend: {
                    display: false
                }
            }
        });

        // Range selector
        $(document).on('click', '.range-btn', function() {
            $('.range-btn').removeClass('active');
            $(this).addClass('active');

            var range = $(this).data('range');

            $.ajax({
                url: '/income/data'
                , type: 'GET'
                , data: {
                    range: range
                }
                , success: function(data) {
                    incomeChart.data.labels = data.labels;
                    incomeChart.data.datasets[0].data = data.data;
                    incomeChart.update();
                }
                , error: function(xhr) {
                    console.error('Error fetching data:', xhr.responseText);
                }
            });
        });
    });

    $(document).on('click', '#daily-btn', function() {
        $(this).addClass('active');
        $('#weekly-btn, #monthly-btn').removeClass('active');
    });
    $(document).on('click', '#weekly-btn', function() {
        $(this).addClass('active');
        $('#daily-btn, #monthly-btn').removeClass('active');
    });
    $(document).on('click', '#monthly-btn', function() {
        $(this).addClass('active');
        $('#daily-btn, #weekly-btn').removeClass('active');
    });


</script>

@endsection
