@extends('layouts.app')

@section('title', __('blog.blog_title'))

@section('content')
    <!-- Blog Header Section -->
    <section class="bg-blue-600 py-16 text-white">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-4xl font-bold mb-4">{{ __('blog.blog_title') }}</h1>
                <p class="text-xl text-blue-100">{{ __('blog.blog_subtitle') }}</p>
            </div>
        </div>
    </section>
    
    <!-- Main Blog Content Section -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap -mx-4">
                <!-- Blog Posts Column -->
                <div class="w-full lg:w-2/3 px-4">
                    <!-- Featured Posts -->
                    @if(isset($featuredPosts) && $featuredPosts->count() > 0 && !isset($category))
                        <div class="mb-12">
                            <h2 class="text-2xl font-bold mb-6">{{ __('blog.popular_posts') }}</h2>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                @foreach($featuredPosts as $post)
                                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                                        <div class="h-48 bg-gray-200 relative">
                                            @if($post->featured_image)
                                                <img src="{{ asset($post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-gray-500">
                                                    <i class="fas fa-image text-4xl"></i>
                                                </div>
                                            @endif
                                            @if($post->category)
                                                <span class="absolute top-2 right-2 bg-blue-600 text-white text-xs uppercase py-1 px-2 rounded">
                                                    {{ $post->category->name }}
                                                </span>
                                            @endif
                                        </div>
                                        <div class="p-4">
                                            <h3 class="text-lg font-semibold mb-2">
                                                <a href="{{ route('blog.show', $post->slug) }}" class="text-gray-800 hover:text-blue-600">
                                                    {{ $post->title }}
                                                </a>
                                            </h3>
                                            <div class="flex items-center text-sm text-gray-500 mb-3">
                                                <span class="mr-4">{{ \Carbon\Carbon::parse($post->published_at)->format('M d, Y') }}</span>
                                                <span>{{ $post->read_time ?? 5 }} {{ __('blog.minutes') }}</span>
                                            </div>
                                            <p class="text-gray-600 mb-4 line-clamp-3">{{ $post->excerpt }}</p>
                                            <a href="{{ route('blog.show', $post->slug) }}" class="text-blue-600 font-medium hover:text-blue-800">
                                                {{ __('general.read_more') }} →
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    
                    <!-- Regular Posts -->
                    <div>
                        @if(isset($category))
                            <h2 class="text-2xl font-bold mb-6">{{ $category->name }}</h2>
                        @else
                            <h2 class="text-2xl font-bold mb-6">{{ __('blog.recent_posts') }}</h2>
                        @endif
                        
                        @if($posts->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($posts as $post)
                                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                                        <div class="h-48 bg-gray-200 relative">
                                            @if($post->featured_image)
                                                <img src="{{ asset($post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-gray-500">
                                                    <i class="fas fa-image text-4xl"></i>
                                                </div>
                                            @endif
                                            @if($post->category)
                                                <span class="absolute top-2 right-2 bg-blue-600 text-white text-xs uppercase py-1 px-2 rounded">
                                                    {{ $post->category->name }}
                                                </span>
                                            @endif
                                        </div>
                                        <div class="p-4">
                                            <h3 class="text-lg font-semibold mb-2">
                                                <a href="{{ route('blog.show', $post->slug) }}" class="text-gray-800 hover:text-blue-600">
                                                    {{ $post->title }}
                                                </a>
                                            </h3>
                                            <div class="flex items-center text-sm text-gray-500 mb-3">
                                                <span class="mr-4">{{ \Carbon\Carbon::parse($post->published_at)->format('M d, Y') }}</span>
                                                <span>{{ $post->read_time ?? 5 }} {{ __('blog.minutes') }}</span>
                                            </div>
                                            <p class="text-gray-600 mb-4 line-clamp-3">{{ $post->excerpt }}</p>
                                            <a href="{{ route('blog.show', $post->slug) }}" class="text-blue-600 font-medium hover:text-blue-800">
                                                {{ __('general.read_more') }} →
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <!-- Pagination -->
                            <div class="mt-8">
                                {{ $posts->links() }}
                            </div>
                        @else
                            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                                <p class="text-gray-600">{{ __('blog.no_posts_found') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Sidebar Column -->
                <div class="w-full lg:w-1/3 px-4 mt-12 lg:mt-0">
                    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                        <h3 class="text-xl font-bold mb-4">{{ __('blog.categories') }}</h3>
                        <ul class="space-y-2">
                            @foreach($categories as $cat)
                                <li>
                                    <a href="{{ route('blog.category', $cat->slug) }}" 
                                       class="flex items-center justify-between py-2 px-3 rounded-md hover:bg-gray-100 {{ isset($category) && $category->id === $cat->id ? 'bg-blue-100 text-blue-600 font-medium' : 'text-gray-700' }}">
                                        <span>{{ $cat->name }}</span>
                                        <span class="bg-gray-200 text-gray-700 text-xs rounded-full px-2 py-1">{{ $cat->posts_count }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <!-- Recent Posts Widget -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-xl font-bold mb-4">{{ __('blog.recent_posts') }}</h3>
                        @if(isset($recentPosts))
                            <ul class="space-y-4">
                                @foreach($recentPosts as $recentPost)
                                    <li class="flex items-start">
                                        <div class="flex-shrink-0 w-16 h-16 bg-gray-200 rounded-md overflow-hidden mr-4">
                                            @if($recentPost->featured_image)
                                                <img src="{{ asset($recentPost->featured_image) }}" alt="{{ $recentPost->title }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-gray-500">
                                                    <i class="fas fa-image"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h4 class="font-medium">
                                                <a href="{{ route('blog.show', $recentPost->slug) }}" class="text-gray-800 hover:text-blue-600">
                                                    {{ $recentPost->title }}
                                                </a>
                                            </h4>
                                            <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($recentPost->published_at)->format('M d, Y') }}</span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-600">{{ __('blog.no_posts_found') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection