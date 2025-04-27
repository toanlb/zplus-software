@extends('admin.layouts.app')

@section('title', 'Thống kê tải xuống')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Thống kê tải xuống</h1>
    
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.downloads.index') }}">Tải xuống</a></li>
        <li class="breadcrumb-item active">Thống kê</li>
    </ol>
    
    <!-- Thẻ tổng quan -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-chart-bar me-1"></i>
            Tổng quan lượt tải
        </div>
        <div class="card-body">
            <div class="row text-center">
                <div class="col-lg-3 col-md-6">
                    <div class="mb-3">
                        <h2 class="display-4">{{ $totalDownloads }}</h2>
                        <div class="text-muted">Tổng lượt tải</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="mb-3">
                        <h2 class="display-4">{{ count($downloadsByProduct) }}</h2>
                        <div class="text-muted">Sản phẩm đã được tải</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="mb-3">
                        <h2 class="display-4">{{ count($topUsers) }}</h2>
                        <div class="text-muted">Khách hàng tốp đầu</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="mb-3">
                        <h2 class="display-4">
                            @if(count($downloadsByProduct) > 0)
                                {{ $downloadsByProduct[0]->name }}
                            @else
                                -
                            @endif
                        </h2>
                        <div class="text-muted">Sản phẩm phổ biến nhất</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Biểu đồ tải xuống theo ngày -->
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-area me-1"></i>
                    Lượt tải theo ngày (tháng hiện tại)
                </div>
                <div class="card-body">
                    <canvas id="dailyDownloadsChart" width="100%" height="300"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Biểu đồ tải xuống theo tháng -->
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-1"></i>
                    Lượt tải theo tháng (6 tháng gần đây)
                </div>
                <div class="card-body">
                    <canvas id="monthlyDownloadsChart" width="100%" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Sản phẩm được tải nhiều nhất -->
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-box-open me-1"></i>
                    Top 10 sản phẩm được tải nhiều nhất
                </div>
                <div class="card-body">
                    <canvas id="productDownloadsChart" width="100%" height="300"></canvas>
                </div>
                <div class="card-footer small text-muted">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Sản phẩm</th>
                                    <th class="text-end">Lượt tải</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($downloadsByProduct as $index => $product)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td class="text-end">{{ $product->total_downloads }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Khách hàng tải nhiều nhất -->
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-users me-1"></i>
                    Top 5 khách hàng tải nhiều nhất
                </div>
                <div class="card-body">
                    <canvas id="userDownloadsChart" width="100%" height="300"></canvas>
                </div>
                <div class="card-footer small text-muted">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Khách hàng</th>
                                    <th>Email</th>
                                    <th class="text-end">Lượt tải</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topUsers as $index => $user)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <a href="{{ route('admin.customers.show', $user->id) }}">
                                                {{ $user->name }}
                                            </a>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td class="text-end">{{ $user->total_downloads }}</td>
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Biểu đồ tải xuống theo ngày
        const dailyDownloadsCtx = document.getElementById('dailyDownloadsChart').getContext('2d');
        new Chart(dailyDownloadsCtx, {
            type: 'line',
            data: {
                labels: [
                    @foreach($downloadsByDay as $item)
                        '{{ \Carbon\Carbon::parse($item->date)->format('d/m') }}',
                    @endforeach
                ],
                datasets: [{
                    label: 'Lượt tải',
                    data: [
                        @foreach($downloadsByDay as $item)
                            {{ $item->count }},
                        @endforeach
                    ],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    tension: 0.1,
                    pointRadius: 3,
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Lượt tải xuống theo ngày'
                    }
                },
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });

        // Biểu đồ tải xuống theo tháng
        const monthlyDownloadsCtx = document.getElementById('monthlyDownloadsChart').getContext('2d');
        new Chart(monthlyDownloadsCtx, {
            type: 'bar',
            data: {
                labels: [
                    @foreach($downloadsByMonth as $item)
                        '{{ \Carbon\Carbon::create($item->year, $item->month, 1)->format('m/Y') }}',
                    @endforeach
                ],
                datasets: [{
                    label: 'Lượt tải',
                    data: [
                        @foreach($downloadsByMonth as $item)
                            {{ $item->count }},
                        @endforeach
                    ],
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Lượt tải xuống theo tháng'
                    }
                },
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });

        // Biểu đồ top sản phẩm
        const productDownloadsCtx = document.getElementById('productDownloadsChart').getContext('2d');
        new Chart(productDownloadsCtx, {
            type: 'bar',
            data: {
                labels: [
                    @foreach($downloadsByProduct as $product)
                        '{{ Str::limit($product->name, 20) }}',
                    @endforeach
                ],
                datasets: [{
                    label: 'Lượt tải',
                    data: [
                        @foreach($downloadsByProduct as $product)
                            {{ $product->total_downloads }},
                        @endforeach
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(153, 102, 255, 0.6)',
                        'rgba(255, 159, 64, 0.6)',
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(75, 192, 192, 0.6)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
                plugins: {
                    title: {
                        display: true,
                        text: 'Top 10 sản phẩm được tải nhiều nhất'
                    },
                    legend: {
                        display: false
                    }
                },
                responsive: true,
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });

        // Biểu đồ top người dùng
        const userDownloadsCtx = document.getElementById('userDownloadsChart').getContext('2d');
        new Chart(userDownloadsCtx, {
            type: 'bar',
            data: {
                labels: [
                    @foreach($topUsers as $user)
                        '{{ $user->name }}',
                    @endforeach
                ],
                datasets: [{
                    label: 'Lượt tải',
                    data: [
                        @foreach($topUsers as $user)
                            {{ $user->total_downloads }},
                        @endforeach
                    ],
                    backgroundColor: 'rgba(153, 102, 255, 0.6)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Top 5 khách hàng tải nhiều nhất'
                    },
                    legend: {
                        display: false
                    }
                },
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
@endsection