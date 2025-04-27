@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa giấy phép')
@section('header', 'Chỉnh sửa giấy phép')

@section('content')
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="p-5 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-800">
            <i class="fas fa-edit text-blue-500 mr-2"></i>Chỉnh sửa giấy phép
        </h2>
        
        <a href="{{ route('admin.licenses.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-all duration-200 shadow-sm flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Quay lại danh sách
        </a>
    </div>
    
    <div class="p-6">
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 text-red-700">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    <div class="ml-3">
                        <p class="font-medium">Có một số lỗi xảy ra:</p>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif
        
        <div class="mb-6 bg-gray-50 rounded-lg border border-gray-200 p-5">
            <div class="grid md:grid-cols-3 gap-4">
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                    <span class="block text-sm font-medium text-gray-500">Mã giấy phép</span>
                    <div class="mt-1 flex items-center">
                        <span class="font-mono text-base select-all">{{ $license->license_key }}</span>
                        <button type="button" onclick="copyToClipboard('{{ $license->license_key }}')" class="ml-2 text-gray-400 hover:text-blue-600" title="Copy">
                            <i class="far fa-copy"></i>
                        </button>
                    </div>
                </div>
                
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                    <span class="block text-sm font-medium text-gray-500">Sản phẩm</span>
                    <span class="text-base font-medium">{{ $license->product->name }}</span>
                </div>
                
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                    <span class="block text-sm font-medium text-gray-500">Ngày tạo</span>
                    <span class="text-base">{{ $license->created_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
            
            <div class="grid md:grid-cols-3 gap-4 mt-4">
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                    <span class="block text-sm font-medium text-gray-500">Số lần kích hoạt</span>
                    <span class="text-base">{{ $license->activation_count }}</span>
                </div>
                
                @if($license->order_item)
                    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                        <span class="block text-sm font-medium text-gray-500">Đơn hàng</span>
                        <a href="{{ route('admin.orders.show', $license->order_item->order) }}" class="text-blue-600 hover:text-blue-800 hover:underline flex items-center">
                            <i class="fas fa-shopping-cart mr-1"></i>
                            #{{ $license->order_item->order->id }}
                        </a>
                    </div>
                @endif
                
                @if($license->user)
                    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                        <span class="block text-sm font-medium text-gray-500">Khách hàng</span>
                        <a href="{{ route('admin.customers.show', $license->user) }}" class="text-blue-600 hover:text-blue-800 hover:underline flex items-center">
                            <i class="fas fa-user mr-1"></i>
                            {{ $license->user->name }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
        
        <form action="{{ route('admin.licenses.update', $license) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid lg:grid-cols-2 gap-6">                
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-tag text-gray-400"></i>
                        </div>
                        <select name="status" id="status" required 
                                class="pl-10 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                            <option value="available" {{ old('status', $license->status) == 'available' ? 'selected' : '' }}>Khả dụng</option>
                            <option value="assigned" {{ old('status', $license->status) == 'assigned' ? 'selected' : '' }}>Đã gán</option>
                            <option value="revoked" {{ old('status', $license->status) == 'revoked' ? 'selected' : '' }}>Đã thu hồi</option>
                        </select>
                    </div>
                    <p class="text-sm text-gray-500 mt-1">Chọn trạng thái hiện tại của giấy phép</p>
                </div>
                
                <div id="user-select-container" class="{{ old('status', $license->status) == 'assigned' ? '' : 'hidden' }}">
                    <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Gán cho khách hàng</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <select name="user_id" id="user_id" 
                                class="pl-10 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                            <option value="">Chọn khách hàng</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('user_id', $license->user_id) == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }} ({{ $customer->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <p class="text-sm text-gray-500 mt-1">Chọn người dùng sở hữu giấy phép này</p>
                </div>
                
                <div>
                    <label for="expires_at" class="block text-sm font-medium text-gray-700 mb-1">Ngày hết hạn (tùy chọn)</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-calendar-alt text-gray-400"></i>
                        </div>
                        <input type="date" name="expires_at" id="expires_at" 
                               value="{{ old('expires_at', $license->expires_at ? $license->expires_at->format('Y-m-d') : '') }}"
                               class="pl-10 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                    </div>
                    <p class="text-sm text-gray-500 mt-1">Để trống cho giấy phép không giới hạn thời gian</p>
                </div>
                
                <div>
                    <label for="activation_limit" class="block text-sm font-medium text-gray-700 mb-1">Giới hạn kích hoạt (tùy chọn)</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-desktop text-gray-400"></i>
                        </div>
                        <input type="number" name="activation_limit" id="activation_limit" min="1" 
                               value="{{ old('activation_limit', $license->activation_limit) }}"
                               class="pl-10 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                    </div>
                    <p class="text-sm text-gray-500 mt-1">Để trống cho giấy phép không giới hạn số lần kích hoạt</p>
                </div>
            </div>
            
            <div class="mt-8 flex justify-between">
                <div>
                    @if($license->status === 'available')
                        <button type="button" onclick="confirmDelete()" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all duration-200 shadow-sm flex items-center">
                            <i class="fas fa-trash-alt mr-2"></i> Xóa giấy phép
                        </button>
                        
                        <form id="delete-form" action="{{ route('admin.licenses.destroy', $license) }}" method="POST" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    @endif
                </div>
                
                <div class="flex">
                    <button type="button" onclick="window.history.back()" class="mr-3 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all duration-200 shadow-sm flex items-center">
                        <i class="fas fa-times mr-2"></i> Hủy
                    </button>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-200 shadow-sm flex items-center">
                        <i class="fas fa-save mr-2"></i> Cập nhật
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusSelect = document.getElementById('status');
        const userSelectContainer = document.getElementById('user-select-container');
        const userSelect = document.getElementById('user_id');
        
        statusSelect.addEventListener('change', function() {
            if (this.value === 'assigned') {
                userSelectContainer.classList.remove('hidden');
                userSelect.setAttribute('required', 'required');
            } else {
                userSelectContainer.classList.add('hidden');
                userSelect.removeAttribute('required');
            }
        });
    });
    
    function confirmDelete() {
        if (confirm('Bạn có chắc chắn muốn xóa giấy phép này không? Hành động này không thể hoàn tác.')) {
            document.getElementById('delete-form').submit();
        }
    }
    
    function copyToClipboard(text) {
        const textarea = document.createElement('textarea');
        textarea.value = text;
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand('copy');
        document.body.removeChild(textarea);
        
        // Show tooltip or notification that text has been copied
        alert('Đã sao chép mã giấy phép: ' + text);
    }
</script>
@endpush
@endsection