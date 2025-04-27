@extends('admin.layouts.app')

@section('title', 'Quản lý đơn hàng')
@section('header', 'Quản lý đơn hàng')

@section('content')
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="p-4 sm:p-6 flex items-center justify-between border-b border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800">Danh sách đơn hàng</h2>
        <a href="{{ route('admin.orders.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            <i class="fas fa-chart-bar mr-2"></i> Thống kê đơn hàng
        </a>
    </div>
    
    <div class="p-4 sm:p-6">
        <div class="mb-4 flex flex-wrap gap-4 sm:justify-between">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" id="order-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5" placeholder="Tìm đơn hàng...">
            </div>
            
            <div class="flex flex-wrap gap-2">
                <select id="status-filter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5">
                    <option value="">Tất cả trạng thái</option>
                    <option value="paid">Đã thanh toán</option>
                    <option value="pending">Đang chờ</option>
                    <option value="cancelled">Đã hủy</option>
                </select>
                
                <select id="date-filter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5">
                    <option value="">Tất cả thời gian</option>
                    <option value="today">Hôm nay</option>
                    <option value="yesterday">Hôm qua</option>
                    <option value="week">Tuần này</option>
                    <option value="month">Tháng này</option>
                </select>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mã đơn hàng</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Khách hàng</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tổng tiền</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thanh toán</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày tạo</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($orders as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $order->order_number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="ml-2">{{ $order->user->name ?? $order->name }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-medium">{{ number_format($order->total_price, 0, ',', '.') }} VND</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($order->status == 'paid')
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Đã thanh toán
                                    </span>
                                @elseif($order->status == 'pending')
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Đang chờ
                                    </span>
                                @elseif($order->status == 'cancelled')
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Đã hủy
                                    </span>
                                @else
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <div class="flex items-center">
                                    @if($order->payment_method == 'bank_transfer')
                                        <i class="fas fa-university text-gray-500 mr-1"></i>
                                    @elseif($order->payment_method == 'credit_card')
                                        <i class="fas fa-credit-card text-gray-500 mr-1"></i>
                                    @elseif($order->payment_method == 'vnpay')
                                        <i class="fas fa-wallet text-gray-500 mr-1"></i>
                                    @elseif($order->payment_method == 'momo')
                                        <i class="fas fa-money-bill-wave text-gray-500 mr-1"></i>
                                    @else
                                        <i class="fas fa-money-bill text-gray-500 mr-1"></i>
                                    @endif
                                    {{ $order->payment_method }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('admin.orders.show', $order) }}" 
                                       class="text-blue-600 hover:text-blue-900 bg-blue-100 hover:bg-blue-200 p-2 rounded-full transition duration-150">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?')" 
                                                class="text-red-600 hover:text-red-900 bg-red-100 hover:bg-red-200 p-2 rounded-full transition duration-150">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-sm font-medium text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <span class="mt-2">Không có đơn hàng nào</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Hiệu ứng hover cho hàng trong bảng
        $('tbody tr').hover(
            function() { $(this).addClass('transition duration-150'); },
            function() { $(this).removeClass('transition duration-150'); }
        );
        
        // Tìm kiếm đơn hàng (client-side filtering)
        $('#order-search').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });
        
        // Lọc theo trạng thái
        $('#status-filter').on('change', function() {
            var value = $(this).val().toLowerCase();
            
            if (value === '') {
                // Hiển thị tất cả
                $('tbody tr').show();
            } else {
                // Lọc theo trạng thái
                $('tbody tr').filter(function() {
                    return $(this).find('td:nth-child(4)').text().toLowerCase().indexOf(value) > -1;
                }).show();
                
                $('tbody tr').filter(function() {
                    return $(this).find('td:nth-child(4)').text().toLowerCase().indexOf(value) === -1;
                }).hide();
            }
        });
    });
</script>
@endpush
@endsection