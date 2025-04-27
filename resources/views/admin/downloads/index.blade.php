@extends('admin.layouts.app')

@section('title', 'Quản lý tải xuống')
@section('header', 'Quản lý tải xuống')

@section('content')
<!-- Thống kê -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-6">
    <div class="bg-gradient-to-r from-blue-600 to-blue-500 rounded-lg shadow-md overflow-hidden text-white">
        <div class="p-4 sm:p-6">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-xs font-semibold uppercase tracking-wide mb-1">Tổng số file</h3>
                    <p class="text-3xl font-bold">{{ $stats['total'] }}</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                    <i class="fas fa-file-alt text-3xl opacity-80"></i>
                </div>
            </div>
        </div>
        <div class="bg-black bg-opacity-10 px-4 py-2">
            <span class="text-sm">Số lượng file có thể tải</span>
        </div>
    </div>
    
    <div class="bg-gradient-to-r from-green-600 to-green-500 rounded-lg shadow-md overflow-hidden text-white">
        <div class="p-4 sm:p-6">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-xs font-semibold uppercase tracking-wide mb-1">Đã tải xuống</h3>
                    <p class="text-3xl font-bold">{{ $stats['downloaded'] }}</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                    <i class="fas fa-download text-3xl opacity-80"></i>
                </div>
            </div>
        </div>
        <div class="bg-black bg-opacity-10 px-4 py-2">
            <span class="text-sm">Số file đã được tải ít nhất 1 lần</span>
        </div>
    </div>
    
    <div class="bg-gradient-to-r from-yellow-500 to-yellow-400 rounded-lg shadow-md overflow-hidden text-white">
        <div class="p-4 sm:p-6">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-xs font-semibold uppercase tracking-wide mb-1">Chưa tải xuống</h3>
                    <p class="text-3xl font-bold">{{ $stats['not_downloaded'] }}</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                    <i class="fas fa-clock text-3xl opacity-80"></i>
                </div>
            </div>
        </div>
        <div class="bg-black bg-opacity-10 px-4 py-2">
            <span class="text-sm">Số file chưa được tải lần nào</span>
        </div>
    </div>
    
    <div class="bg-gradient-to-r from-indigo-600 to-purple-500 rounded-lg shadow-md overflow-hidden text-white">
        <div class="p-4 sm:p-6">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-xs font-semibold uppercase tracking-wide mb-1">Tổng lượt tải</h3>
                    <p class="text-3xl font-bold">{{ $stats['total_downloads'] }}</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                    <i class="fas fa-chart-line text-3xl opacity-80"></i>
                </div>
            </div>
        </div>
        <div class="bg-black bg-opacity-10 px-4 py-2 flex justify-between items-center">
            <a href="{{ route('admin.downloads.statistics') }}" class="text-sm text-white hover:text-gray-100">
                Xem thống kê chi tiết
            </a>
            <i class="fas fa-arrow-right text-white text-xs"></i>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-4 gap-6">
    <!-- Danh sách tải xuống -->
    <div class="xl:col-span-3">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="border-b border-gray-200 px-4 py-4 flex flex-wrap justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">
                    <i class="fas fa-download mr-2"></i>Lịch sử tải xuống
                </h3>
                <div class="inline-flex rounded-md shadow-sm mt-2 sm:mt-0">
                    <a href="{{ route('admin.downloads.index', ['filter' => 'all']) }}" 
                       class="relative inline-flex items-center px-4 py-2 text-sm font-medium border {{ $filter == 'all' ? 'bg-blue-600 text-white border-blue-600 z-10' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50' }} rounded-l-md">
                        Tất cả
                    </a>
                    <a href="{{ route('admin.downloads.index', ['filter' => 'downloaded']) }}" 
                       class="relative -ml-px inline-flex items-center px-4 py-2 text-sm font-medium border {{ $filter == 'downloaded' ? 'bg-blue-600 text-white border-blue-600 z-10' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50' }}">
                        Đã tải
                    </a>
                    <a href="{{ route('admin.downloads.index', ['filter' => 'not_downloaded']) }}" 
                       class="relative -ml-px inline-flex items-center px-4 py-2 text-sm font-medium border {{ $filter == 'not_downloaded' ? 'bg-blue-600 text-white border-blue-600 z-10' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50' }} rounded-r-md">
                        Chưa tải
                    </a>
                </div>
            </div>
            
            <div class="p-4 sm:p-6">
                <!-- Tìm kiếm -->
                <div class="mb-6">
                    <form action="{{ route('admin.downloads.index') }}" method="GET">
                        <div class="flex flex-wrap gap-2">
                            <input type="hidden" name="filter" value="{{ $filter }}">
                            <div class="relative flex-grow max-w-md">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input type="text" name="search" value="{{ $search }}" 
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5" 
                                    placeholder="Tìm theo tên sản phẩm, khách hàng...">
                            </div>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <i class="fas fa-search mr-1"></i> Tìm kiếm
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Thông báo -->
                @if(session('success'))
                    <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 text-green-700 relative" role="alert">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="ml-3">
                                <p>{{ session('success') }}</p>
                            </div>
                            <button type="button" class="absolute top-0 right-0 mt-4 mr-4 text-green-600 hover:text-green-900" aria-label="Close" onclick="this.parentElement.parentElement.style.display='none'">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                @endif
                
                <!-- Bảng dữ liệu -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mã đơn</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sản phẩm</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Khách hàng</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lần đầu tải</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Số lần tải</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($downloads as $download)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $download->order_number }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <a href="{{ route('admin.downloads.product', $download->product_id) }}" class="text-blue-600 hover:text-blue-900">
                                            {{ $download->product_name }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <a href="{{ route('admin.customers.show', $download->user_id) }}" class="ml-3 text-sm text-gray-700 hover:text-gray-900">
                                                {{ $download->user_name }}
                                            </a>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        @if($download->downloaded_at)
                                            <div class="flex items-center">
                                                <i class="fas fa-check-circle text-green-600 mr-2"></i>
                                                {{ \Carbon\Carbon::parse($download->downloaded_at)->format('d/m/Y H:i') }}
                                            </div>
                                        @else
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Chưa tải
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $download->download_count > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $download->download_count ?? 0 }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex justify-center space-x-1">
                                            <form action="{{ route('admin.downloads.regenerate', $download->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                <button type="submit" title="Tạo link tải mới"
                                                        class="bg-blue-100 text-blue-600 hover:bg-blue-200 p-2 rounded-full">
                                                    <i class="fas fa-link"></i>
                                                </button>
                                            </form>
                                            <a href="{{ route('admin.orders.show', ['order' => explode('-', $download->order_number)[1]]) }}"
                                               title="Xem chi tiết đơn hàng" 
                                               class="bg-indigo-100 text-indigo-600 hover:bg-indigo-200 p-2 rounded-full">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-10 text-center text-sm font-medium text-gray-500">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                                            </svg>
                                            <span>Không có dữ liệu tải xuống nào</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Phân trang -->
                <div class="mt-6">
                    {{ $downloads->links() }}
                </div>
            </div>
        </div>
    </div>
    
    <!-- Sản phẩm được tải nhiều nhất -->
    <div class="xl:col-span-1">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="border-b border-gray-200 px-4 py-4">
                <h3 class="text-lg font-medium text-gray-900">
                    <i class="fas fa-chart-pie mr-2"></i>Sản phẩm phổ biến
                </h3>
            </div>
            <div class="p-4">
                <div class="h-48 mb-4">
                    <canvas id="popularProductsChart"></canvas>
                </div>
                
                <div class="border-t border-gray-100 pt-4">
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr>
                                    <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sản phẩm</th>
                                    <th scope="col" class="px-3 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Lượt tải</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($popularProducts as $product)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-3 py-2 whitespace-nowrap text-xs text-gray-700 truncate max-w-[100px]">{{ $product->name }}</td>
                                        <td class="px-3 py-2 whitespace-nowrap text-xs text-right font-medium text-gray-900">{{ $product->total_downloads }}</td>
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
        // Biểu đồ sản phẩm phổ biến
        const popularProductsCtx = document.getElementById('popularProductsChart').getContext('2d');
        new Chart(popularProductsCtx, {
            type: 'doughnut',
            data: {
                labels: [
                    @foreach($popularProducts as $product)
                        '{{ $product->name }}',
                    @endforeach
                ],
                datasets: [{
                    data: [
                        @foreach($popularProducts as $product)
                            {{ $product->total_downloads }},
                        @endforeach
                    ],
                    backgroundColor: [
                        '#4F46E5', '#10B981', '#3B82F6', '#F59E0B', '#EF4444',
                        '#6366F1', '#8B5CF6', '#EC4899', '#F97316', '#6B7280'
                    ],
                    borderWidth: 1,
                    borderColor: '#FFFFFF',
                }],
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        boxPadding: 4,
                        padding: 8,
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${label}: ${value} lượt tải (${percentage}%)`;
                            }
                        }
                    }
                },
                cutout: '65%',
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            },
        });
    });
</script>
@endpush
@endsection