@extends('admin.layouts.app')

@section('title', 'Chi tiết Sản phẩm')
@section('header', 'Chi tiết Sản phẩm')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold text-gray-800">{{ $product->name }}</h2>
    <div class="flex space-x-3">
        <a href="{{ route('admin.products.edit', $product) }}" class="inline-flex items-center px-3 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <i class="fas fa-edit mr-2"></i>
            Chỉnh sửa
        </a>
        <a href="{{ route('admin.products.index') }}" class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <i class="fas fa-arrow-left mr-2"></i>
            Quay lại
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Phần bên trái: Hình ảnh & File -->
    <div class="space-y-6">
        <!-- Hình ảnh sản phẩm -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="border-b border-gray-200 px-4 py-4">
                <h3 class="text-lg font-medium text-gray-900">Hình ảnh sản phẩm</h3>
            </div>
            <div class="p-4 flex flex-col items-center">
                @if($product->thumbnail)
                    <div class="mb-4 rounded-lg overflow-hidden">
                        <img src="{{ Storage::url($product->thumbnail) }}" alt="{{ $product->name }}" class="w-full h-auto object-cover">
                    </div>
                @else
                    <div class="mb-4 bg-gray-100 rounded-lg p-8 text-center w-full">
                        <i class="fas fa-image text-gray-400 text-5xl mb-3"></i>
                        <p class="text-gray-500">Chưa có hình ảnh</p>
                    </div>
                @endif

                <div class="flex justify-between w-full mt-3 space-x-2">
                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        <i class="fas fa-{{ $product->is_active ? 'check' : 'times' }}-circle mr-1"></i>
                        {{ $product->is_active ? 'Đang bán' : 'Tạm ngừng' }}
                    </span>
                    
                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium {{ $product->license_required ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                        <i class="fas fa-key mr-1"></i>
                        {{ $product->license_required ? 'Yêu cầu license' : 'Không cần license' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- File phần mềm -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="border-b border-gray-200 px-4 py-4">
                <h3 class="text-lg font-medium text-gray-900">File Phần mềm</h3>
            </div>
            <div class="p-4">
                @if($product->download_link)
                    <div class="text-center p-4">
                        <div class="bg-green-100 text-green-600 rounded-full p-3 inline-flex mb-3">
                            <i class="fas fa-file-archive text-3xl"></i>
                        </div>
                        <p class="text-gray-700 mb-4">File sẵn sàng để tải xuống</p>
                        <a href="{{ route('admin.products.download', $product) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <i class="fas fa-download mr-2"></i> Tải xuống
                        </a>
                    </div>
                @else
                    <div class="text-center p-4">
                        <div class="bg-yellow-100 text-yellow-600 rounded-full p-3 inline-flex mb-3">
                            <i class="fas fa-exclamation-triangle text-3xl"></i>
                        </div>
                        <p class="text-gray-500 mb-4">Chưa có file phần mềm</p>
                        <a href="{{ route('admin.products.edit', $product) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-upload mr-2"></i> Tải lên file
                        </a>
                    </div>
                @endif
                
                <div class="mt-6 border-t border-gray-200 pt-4">
                    <div class="flex justify-between items-center mb-2">
                        <div class="text-sm font-medium text-gray-700">Lượt tải:</div>
                        <div class="text-sm text-gray-900 font-semibold">
                            <span class="bg-green-100 text-green-800 px-2.5 py-0.5 rounded-full">
                                {{ $product->downloads_count }}
                            </span>
                        </div>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="text-sm font-medium text-gray-700">Phiên bản:</div>
                        <div class="text-sm text-gray-900 font-semibold">{{ $product->version }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Phần bên phải: Thông tin sản phẩm -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Thông tin sản phẩm -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="border-b border-gray-200 px-4 py-4">
                <h3 class="text-lg font-medium text-gray-900">Thông tin sản phẩm</h3>
            </div>
            <div class="p-5">
                <div class="flex items-center mb-4">
                    <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        <i class="fas fa-folder mr-1"></i>
                        {{ $product->category->name ?? 'Không có danh mục' }}
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6 border-b border-gray-200 pb-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 mb-1">Giá sản phẩm</h4>
                        <div class="flex items-baseline">
                            <span class="text-2xl font-bold text-blue-600">{{ number_format($product->price, 0, ',', '.') }} VNĐ</span>
                            @if($product->sale_price)
                                <span class="ml-2 text-sm line-through text-gray-500">
                                    {{ number_format($product->sale_price, 0, ',', '.') }} VNĐ
                                </span>
                            @endif
                        </div>
                        
                        @if($product->sale_price)
                            <div class="mt-1">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-red-100 text-red-800">
                                    Tiết kiệm: {{ number_format($product->price - $product->sale_price, 0, ',', '.') }} VNĐ
                                    ({{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%)
                                </span>
                            </div>
                        @endif
                    </div>
                    
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 mb-1">Đường dẫn sản phẩm</h4>
                        <a href="{{ url('/products/' . $product->slug) }}" target="_blank" class="text-blue-600 hover:text-blue-800 break-all">
                            {{ url('/products/' . $product->slug) }}
                        </a>
                    </div>
                </div>

                <div class="mb-6 border-b border-gray-200 pb-6">
                    <h4 class="text-sm font-medium text-gray-500 mb-2">Mô tả ngắn</h4>
                    <p class="text-gray-700">{{ $product->short_description }}</p>
                </div>

                <div class="mb-6 border-b border-gray-200 pb-6">
                    <h4 class="text-sm font-medium text-gray-500 mb-2">Mô tả chi tiết</h4>
                    <div class="prose max-w-none bg-gray-50 p-4 rounded-lg border border-gray-200">
                        {!! $product->description !!}
                    </div>
                </div>

                <div>
                    <h4 class="text-sm font-medium text-gray-500 mb-2">Thời gian</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex">
                            <div class="text-gray-600 mr-2"><i class="fas fa-calendar-plus"></i></div>
                            <div>
                                <div class="text-xs font-medium text-gray-500">Ngày tạo</div>
                                <div class="text-sm text-gray-900">{{ $product->created_at->format('d/m/Y H:i:s') }}</div>
                            </div>
                        </div>
                        <div class="flex">
                            <div class="text-gray-600 mr-2"><i class="fas fa-calendar-check"></i></div>
                            <div>
                                <div class="text-xs font-medium text-gray-500">Cập nhật lần cuối</div>
                                <div class="text-sm text-gray-900">{{ $product->updated_at->format('d/m/Y H:i:s') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- License Keys Section -->
        @if($product->license_required)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="border-b border-gray-200 px-4 py-4 flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">License Keys</h3>
                    <a href="{{ route('admin.licenses.create', ['product_id' => $product->id]) }}" class="inline-flex items-center px-3 py-1 border border-transparent rounded-md text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-plus mr-1"></i> Tạo mới
                    </a>
                </div>
                <div class="p-4">
                    @if($product->licenses->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">License Key</th>
                                        <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Người dùng</th>
                                        <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày kích hoạt</th>
                                        <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày hết hạn</th>
                                        <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($product->licenses->take(5) as $license)
                                        <tr>
                                            <td class="px-4 py-2 whitespace-nowrap text-xs font-medium text-gray-900">{{ $license->license_key }}</td>
                                            <td class="px-4 py-2 whitespace-nowrap text-xs text-gray-700">{{ $license->user->name ?? 'Chưa gán' }}</td>
                                            <td class="px-4 py-2 whitespace-nowrap text-xs text-gray-700">{{ $license->activated_at ? $license->activated_at->format('d/m/Y') : 'Chưa kích hoạt' }}</td>
                                            <td class="px-4 py-2 whitespace-nowrap text-xs text-gray-700">{{ $license->expired_at ? $license->expired_at->format('d/m/Y') : 'Vĩnh viễn' }}</td>
                                            <td class="px-4 py-2 whitespace-nowrap text-xs">
                                                @if(!$license->activated_at)
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                        Chưa kích hoạt
                                                    </span>
                                                @elseif($license->expired_at && $license->expired_at->isPast())
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                        Hết hạn
                                                    </span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        Hoạt động
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        @if($product->licenses->count() > 5)
                            <div class="text-center mt-4">
                                <a href="{{ route('admin.licenses.index', ['product_id' => $product->id]) }}" class="inline-flex items-center px-3 py-1 border border-transparent rounded-md text-sm font-medium text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Xem tất cả {{ $product->licenses->count() }} license keys
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-6">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                <p class="mt-2 text-sm text-gray-500">Chưa có license key nào được tạo cho sản phẩm này</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Đơn hàng gần đây -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="border-b border-gray-200 px-4 py-4">
                <h3 class="text-lg font-medium text-gray-900">Đơn hàng gần đây</h3>
            </div>
            <div class="p-4">
                @if($product->orderItems->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mã đơn</th>
                                    <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Khách hàng</th>
                                    <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Giá</th>
                                    <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày mua</th>
                                    <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($product->orderItems->take(5) as $item)
                                    <tr>
                                        <td class="px-4 py-2 whitespace-nowrap text-xs font-medium text-blue-600 hover:text-blue-800">
                                            <a href="{{ route('admin.orders.show', $item->order) }}">
                                                #{{ $item->order->id }}
                                            </a>
                                        </td>
                                        <td class="px-4 py-2 whitespace-nowrap text-xs text-gray-700">{{ $item->order->user->name ?? 'Vô danh' }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap text-xs text-gray-700">{{ number_format($item->price, 0, ',', '.') }} VNĐ</td>
                                        <td class="px-4 py-2 whitespace-nowrap text-xs text-gray-700">{{ $item->order->created_at->format('d/m/Y') }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap text-xs">
                                            @if($item->order->status == 'pending')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    Chờ thanh toán
                                                </span>
                                            @elseif($item->order->status == 'paid')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Đã thanh toán
                                                </span>
                                            @elseif($item->order->status == 'cancelled')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Đã hủy
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    @if($product->orderItems->count() > 5)
                        <div class="text-center mt-4">
                            <a href="{{ route('admin.orders.index', ['product_id' => $product->id]) }}" class="inline-flex items-center px-3 py-1 border border-transparent rounded-md text-sm font-medium text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Xem tất cả {{ $product->orderItems->count() }} đơn hàng
                            </a>
                        </div>
                    @endif
                @else
                    <div class="text-center py-6">
                        <div class="flex flex-col items-center">
                            <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            <p class="mt-2 text-sm text-gray-500">Chưa có đơn hàng nào cho sản phẩm này</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection