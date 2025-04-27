@extends('admin.layouts.app')

@section('title', 'Thêm Sản phẩm mới')
@section('header', 'Thêm Sản phẩm mới')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold text-gray-800">Thêm sản phẩm mới</h2>
    <a href="{{ route('admin.products.index') }}" class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
        <i class="fas fa-arrow-left mr-2"></i>
        Quay lại danh sách
    </a>
</div>

<div class="bg-white shadow-md rounded-lg overflow-hidden">
    <div class="p-4 sm:p-6 border-b border-gray-200">
        <h3 class="text-lg font-medium leading-6 text-gray-900">Thông tin sản phẩm</h3>
        <p class="mt-1 text-sm text-gray-600">Nhập đầy đủ các thông tin cần thiết cho sản phẩm mới.</p>
    </div>
    
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="p-4 sm:p-6">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                        Tên sản phẩm <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                        class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('name') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">
                        Danh mục <span class="text-red-500">*</span>
                    </label>
                    <select id="category_id" name="category_id" required
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md @error('category_id') border-red-300 text-red-900 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror">
                        <option value="">-- Chọn danh mục --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="short_description" class="block text-sm font-medium text-gray-700 mb-1">
                        Mô tả ngắn <span class="text-red-500">*</span>
                    </label>
                    <textarea id="short_description" name="short_description" rows="3" required
                        class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('short_description') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror">{{ old('short_description') }}</textarea>
                    @error('short_description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="thumbnail" class="block text-sm font-medium text-gray-700 mb-1">
                        Hình ảnh đại diện
                    </label>
                    <div class="mt-1 flex items-center">
                        <div class="w-full flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="thumbnail" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                        <span>Tải lên một file</span>
                                        <input id="thumbnail" name="thumbnail" type="file" class="sr-only">
                                    </label>
                                    <p class="pl-1">hoặc kéo thả vào đây</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF tối đa 2MB</p>
                            </div>
                        </div>
                    </div>
                    @error('thumbnail')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="space-y-6">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">
                            Giá <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="number" id="price" name="price" value="{{ old('price') }}" min="0" step="0.01" required
                                class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-3 pr-12 sm:text-sm border-gray-300 rounded-md @error('price') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">VNĐ</span>
                            </div>
                        </div>
                        @error('price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="sale_price" class="block text-sm font-medium text-gray-700 mb-1">
                            Giá khuyến mãi
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="number" id="sale_price" name="sale_price" value="{{ old('sale_price') }}" min="0" step="0.01"
                                class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-3 pr-12 sm:text-sm border-gray-300 rounded-md @error('sale_price') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">VNĐ</span>
                            </div>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Để trống nếu không có khuyến mãi</p>
                        @error('sale_price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div>
                    <label for="version" class="block text-sm font-medium text-gray-700 mb-1">
                        Phiên bản <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="version" name="version" value="{{ old('version') }}" required
                        class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('version') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror">
                    @error('version')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="download_file" class="block text-sm font-medium text-gray-700 mb-1">
                        File phần mềm
                    </label>
                    <div class="mt-1 flex items-center">
                        <div class="w-full flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="download_file" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                        <span>Tải lên file</span>
                                        <input id="download_file" name="download_file" type="file" class="sr-only">
                                    </label>
                                    <p class="pl-1">hoặc kéo thả vào đây</p>
                                </div>
                                <p class="text-xs text-gray-500">Kích thước tối đa 100MB</p>
                            </div>
                        </div>
                    </div>
                    @error('download_file')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex space-x-8">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="license_required" name="license_required" type="checkbox" value="1" {{ old('license_required') ? 'checked' : '' }}
                                class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="license_required" class="font-medium text-gray-700">Yêu cầu license key</label>
                            <p class="text-gray-500">Chọn nếu sản phẩm yêu cầu kích hoạt bằng license key</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="is_active" name="is_active" type="checkbox" value="1" {{ old('is_active', '1') === '1' ? 'checked' : '' }}
                                class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="is_active" class="font-medium text-gray-700">Sản phẩm đang được bán</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-6">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                Mô tả chi tiết <span class="text-red-500">*</span>
            </label>
            <textarea id="description" name="description" rows="8" required
                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('description') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror">{{ old('description') }}</textarea>
            @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mt-8 flex justify-center">
            <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <i class="fas fa-save mr-2"></i>
                Lưu sản phẩm
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Kích hoạt trình soạn thảo rich text cho mô tả chi tiết
        if (typeof(CKEDITOR) !== 'undefined') {
            CKEDITOR.replace('description', {
                filebrowserImageBrowseUrl: '/filemanager?type=Images',
                filebrowserImageUploadUrl: '/filemanager/upload?type=Images&_token=',
                filebrowserBrowseUrl: '/filemanager?type=Files',
                filebrowserUploadUrl: '/filemanager/upload?type=Files&_token='
            });
        }

        // Hiệu ứng hiển thị xem trước hình ảnh khi upload
        function readURL(input, previewElement) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function(e) {
                    let preview = $('<div class="mt-2 relative rounded-md overflow-hidden" style="max-width: 200px;"><img src="' + e.target.result + '" class="w-full h-auto" /><button type="button" class="absolute top-0 right-0 bg-red-500 text-white rounded-full p-1 m-1 clear-preview"><i class="fas fa-times"></i></button></div>');
                    $(previewElement).after(preview);
                    
                    preview.find('.clear-preview').click(function() {
                        preview.remove();
                        input.value = '';
                    });
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#thumbnail").change(function() {
            $(".mt-2.relative.rounded-md.overflow-hidden").remove();
            readURL(this, $(this).closest('div.mt-1'));
        });

        // Hiệu ứng drag & drop
        ['thumbnail', 'download_file'].forEach(function(id) {
            const dropZone = document.querySelector(`label[for="${id}"]`).closest('.w-full');
            
            dropZone.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.classList.add('border-blue-400', 'bg-blue-50');
            });
            
            dropZone.addEventListener('dragleave', function(e) {
                e.preventDefault();
                this.classList.remove('border-blue-400', 'bg-blue-50');
            });
            
            dropZone.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('border-blue-400', 'bg-blue-50');
                document.getElementById(id).files = e.dataTransfer.files;
                
                if (id === 'thumbnail') {
                    readURL(document.getElementById(id), this);
                }
            });
        });
    });
</script>
@endpush
@endsection