@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
    <!-- Thống kê tổng quan -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Doanh thu -->
        <div class="dashboard-card bg-white overflow-hidden shadow rounded-lg transition-transform duration-300">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 rounded-md bg-blue-500 p-3">
                        <i class="fas fa-dollar-sign text-white text-xl"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Doanh thu</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900 counter-value" data-target="{{ $stats['revenue'] }}">0</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
                <div class="text-sm">
                    <a href="{{ route('admin.orders.index') }}" class="font-medium text-blue-600 hover:text-blue-500">Xem chi tiết <i class="fas fa-arrow-right ml-1"></i></a>
                </div>
            </div>
        </div>

        <!-- Sản phẩm -->
        <div class="dashboard-card bg-white overflow-hidden shadow rounded-lg transition-transform duration-300">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 rounded-md bg-green-500 p-3">
                        <i class="fas fa-box text-white text-xl"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Sản phẩm</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900 counter-value" data-target="{{ $stats['products'] }}">0</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
                <div class="text-sm">
                    <a href="{{ route('admin.products.index') }}" class="font-medium text-green-600 hover:text-green-500">Quản lý sản phẩm <i class="fas fa-arrow-right ml-1"></i></a>
                </div>
            </div>
        </div>

        <!-- Đơn hàng -->
        <div class="dashboard-card bg-white overflow-hidden shadow rounded-lg transition-transform duration-300">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 rounded-md bg-indigo-500 p-3">
                        <i class="fas fa-shopping-cart text-white text-xl"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Đơn hàng</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900 counter-value" data-target="{{ $stats['orders'] }}">0</div>
                                @if($stats['pending_orders'] > 0)
                                <div class="ml-2 flex items-baseline text-sm font-semibold text-amber-600">
                                    <span class="px-2 py-0.5 bg-amber-100 rounded-full">{{ $stats['pending_orders'] }} chờ xử lý</span>
                                </div>
                                @endif
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
                <div class="text-sm">
                    <a href="{{ route('admin.orders.index') }}" class="font-medium text-indigo-600 hover:text-indigo-500">Quản lý đơn hàng <i class="fas fa-arrow-right ml-1"></i></a>
                </div>
            </div>
        </div>

        <!-- Khách hàng -->
        <div class="dashboard-card bg-white overflow-hidden shadow rounded-lg transition-transform duration-300">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 rounded-md bg-amber-500 p-3">
                        <i class="fas fa-users text-white text-xl"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Khách hàng</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900 counter-value" data-target="{{ $stats['customers'] }}">0</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
                <div class="text-sm">
                    <a href="{{ route('admin.customers.index') }}" class="font-medium text-amber-600 hover:text-amber-500">Quản lý khách hàng <i class="fas fa-arrow-right ml-1"></i></a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Biểu đồ thống kê & Thông tin nhanh -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6" id="dashboard-charts-section">
        <!-- Biểu đồ doanh thu -->
        <div class="dashboard-card bg-white shadow rounded-lg overflow-hidden lg:col-span-2">
            <div class="px-4 py-5 sm:px-6 flex justify-between items-center border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Doanh thu theo thời gian</h3>
                <div class="space-x-1 flex text-sm" id="chart-period-controls">
                    <button data-period="7" class="px-3 py-1 rounded-md text-gray-500 hover:bg-gray-100 chart-period">7 ngày</button>
                    <button data-period="30" class="px-3 py-1 rounded-md text-white bg-blue-600 chart-period">30 ngày</button>
                    <button data-period="365" class="px-3 py-1 rounded-md text-gray-500 hover:bg-gray-100 chart-period">1 năm</button>
                </div>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <div class="h-64 flex items-center justify-center">
                    <div class="w-full h-full">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sản phẩm bán chạy -->
        <div class="dashboard-card bg-white shadow rounded-lg overflow-hidden">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Sản phẩm bán chạy</h3>
            </div>
            <div class="p-4">
                <ul class="divide-y divide-gray-200">
                    @forelse($topProducts as $index => $product)
                        <li class="py-3 flex items-center justify-between">
                            <div class="flex items-center">
                                <span class="text-sm font-medium {{ $index === 0 ? 'text-amber-500' : 'text-gray-700' }}">
                                    #{{ $index + 1 }}
                                </span>
                                <span class="ml-3 text-sm text-gray-900 truncate max-w-[180px]">{{ $product->name }}</span>
                            </div>
                            <div>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $index === 0 ? 'bg-amber-100 text-amber-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ $product->sales_count }} bán ra
                                </span>
                            </div>
                        </li>
                    @empty
                        <li class="py-3 text-center text-sm text-gray-500">Chưa có dữ liệu sản phẩm bán chạy</li>
                    @endforelse
                </ul>
                
                <div class="mt-4 border-t border-gray-100 pt-3">
                    <a href="{{ route('admin.products.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                        Xem tất cả sản phẩm <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Đơn hàng gần đây -->
        <div class="dashboard-card bg-white shadow rounded-lg overflow-hidden lg:col-span-2">
            <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Đơn hàng gần đây</h3>
                <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Xem tất cả
                </a>
            </div>
            <div class="border-t border-gray-200 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200" id="orders-table">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer table-sort" data-sort="id">
                                ID <i class="fas fa-sort ml-1"></i>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Khách hàng</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer table-sort" data-sort="total">
                                Tổng tiền <i class="fas fa-sort ml-1"></i>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer table-sort" data-sort="date">
                                Ngày đặt <i class="fas fa-sort ml-1"></i>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($recentOrders as $order)
                            <tr class="hover:bg-gray-50 animate__animated animate__fadeIn order-row" 
                                data-id="{{ $order->id }}" 
                                data-total="{{ $order->total_price }}" 
                                data-date="{{ $order->created_at->timestamp }}">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $order->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8">
                                            <img class="h-8 w-8 rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode($order->user->name) }}&color=7F9CF5&background=EBF4FF" alt="{{ $order->user->name }}">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $order->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $order->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($order->total_price, 0, ',', '.') }} VNĐ</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($order->status == 'pending')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Chờ xử lý
                                        </span>
                                    @elseif($order->status == 'processing')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            Đang xử lý
                                        </span>
                                    @elseif($order->status == 'paid')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Đã thanh toán
                                        </span>
                                    @elseif($order->status == 'cancelled')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Đã hủy
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button class="view-order-btn text-indigo-600 hover:text-indigo-900 mr-2" data-id="{{ $order->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Không có đơn hàng nào</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Khách hàng mới -->
        <div class="dashboard-card bg-white shadow rounded-lg overflow-hidden">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Khách hàng mới</h3>
            </div>
            <div class="overflow-y-auto" style="max-height: 370px;">
                <ul class="divide-y divide-gray-200">
                    @forelse($newCustomers as $customer)
                    <li class="px-4 py-3">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode($customer->name) }}&color=7F9CF5&background=EBF4FF" alt="{{ $customer->name }}">
                            </div>
                            <div class="ml-3">
                                <div class="text-sm font-medium text-gray-900">{{ $customer->name }}</div>
                                <div class="text-xs text-gray-500">{{ $customer->email }}</div>
                                <div class="text-xs text-gray-500">Tham gia: {{ $customer->created_at->format('d/m/Y') }}</div>
                            </div>
                        </div>
                    </li>
                    @empty
                    <li class="px-4 py-6 text-center text-gray-500 text-sm">Không có khách hàng mới</li>
                    @endforelse
                </ul>
            </div>
            <div class="bg-gray-50 px-4 py-3">
                <a href="{{ route('admin.customers.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                    Xem tất cả khách hàng <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Quản lý nhanh -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <a href="{{ route('admin.products.create') }}" class="bg-white overflow-hidden shadow rounded-lg p-6 hover:bg-blue-50 transition-colors duration-300 flex items-center">
            <div class="rounded-full bg-blue-100 p-3 mr-4">
                <i class="fas fa-plus text-blue-600 text-lg"></i>
            </div>
            <div>
                <h3 class="text-base font-medium text-blue-600">Thêm sản phẩm mới</h3>
                <p class="text-sm text-gray-500 mt-1">Tạo sản phẩm mới để bán</p>
            </div>
        </a>

        <a href="{{ route('admin.posts.create') }}" class="bg-white overflow-hidden shadow rounded-lg p-6 hover:bg-green-50 transition-colors duration-300 flex items-center">
            <div class="rounded-full bg-green-100 p-3 mr-4">
                <i class="fas fa-edit text-green-600 text-lg"></i>
            </div>
            <div>
                <h3 class="text-base font-medium text-green-600">Viết bài mới</h3>
                <p class="text-sm text-gray-500 mt-1">Thêm bài viết cho blog</p>
            </div>
        </a>

        <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="bg-white overflow-hidden shadow rounded-lg p-6 hover:bg-amber-50 transition-colors duration-300 flex items-center">
            <div class="rounded-full bg-amber-100 p-3 mr-4">
                <i class="fas fa-clipboard-list text-amber-600 text-lg"></i>
            </div>
            <div>
                <h3 class="text-base font-medium text-amber-600">Đơn hàng chờ xử lý</h3>
                <p class="text-sm text-gray-500 mt-1">{{ $stats['pending_orders'] }} đơn hàng mới</p>
            </div>
        </a>

        <a href="{{ route('admin.downloads.index') }}" class="bg-white overflow-hidden shadow rounded-lg p-6 hover:bg-purple-50 transition-colors duration-300 flex items-center">
            <div class="rounded-full bg-purple-100 p-3 mr-4">
                <i class="fas fa-download text-purple-600 text-lg"></i>
            </div>
            <div>
                <h3 class="text-base font-medium text-purple-600">Quản lý Download</h3>
                <p class="text-sm text-gray-500 mt-1">Xem thống kê tải xuống</p>
            </div>
        </a>
    </div>
    
    <!-- Modal Order Detail -->
    <div class="fixed inset-0 z-50 hidden overflow-y-auto" id="order-modal">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Chi tiết đơn hàng #<span id="order-id"></span>
                            </h3>
                            <div class="mt-4">
                                <div class="space-y-4 text-sm">
                                    <p><strong>Khách hàng:</strong> <span id="order-customer"></span></p>
                                    <p><strong>Ngày đặt hàng:</strong> <span id="order-date"></span></p>
                                    <p><strong>Trạng thái:</strong> <span id="order-status"></span></p>
                                    <p><strong>Tổng tiền:</strong> <span id="order-total"></span> VNĐ</p>
                                    <div>
                                        <strong>Sản phẩm:</strong>
                                        <ul class="list-disc ml-5 mt-2 space-y-1" id="order-items">
                                            <!-- Products will be loaded here -->
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <a id="view-order-link" href="#" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Xem chi tiết
                    </a>
                    <button type="button" id="close-modal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Đóng
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function() {
            // Hiệu ứng đếm số
            function animateCounter() {
                $('.counter-value').each(function () {
                    var $this = $(this);
                    var target = parseInt($this.data('target'));
                    
                    // Set step based on magnitude of number
                    var step = Math.max(1, Math.floor(target / 100));
                    
                    $({ countNum: 0 }).animate({
                        countNum: target
                    }, {
                        duration: 1500,
                        easing: 'swing',
                        step: function() {
                            var formattedValue = Math.floor(this.countNum).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                            $this.text(formattedValue);
                        },
                        complete: function() {
                            var formattedValue = target.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                            $this.text(formattedValue);
                        }
                    });
                });
            }
            
            // Khởi tạo biểu đồ
            let revenueChart = null;
            
            // Dữ liệu từ controller
            const revenueData = @json($revenueData);
            
            function initChart(period = 30) {
                // Sử dụng dữ liệu thực từ controller
                let labels, data;
                
                if (period === 7) {
                    labels = revenueData.daily.labels;
                    data = revenueData.daily.data;
                } else if (period === 30) {
                    labels = revenueData.weekly.labels;
                    data = revenueData.weekly.data;
                } else {
                    labels = revenueData.monthly.labels;
                    data = revenueData.monthly.data;
                }
                
                const ctx = document.getElementById('revenueChart').getContext('2d');
                
                if (revenueChart) {
                    revenueChart.destroy();
                }
                
                revenueChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Doanh thu',
                            data: data,
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            borderColor: 'rgb(59, 130, 246)',
                            borderWidth: 2,
                            tension: 0.3,
                            pointBackgroundColor: 'rgb(59, 130, 246)',
                            pointRadius: 4
                        }]
                    },
                    options: {
                        animation: {
                            duration: 1500,
                            easing: 'easeOutQuart'
                        },
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return new Intl.NumberFormat('vi-VN', {
                                            style: 'currency',
                                            currency: 'VND',
                                            minimumFractionDigits: 0,
                                            maximumFractionDigits: 0
                                        }).format(value);
                                    }
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return 'Doanh thu: ' + new Intl.NumberFormat('vi-VN', {
                                            style: 'currency',
                                            currency: 'VND',
                                            minimumFractionDigits: 0,
                                            maximumFractionDigits: 0
                                        }).format(context.parsed.y);
                                    }
                                }
                            }
                        }
                    }
                });
            }
            
            // Sắp xếp bảng đơn hàng
            function sortTable(column) {
                const $table = $('#orders-table');
                const $rows = $table.find('tbody tr').toArray();
                let sortDirection = 1;
                
                // Check if already sorted by this column
                if ($table.data('sort-column') === column && $table.data('sort-direction') === 1) {
                    sortDirection = -1;
                }
                
                // Save sort state
                $table.data('sort-column', column);
                $table.data('sort-direction', sortDirection);
                
                // Update column header icons
                $('.table-sort i').removeClass('fa-sort-up fa-sort-down').addClass('fa-sort');
                const $header = $(`.table-sort[data-sort="${column}"] i`);
                $header.removeClass('fa-sort').addClass(sortDirection === 1 ? 'fa-sort-up' : 'fa-sort-down');
                
                // Sort rows
                $rows.sort(function(a, b) {
                    const aValue = $(a).data(column);
                    const bValue = $(b).data(column);
                    return sortDirection * (aValue > bValue ? 1 : -1);
                });
                
                // Re-append rows in new order with animation
                const $tbody = $table.find('tbody');
                $rows.forEach(function(row) {
                    $(row).addClass('animate__animated animate__fadeIn');
                    $tbody.append(row);
                });
            }
            
            // Hiện chi tiết đơn hàng
            function showOrderDetails(orderId) {
                // Find the order from the table
                const $row = $(`.order-row[data-id="${orderId}"]`);
                if ($row.length) {
                    const customerName = $row.find('td:eq(1) .text-sm.font-medium').text();
                    const customerEmail = $row.find('td:eq(1) .text-sm.text-gray-500').text();
                    const total = $row.find('td:eq(2)').text();
                    const status = $row.find('td:eq(3) span').clone();
                    const date = $row.find('td:eq(4)').text();
                    
                    $('#order-id').text(orderId);
                    $('#order-customer').text(`${customerName} (${customerEmail})`);
                    $('#order-date').text(date);
                    $('#order-status').html('');
                    $('#order-status').append(status);
                    $('#order-total').text(total.replace(' VNĐ', ''));
                    $('#view-order-link').attr('href', `/admin/orders/${orderId}`);
                    
                    // Get order items - in a real app, this would be done with AJAX
                    // For demo, we'll add some placeholder items
                    $('#order-items').empty();
                    
                    // Fetch order details with AJAX instead of placeholders
                    $.ajax({
                        url: `/admin/orders/${orderId}`,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#order-items').empty();
                            if (data.items && data.items.length > 0) {
                                data.items.forEach(function(item) {
                                    $('#order-items').append(`
                                        <li>${item.product_name} x ${item.quantity}</li>
                                    `);
                                });
                            } else {
                                $('#order-items').append('<li>Không có thông tin chi tiết</li>');
                            }
                        },
                        error: function() {
                            $('#order-items').html('<li>Không thể tải thông tin chi tiết</li>');
                        }
                    });
                    
                    $('#order-modal').fadeIn(300);
                }
            }
            
            // Sự kiện khi click vào button xem chi tiết đơn hàng
            $('.view-order-btn').click(function() {
                const orderId = $(this).data('id');
                showOrderDetails(orderId);
            });
            
            $('#close-modal').click(function() {
                $('#order-modal').fadeOut(300);
            });
            
            // Sự kiện thay đổi thời gian biểu đồ
            $('.chart-period').click(function() {
                $('.chart-period').removeClass('text-white bg-blue-600').addClass('text-gray-500 hover:bg-gray-100');
                $(this).removeClass('text-gray-500 hover:bg-gray-100').addClass('text-white bg-blue-600');
                
                const period = $(this).data('period');
                initChart(period);
            });
            
            // Sự kiện sắp xếp bảng
            $('.table-sort').click(function() {
                sortTable($(this).data('sort'));
            });
            
            // Khởi tạo
            animateCounter();
            initChart();
            
            // Hiệu ứng xuất hiện
            $('#dashboard-charts-section').addClass('animate__animated animate__fadeIn');
            
            // Hover effect for dashboard cards
            $('.dashboard-card').hover(
                function() {
                    $(this).css('transform', 'translateY(-5px)');
                },
                function() {
                    $(this).css('transform', 'translateY(0)');
                }
            );
        });
    </script>
@endpush