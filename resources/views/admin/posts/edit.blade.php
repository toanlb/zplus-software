@extends('admin.layouts.app')

@section('title', 'Sửa bài viết')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Sửa bài viết</h1>
        </div>

        <!-- Flash Message -->
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 flex justify-between items-center border-b border-gray-200">
                <h2 class="text-lg leading-6 font-medium text-gray-900">{{ $post->title }}</h2>
                <a href="{{ route('admin.posts.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                    Quay lại
                </a>
            </div>
            
            <div class="px-4 py-5 sm:p-6">
                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Có {{ $errors->count() }} lỗi với form:</h3>
                                <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
                
                <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <!-- Tiêu đề -->
                        <div class="sm:col-span-6">
                            <label for="title" class="block text-sm font-medium text-gray-700">Tiêu đề *</label>
                            <div class="mt-1">
                                <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}" 
                                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>
                        
                        <!-- Slug (automatically generated) -->
                        <div class="sm:col-span-6">
                            <label for="slug" class="block text-sm font-medium text-gray-700">Slug (tự động tạo)</label>
                            <div class="mt-1">
                                <div class="shadow-sm bg-gray-50 block w-full sm:text-sm border-gray-300 rounded-md px-3 py-2">
                                    {{ $post->slug }}
                                </div>
                            </div>
                        </div>
                        
                        <!-- Tóm tắt -->
                        <div class="sm:col-span-6">
                            <label for="excerpt" class="block text-sm font-medium text-gray-700">
                                Tóm tắt
                                <span class="text-gray-500 text-xs">(không bắt buộc)</span>
                            </label>
                            <div class="mt-1">
                                <textarea id="excerpt" name="excerpt" rows="3"
                                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ old('excerpt', $post->excerpt) }}</textarea>
                            </div>
                            <p class="mt-2 text-sm text-gray-500">Mô tả ngắn gọn về bài viết.</p>
                        </div>
                        
                        <!-- Nội dung với TinyMCE -->
                        <div class="sm:col-span-6">
                            <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Nội dung *</label>
                            <x-tin-mce-editor id="content" name="content" value="{{ old('content', $post->content) }}" />
                        </div>
                        
                        <!-- Ảnh đại diện -->
                        <div class="sm:col-span-6">
                            <label class="block text-sm font-medium text-gray-700">Ảnh đại diện hiện tại</label>
                            @if ($post->featured_image)
                                <div class="mt-2 mb-4">
                                    <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" 
                                        class="max-h-64 rounded-lg shadow">
                                </div>
                            @else
                                <div class="mt-2 mb-4 bg-gray-100 p-4 rounded text-gray-500 text-sm">
                                    Không có ảnh đại diện
                                </div>
                            @endif
                            
                            <label for="featured_image" class="block text-sm font-medium text-gray-700">
                                Upload ảnh mới
                                <span class="text-gray-500 text-xs">(không bắt buộc)</span>
                            </label>
                            <div class="mt-1 flex items-center">
                                <input type="file" id="featured_image" name="featured_image" accept="image/*" 
                                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300">
                            </div>
                            <p class="mt-2 text-sm text-gray-500">PNG, JPG, GIF lên đến 2MB</p>
                        </div>
                        
                        <!-- Trạng thái -->
                        <div class="sm:col-span-3">
                            <label for="status" class="block text-sm font-medium text-gray-700">Trạng thái *</label>
                            <div class="mt-1">
                                <select id="status" name="status" 
                                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    <option value="draft" {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}>Bản nháp</option>
                                    <option value="published" {{ old('status', $post->status) == 'published' ? 'selected' : '' }}>Đã xuất bản</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Ngày xuất bản -->
                        <div class="sm:col-span-3">
                            <label for="published_at" class="block text-sm font-medium text-gray-700">
                                Ngày xuất bản
                                <span class="text-gray-500 text-xs">(để trống sẽ lấy thời điểm hiện tại)</span>
                            </label>
                            <div class="mt-1">
                                <input type="datetime-local" name="published_at" id="published_at" 
                                    value="{{ old('published_at', $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}" 
                                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>
                        
                        <!-- Nổi bật -->
                        <div class="sm:col-span-6">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="is_featured" name="is_featured" type="checkbox" value="1" 
                                        {{ old('is_featured', $post->is_featured) ? 'checked' : '' }}
                                        class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="is_featured" class="font-medium text-gray-700">Đánh dấu bài viết là nổi bật</label>
                                    <p class="text-gray-500">Các bài viết nổi bật sẽ được hiển thị ưu tiên trên trang chủ.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Cập nhật bài viết
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Simple preview of selected image
        document.getElementById('featured_image').addEventListener('change', function(e) {
            if (e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // If there's a preview element, update it. Otherwise ignore.
                    const preview = document.querySelector('.image-preview');
                    if (preview) {
                        preview.src = e.target.result;
                    }
                }
                reader.readAsDataURL(e.target.files[0]);
            }
        });
    </script>
@endpush