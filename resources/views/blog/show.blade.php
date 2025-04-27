@extends('layouts.app')

@section('title', $post->title)
@section('meta_description', $post->excerpt ?? Str::limit(strip_tags($post->content), 160))

@section('content')
    <!-- Article Header -->
    <div class="bg-gray-100 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-900 sm:text-4xl">{{ $post->title }}</h1>
                <div class="mt-3 flex items-center justify-center text-sm text-gray-500">
                    <span>{{ $post->published_at->format('d/m/Y') }}</span>
                    <span class="mx-2">&bull;</span>
                    <span>{{ $post->user->name }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Article Content -->
    <div class="py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Featured Image -->
            @if($post->featured_image)
                <div class="mb-8">
                    <img src="{{ asset('storage/' . $post->featured_image) }}" 
                         alt="{{ $post->title }}" 
                         class="w-full rounded-lg shadow-md">
                </div>
            @endif

            <!-- Excerpt if exists -->
            @if($post->excerpt)
                <div class="mb-8">
                    <p class="text-xl text-gray-700 font-semibold">
                        {{ $post->excerpt }}
                    </p>
                </div>
            @endif

            <!-- Content -->
            <div class="prose prose-lg max-w-none">
                {!! $post->content !!}
            </div>
        </div>
    </div>

    <!-- Related Posts -->
    @if($relatedPosts->count() > 0)
        <div class="py-10 bg-gray-50">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-bold mb-6">Bài viết liên quan</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedPosts as $relatedPost)
                        <div class="bg-white rounded-lg overflow-hidden shadow">
                            @if($relatedPost->featured_image)
                                <img src="{{ asset('storage/' . $relatedPost->featured_image) }}" 
                                     alt="{{ $relatedPost->title }}" 
                                     class="w-full h-40 object-cover">
                            @else
                                <div class="w-full h-40 bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-400">Không có hình ảnh</span>
                                </div>
                            @endif
                            <div class="p-5">
                                <h3 class="text-lg font-semibold">
                                    <a href="{{ route('blog.show', $relatedPost->slug) }}" 
                                       class="text-gray-900 hover:text-blue-600">
                                        {{ $relatedPost->title }}
                                    </a>
                                </h3>
                                <p class="mt-2 text-sm text-gray-500">
                                    {{ $relatedPost->published_at->format('d/m/Y') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Back to Blog -->
    <div class="py-6">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('blog.index') }}" 
               class="inline-flex items-center text-blue-600 hover:text-blue-800">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Quay lại danh sách bài viết
            </a>
        </div>
    </div>
@endsection