@extends('layouts.app')

@section('title', 'Blog')

@section('content')
    <!-- Hero Section -->
    <div class="bg-gray-100 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-gray-900">Tin tức & Bài viết</h1>
                <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-500 sm:mt-4">
                    Cập nhật tin tức mới nhất về công nghệ và các sản phẩm của chúng tôi
                </p>
            </div>
        </div>
    </div>

    <!-- Featured Posts -->
    @if($featuredPosts->count() > 0)
        <div class="py-12 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-bold mb-6">Bài viết nổi bật</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($featuredPosts as $post)
                        <div class="bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300">
                            @if($post->featured_image)
                                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-400">Không có hình ảnh</span>
                                </div>
                            @endif
                            <div class="p-6">
                                <span class="text-sm text-blue-600 font-semibold">Nổi bật</span>
                                <h3 class="mt-2 text-xl font-semibold">
                                    <a href="{{ route('blog.show', $post->slug) }}" class="text-gray-900 hover:text-blue-600">
                                        {{ $post->title }}
                                    </a>
                                </h3>
                                <p class="mt-3 text-gray-500">
                                    {{ Str::limit($post->excerpt ?? strip_tags($post->content), 120) }}
                                </p>
                                <div class="mt-4 flex items-center">
                                    <div class="text-sm text-gray-500">
                                        <span>{{ $post->published_at->format('d/m/Y') }}</span> • 
                                        <span>{{ $post->user->name }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Recent Posts -->
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold mb-6">Bài viết mới nhất</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($posts as $post)
                    <div class="bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition-shadow duration-300">
                        @if($post->featured_image)
                            <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-400">Không có hình ảnh</span>
                            </div>
                        @endif
                        <div class="p-6">
                            <h3 class="text-lg font-semibold">
                                <a href="{{ route('blog.show', $post->slug) }}" class="text-gray-900 hover:text-blue-600">
                                    {{ $post->title }}
                                </a>
                            </h3>
                            <p class="mt-3 text-gray-500">
                                {{ Str::limit($post->excerpt ?? strip_tags($post->content), 100) }}
                            </p>
                            <div class="mt-4 flex items-center justify-between">
                                <div class="text-sm text-gray-500">
                                    {{ $post->published_at->format('d/m/Y') }}
                                </div>
                                <a href="{{ route('blog.show', $post->slug) }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800">
                                    Đọc tiếp →
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-12">
                        <p class="text-lg text-gray-500">Chưa có bài viết nào được đăng.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
@endsection