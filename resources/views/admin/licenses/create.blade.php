@extends('admin.layouts.app')

@section('title', 'Tạo giấy phép mới')
@section('header', 'Tạo giấy phép mới')

@section('content')
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="p-5 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-800">
            <i class="fas fa-plus-circle text-blue-500 mr-2"></i>Tạo giấy phép mới
        </h2>
        
        <a href="{{ route('admin.licenses.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-all duration-200 shadow-sm flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Quay lại
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
        
        <form action="{{ route('admin.licenses.store') }}" method="POST">
            @csrf
            
            <div class="grid lg:grid-cols-2 gap-6">
                <div class="lg:col-span-2">
                    <div class="mb-6 bg-blue-50 border-l-4 border-blue-400 p-4 text-blue-700">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <div class="ml-3">
                                <p class="font-medium">Thông tin hữu ích</p>
                                <p class="text-sm mt-2">Bạn có thể tạo nhiều giấy phép cùng một lúc. Giấy phép được tạo sẽ có cùng thời hạn và giới hạn kích hoạt.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="lg:col-span-2">
                    <label for="product_id" class="block text-sm font-medium text-gray-700 mb-1">Sản phẩm</label>
                    <select name="product_id" id="product_id" required 
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        <option value="">Chọn sản phẩm</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-sm text-gray-500 mt-1">Chọn sản phẩm mà giấy phép thuộc về</p>
                </div>
                
                <div>
                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Số lượng</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-hashtag text-gray-400"></i>
                        </div>
                        <input type="number" name="quantity" id="quantity" min="1" max="1000" value="{{ old('quantity', 1) }}" required
                               class="pl-10 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                    </div>
                    <p class="text-sm text-gray-500 mt-1">Tối đa 1000 giấy phép mỗi lần</p>
                </div>
                
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
                    <select name="status" id="status" required 
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Khả dụng</option>
                        <option value="assigned" {{ old('status') == 'assigned' ? 'selected' : '' }}>Gán cho khách hàng</option>
                    </select>
                </div>
                
                <div id="user-select-container" class="{{ old('status') == 'assigned' ? '' : 'hidden' }}">
                    <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Gán cho khách hàng</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <select name="user_id" id="user_id" 
                                class="pl-10 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                            <option value="">Chọn khách hàng</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('user_id') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }} ({{ $customer->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div>
                    <label for="expires_at" class="block text-sm font-medium text-gray-700 mb-1">Ngày hết hạn (tùy chọn)</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-calendar-alt text-gray-400"></i>
                        </div>
                        <input type="date" name="expires_at" id="expires_at" value="{{ old('expires_at') }}"
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
                        <input type="number" name="activation_limit" id="activation_limit" min="1" value="{{ old('activation_limit') }}"
                               class="pl-10 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                    </div>
                    <p class="text-sm text-gray-500 mt-1">Để trống cho giấy phép không giới hạn số lần kích hoạt</p>
                </div>
            </div>
            
            <div class="mt-8 flex justify-end">
                <button type="button" onclick="window.history.back()" class="mr-3 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all duration-200 shadow-sm">
                    <i class="fas fa-times mr-2"></i> Hủy
                </button>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-200 shadow-sm">
                    <i class="fas fa-check-circle mr-2"></i> Tạo giấy phép
                </button>
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
</script>
@endpush
@endsection