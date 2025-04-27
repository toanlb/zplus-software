@extends('admin.layouts.app')

@section('title', 'Chi tiết bài viết')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <a href="{{ route('admin.posts.index') }}" class="flex items-center text-blue-600 hover:text-blue-800">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Quay lại danh sách
            </a>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
            <div class="px-4 py-5 sm:px-6 flex justify-between">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Chi tiết bài viết
                    </h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        Thông tin chi tiết về bài viết.
                    </p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.posts.edit', $post) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Chỉnh sửa
                    </a>
                    <form action="{{ route('admin.posts.destroy', $post) }}" method="POST"
                          onsubmit="return confirm('Bạn có chắc chắn muốn xóa bài viết này?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                            Xóa
                        </button>
                    </form>
                </div>
            </div>

            <div class="border-t border-gray-200">
                @if ($post->featured_image)
                    <div class="w-full h-64 md:h-80 bg-gray-100 overflow-hidden">
                        <img src="{{ asset('storage/' . $post->featured_image) }}" 
                             alt="{{ $post->title }}"
                             class="w-full h-full object-cover">
                    </div>
                @endif

                <div class="px-4 py-5 sm:px-6">
                    <div class="mb-6">
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $post->title }}</h1>
                        <div class="flex items-center text-sm text-gray-500">
                            <span>{{ $post->created_at->format('d/m/Y H:i') }}</span>
                            <span class="mx-2">&bull;</span>
                            <span>{{ $post->user->name }}</span>
                            
                            @if ($post->is_featured)
                                <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Nổi bật
                                </span>
                            @endif
                            
                            @if ($post->status == 'draft')
                                <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    Bản nháp
                                </span>
                            @else
                                <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Đã xuất bản
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="prose max-w-none">
                        {!! $post->content !!}
                    </div>

                    @if ($post->meta_description)
                        <div class="mt-6 p-4 bg-gray-50 rounded-md">
                            <h2 class="text-sm font-medium text-gray-500 mb-2">Mô tả meta (SEO)</h2>
                            <p class="text-sm text-gray-700">{{ $post->meta_description }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection