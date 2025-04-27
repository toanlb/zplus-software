@extends('admin.layouts.app')

@section('title', 'Thống kê đơn hàng')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Thống kê đơn hàng</h1>
            <div class="text-sm mt-1 text-gray-500 flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600">Dashboard</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <a href="{{ route('admin.orders.index') }}" class="hover:text-blue-600">Đơn hàng</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span>Thống kê</span>
            </div>
        </div>
        
        <div class="flex space-x-2 mt-4 md:mt-0">
            <div class="relative">
                <select id="time-filter" class="appearance-none bg-white border border-gray-300 rounded-md pl-3 pr-8 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm">
                    <option value="7">7 ngày qua</option>
                    <option value="30" selected>30 ngày qua</option>
                    <option value="90">90 ngày qua</option>
                    <option value="365">365 ngày qua</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                    </svg>
                </div>
            </div>
            
            <button id="refresh-stats" class="flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Cập nhật
            </button>
            
            <button id="export-pdf" class="flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Xuất PDF
            </button>
        </div>
    </div>

    <!-- Các thẻ thống kê -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Tổng đơn hàng -->
        <div class="dashboard-card bg-gradient-to-r from-blue-500 to-blue-700 rounded-lg shadow-md overflow-hidden">
            <div class="p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-white text-opacity-80 text-sm font-medium">Tổng đơn hàng</div>
                        <div class="text-white text-3xl font-bold mt-2">{{ number_format($totalOrders) }}</div>
                        <div class="text-white text-opacity-80 text-xs mt-1">
                            <span class="inline-flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                </svg>
                                8% từ tháng trước
                            </span>
                        </div>
                    </div>
                    <div class="p-3 bg-white bg-opacity-30 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white bg-opacity-10 px-5 py-3">
                <a href="{{ route('admin.orders.index') }}" class="flex justify-between items-center text-white hover:text-blue-100">
                    <span class="text-sm">Xem chi tiết</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
        
        <!-- Doanh thu -->
        <div class="dashboard-card bg-gradient-to-r from-emerald-500 to-green-700 rounded-lg shadow-md overflow-hidden">
            <div class="p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-white text-opacity-80 text-sm font-medium">Doanh thu</div>
                        <div class="text-white text-3xl font-bold mt-2">{{ number_format($totalRevenue, 0, ',', '.') }}</div>
                        <div class="text-white text-opacity-80 text-xs mt-1">
                            <span class="inline-flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                </svg>
                                12% từ tháng trước
                            </span>
                        </div>
                    </div>
                    <div class="p-3 bg-white bg-opacity-30 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white bg-opacity-10 px-5 py-3">
                <a href="#" class="flex justify-between items-center text-white hover:text-green-100">
                    <span class="text-sm">Xem báo cáo</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
        
        <!-- Đơn chờ xử lý -->
        <div class="dashboard-card bg-gradient-to-r from-amber-400 to-amber-600 rounded-lg shadow-md overflow-hidden">
            <div class="p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-white text-opacity-80 text-sm font-medium">Đơn chờ xử lý</div>
                        <div class="text-white text-3xl font-bold mt-2">{{ number_format($pendingOrders) }}</div>
                        <div class="text-white text-opacity-80 text-xs mt-1">
                            <span class="inline-flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                </svg>
                                5% từ tháng trước
                            </span>
                        </div>
                    </div>
                    <div class="p-3 bg-white bg-opacity-30 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white bg-opacity-10 px-5 py-3">
                <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="flex justify-between items-center text-white hover:text-amber-100">
                    <span class="text-sm">Xem chi tiết</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
        
        <!-- Đơn hoàn tất -->
        <div class="dashboard-card bg-gradient-to-r from-sky-400 to-cyan-600 rounded-lg shadow-md overflow-hidden">
            <div class="p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-white text-opacity-80 text-sm font-medium">Đơn hoàn tất</div>
                        <div class="text-white text-3xl font-bold mt-2">{{ number_format($completedOrders) }}</div>
                        <div class="text-white text-opacity-80 text-xs mt-1">
                            <span class="inline-flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                </svg>
                                10% từ tháng trước
                            </span>
                        </div>
                    </div>
                    <div class="p-3 bg-white bg-opacity-30 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white bg-opacity-10 px-5 py-3">
                <a href="{{ route('admin.orders.index', ['status' => 'completed']) }}" class="flex justify-between items-center text-white hover:text-sky-100">
                    <span class="text-sm">Xem chi tiết</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Biểu đồ và danh sách đơn hàng gần đây -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Biểu đồ doanh thu -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="flex justify-between items-center p-5 border-b border-gray-100">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-800">Doanh thu theo tháng</h3>
                </div>
                
                <div class="flex space-x-2">
                    <button class="chart-type-btn px-3 py-1 text-xs font-medium rounded-md bg-blue-100 text-blue-800" data-type="line">Line</button>
                    <button class="chart-type-btn px-3 py-1 text-xs font-medium rounded-md text-gray-700" data-type="bar">Bar</button>
                </div>
            </div>
            <div class="p-5">
                <div class="h-80">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Đơn hàng gần đây -->
        <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="flex justify-between items-center p-5 border-b border-gray-100">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-800">Đơn hàng gần đây</h3>
                </div>
                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Mới nhất</span>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($recentOrders as $order)
                    <a href="{{ route('admin.orders.show', $order) }}" class="flex items-center p-4 hover:bg-blue-50 transition-colors duration-200">
                        <div class="mr-4 flex-shrink-0">
                            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between">
                                <p class="text-sm font-medium text-gray-900 truncate">#{{ $order->order_number }}</p>
                                <p class="text-sm text-gray-700 font-medium">{{ number_format($order->total_price, 0, ',', '.') }} VND</p>
                            </div>
                            <div class="flex justify-between">
                                <p class="text-xs text-gray-500 truncate">{{ $order->user->name ?? $order->name }}</p>
                                <span class="text-xs inline-flex items-center px-2 py-0.5 rounded-full {{ 
                                    $order->status == 'paid' ? 'bg-green-100 text-green-800' : 
                                    ($order->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                    'bg-gray-100 text-gray-800') 
                                }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="p-4 text-center text-gray-500">Không có đơn hàng nào gần đây</div>
                @endforelse
            </div>
            <div class="p-4 border-t border-gray-100">
                <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-blue-700 bg-blue-100 rounded-md hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Xem tất cả đơn hàng
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Thống kê chi tiết -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Thống kê doanh thu theo tháng -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="flex justify-between items-center p-5 border-b border-gray-100">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-800">Doanh thu theo tháng</h3>
                </div>
                <button class="text-gray-400 hover:text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                    </svg>
                </button>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thời gian</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Doanh thu</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">So sánh</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($monthlySales as $sale)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Tháng {{ $sale->month }}/{{ $sale->year }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ number_format($sale->total, 0, ',', '.') }} VND</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex items-center">
                                        @php
                                        $randomPercent = rand(-15, 25); // Giả lập phần trăm thay đổi
                                        $arrowDirection = $randomPercent >= 0 ? 'up' : 'down';
                                        $textColor = $randomPercent >= 0 ? 'text-green-600' : 'text-red-600';
                                        @endphp
                                        
                                        @if($arrowDirection == 'up')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-600 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-600 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                            </svg>
                                        @endif
                                        <span class="{{ $textColor }}">{{ abs($randomPercent) }}% so với tháng trước</span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Phân bố trạng thái đơn hàng -->
        <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="flex justify-between items-center p-5 border-b border-gray-100">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-800">Phân bố đơn hàng</h3>
                </div>
                <button class="text-gray-400 hover:text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                    </svg>
                </button>
            </div>
            <div class="p-5">
                <div class="h-60">
                    <canvas id="orderStatusChart"></canvas>
                </div>
                <div class="mt-4 space-y-4">
                    @php
                        $statusColors = [
                            'pending' => 'bg-amber-500',
                            'processing' => 'bg-blue-500',
                            'paid' => 'bg-emerald-500',
                            'completed' => 'bg-green-600',
                            'cancelled' => 'bg-red-500',
                            'refunded' => 'bg-gray-500'
                        ];
                    @endphp
                    
                    @foreach($orderStats as $status => $count)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-3 h-3 rounded-full {{ $statusColors[$status] ?? 'bg-gray-400' }} mr-2"></div>
                                <span class="text-sm text-gray-600 capitalize">{{ $status }}</span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-sm font-medium text-gray-900">{{ $count }}</span>
                                <span class="text-xs text-gray-500 ml-2">({{ round(($count / $totalOrders) * 100, 1) }}%)</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/apexcharts@3.29.0/dist/apexcharts.min.css" rel="stylesheet">
<style>
    .dashboard-card:hover {
        transform: translateY(-5px);
        transition: transform 0.3s ease;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    /* Chart.js Options chung */
    Chart.defaults.font.family = 'Inter, system-ui, sans-serif';
    Chart.defaults.color = '#6B7280';
    Chart.defaults.set('plugins.tooltip.backgroundColor', 'rgba(17, 24, 39, 0.8)');
    Chart.defaults.set('plugins.tooltip.padding', 10);
    Chart.defaults.set('plugins.tooltip.cornerRadius', 4);
    Chart.defaults.set('plugins.tooltip.titleFont', {size: 13});
    Chart.defaults.set('plugins.tooltip.bodyFont', {size: 12});
    Chart.defaults.set('plugins.tooltip.displayColors', false);
    
    /* Dữ liệu biểu đồ doanh thu */
    const monthlySalesData = @json($monthlySales);
    
    // Chuẩn bị dữ liệu
    const labels = monthlySalesData.map(item => `Tháng ${item.month}/${item.year}`);
    const data = monthlySalesData.map(item => item.total);
    
    // Tạo biểu đồ doanh thu
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Doanh thu',
                data: data,
                fill: {
                    target: 'origin',
                    above: 'rgba(59, 130, 246, 0.1)',
                },
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 2,
                pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                tension: 0.4,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.parsed.y.toLocaleString('vi-VN')} VND`;
                        }
                    }
                },
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                    },
                    ticks: {
                        maxRotation: 0,
                        font: {
                            size: 11
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)',
                    },
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString('vi-VN') + ' VND';
                        }
                    }
                }
            }
        }
    });
    
    /* Tạo biểu đồ phân bố trạng thái đơn hàng */
    const orderStatsData = @json($orderStats);
    const orderStatusLabels = Object.keys(orderStatsData);
    const orderStatusValues = Object.values(orderStatsData);
    const orderStatusColors = [
        'rgba(245, 158, 11, 0.9)',    // amber-500 - pending
        'rgba(59, 130, 246, 0.9)',     // blue-500 - processing
        'rgba(16, 185, 129, 0.9)',     // emerald-500 - paid
        'rgba(22, 163, 74, 0.9)',      // green-600 - completed
        'rgba(239, 68, 68, 0.9)',      // red-500 - cancelled
        'rgba(107, 114, 128, 0.9)'     // gray-500 - refunded
    ];
    
    const orderStatusCtx = document.getElementById('orderStatusChart').getContext('2d');
    const orderStatusChart = new Chart(orderStatusCtx, {
        type: 'doughnut',
        data: {
            labels: orderStatusLabels.map(status => status.charAt(0).toUpperCase() + status.slice(1)),
            datasets: [{
                data: orderStatusValues,
                backgroundColor: orderStatusColors,
                borderColor: '#fff',
                borderWidth: 2,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const value = context.parsed;
                            const total = context.dataset.data.reduce((acc, data) => acc + data, 0);
                            const percentage = Math.round((value / total) * 100);
                            return `${context.label}: ${value} (${percentage}%)`;
                        }
                    }
                },
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        boxWidth: 12,
                        usePointStyle: true,
                        pointStyle: 'circle',
                        font: {
                            size: 11
                        }
                    }
                }
            },
            layout: {
                padding: 10
            }
        }
    });
    
    /* Chuyển đổi giữa các loại biểu đồ */
    const chartTypeBtns = document.querySelectorAll('.chart-type-btn');
    chartTypeBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const type = this.dataset.type;
            
            // Reset styles cho tất cả các nút
            chartTypeBtns.forEach(b => {
                b.classList.remove('bg-blue-100', 'text-blue-800');
                b.classList.add('text-gray-700');
            });
            
            // Highlight nút được chọn
            this.classList.add('bg-blue-100', 'text-blue-800');
            this.classList.remove('text-gray-700');
            
            // Cập nhật loại biểu đồ
            revenueChart.config.type = type;
            revenueChart.update();
        });
    });
    
    /* Xử lý filter thời gian */
    document.getElementById('time-filter').addEventListener('change', function() {
        // Trong thực tế, bạn sẽ gọi AJAX để lấy dữ liệu mới dựa trên filter
        alert('Đang lọc dữ liệu theo ' + this.options[this.selectedIndex].text);
    });
    
    /* Xử lý nút Refresh */
    document.getElementById('refresh-stats').addEventListener('click', function() {
        // Hiệu ứng loading
        this.innerHTML = `
            <svg class="animate-spin h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Đang cập nhật
        `;
        
        // Giả lập việc cập nhật dữ liệu
        setTimeout(() => {
            this.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Cập nhật
            `;
            alert('Đã cập nhật dữ liệu thành công!');
        }, 1500);
    });
    
    /* Xử lý nút Export PDF */
    document.getElementById('export-pdf').addEventListener('click', function() {
        alert('Đang xuất báo cáo PDF...');
    });
});
</script>
@endpush