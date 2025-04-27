@extends('admin.layouts.app')

@section('title', 'Quản lý giấy phép')
@section('header', 'Quản lý giấy phép')

@section('content')
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="p-5 border-b border-gray-200 flex flex-wrap justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-800">
            <i class="fas fa-key text-blue-500 mr-2"></i>Danh sách giấy phép
        </h2>
        
        <div>
            <a href="{{ route('admin.licenses.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-200 shadow-sm flex items-center">
                <i class="fas fa-plus-circle mr-2"></i> Tạo giấy phép mới
            </a>
        </div>
    </div>
    
    <div class="p-5 bg-gray-50">
        <form action="{{ route('admin.licenses.index') }}" method="GET" class="flex flex-wrap gap-3">
            <div class="flex-1 min-w-[200px]">
                <label for="product_id" class="block text-sm font-medium text-gray-700 mb-1">Sản phẩm</label>
                <select name="product_id" id="product_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                    <option value="">Tất cả sản phẩm</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ $selectedProduct == $product->id ? 'selected' : '' }}>
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="flex-1 min-w-[200px]">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
                <select name="status" id="status" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                    <option value="">Tất cả trạng thái</option>
                    @foreach($statusOptions as $status)
                        <option value="{{ $status }}" {{ $selectedStatus == $status ? 'selected' : '' }}>
                            @if($status == 'available')
                                Khả dụng
                            @elseif($status == 'assigned')
                                Đã gán
                            @elseif($status == 'revoked')
                                Đã thu hồi
                            @endif
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="flex items-end space-x-2 min-w-[200px]">
                <button type="submit" class="flex-1 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-all shadow-sm">
                    <i class="fas fa-filter mr-2"></i> Lọc
                </button>
                
                @if($selectedStatus || $selectedProduct)
                    <a href="{{ route('admin.licenses.index') }}" class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all text-center shadow-sm">
                        <i class="fas fa-times mr-2"></i> Xóa bộ lọc
                    </a>
                @endif
            </div>
        </form>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full table-auto">
            <thead>
                <tr class="bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    <th class="px-6 py-3">Mã giấy phép</th>
                    <th class="px-6 py-3">Sản phẩm</th>
                    <th class="px-6 py-3">Trạng thái</th>
                    <th class="px-6 py-3">Gán cho</th>
                    <th class="px-6 py-3">Hết hạn</th>
                    <th class="px-6 py-3">Kích hoạt</th>
                    <th class="px-6 py-3">Tùy chọn</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($licenses as $license)
                    <tr class="hover:bg-gray-50 transition-all">
                        <td class="px-6 py-4 font-mono text-sm">{{ $license->license_key }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="ml-2">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $license->product->name }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($license->status === 'available')
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i> Khả dụng
                                </span>
                            @elseif($license->status === 'assigned')
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    <i class="fas fa-user-check mr-1"></i> Đã gán
                                </span>
                            @else
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    <i class="fas fa-ban mr-1"></i> Đã thu hồi
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            @if($license->user)
                                <a href="{{ route('admin.customers.show', $license->user) }}" class="text-blue-600 hover:text-blue-900 hover:underline flex items-center">
                                    <i class="fas fa-user mr-1"></i>
                                    {{ $license->user->name }}
                                </a>
                            @else
                                <span class="text-gray-400"><i class="fas fa-minus"></i></span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            @if($license->expires_at)
                                @if($license->expires_at->isPast())
                                    <span class="text-red-600">
                                        <i class="fas fa-calendar-times mr-1"></i>
                                        {{ $license->expires_at->format('d/m/Y') }}
                                    </span>
                                @else
                                    <span class="text-gray-600">
                                        <i class="fas fa-calendar mr-1"></i>
                                        {{ $license->expires_at->format('d/m/Y') }}
                                    </span>
                                @endif
                            @else
                                <span class="text-green-600">
                                    <i class="fas fa-infinity mr-1"></i> Không giới hạn
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            @if($license->activation_limit)
                                <span class="relative inline-block">
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ min(100, ($license->activation_count/$license->activation_limit)*100) }}%"></div>
                                    </div>
                                    <span class="text-xs block mt-1">{{ $license->activation_count }}/{{ $license->activation_limit }}</span>
                                </span>
                            @else
                                <span class="text-gray-500">
                                    {{ $license->activation_count }} <i class="fas fa-infinity ml-1"></i>
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right text-sm font-medium">
                            <div class="flex space-x-2 justify-end">
                                <a href="{{ route('admin.licenses.edit', $license) }}" class="text-white bg-blue-500 hover:bg-blue-600 px-3 py-1 rounded-md shadow-sm transition-all">
                                    <i class="fas fa-edit mr-1"></i> Sửa
                                </a>
                                
                                @if($license->status === 'available')
                                    <form action="{{ route('admin.licenses.destroy', $license) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete(this)" class="text-white bg-red-500 hover:bg-red-600 px-3 py-1 rounded-md shadow-sm transition-all">
                                            <i class="fas fa-trash-alt mr-1"></i> Xóa
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-key text-gray-300 text-4xl mb-3"></i>
                                <p>Không tìm thấy giấy phép nào</p>
                                <a href="{{ route('admin.licenses.create') }}" class="mt-3 text-blue-600 hover:underline">
                                    <i class="fas fa-plus-circle mr-1"></i> Tạo giấy phép mới
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="px-6 py-4 bg-white border-t">
        {{ $licenses->appends(request()->query())->links() }}
    </div>
</div>

@push('scripts')
<script>
    function confirmDelete(button) {
        if (confirm('Bạn có chắc chắn muốn xóa giấy phép này không? Hành động này không thể hoàn tác.')) {
            button.closest('form').submit();
        }
    }
</script>
@endpush
@endsection