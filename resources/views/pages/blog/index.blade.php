@extends('layouts.app')

@section('title', 'Blog & News')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl font-bold mb-4">Blog & Industry News</h1>
            <p class="text-xl text-blue-100">Insights, tutorials, and updates from our team of software experts</p>
        </div>
    </div>
</section>

<!-- Featured Posts -->
@if(isset($featuredPosts) && $featuredPosts->count() > 0)
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
            <!-- Main Featured Post -->
            <div class="lg:col-span-3">
                <a href="{{ route('blog.show', $featuredPosts[0]->slug) }}" class="block group">
                    <div class="rounded-lg overflow-hidden shadow-lg h-full">
                        <div class="relative h-96">
                            @if($featuredPosts[0]->featured_image)
                                <img src="{{ asset('storage/' . $featuredPosts[0]->featured_image) }}" alt="{{ $featuredPosts[0]->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full bg-blue-600 flex items-center justify-center">
                                    <i class="fas fa-newspaper text-white text-6xl"></i>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end">
                                <div class="p-8">
                                    <span class="bg-blue-600 text-white text-xs font-medium px-2.5 py-1 rounded uppercase tracking-wider">Featured</span>
                                    <h2 class="text-2xl font-bold text-white mt-3">{{ $featuredPosts[0]->title }}</h2>
                                    <p class="text-gray-200 mt-2 line-clamp-2">{{ $featuredPosts[0]->excerpt }}</p>
                                    <div class="flex items-center mt-4">
                                        <span class="text-gray-200 text-sm">
                                            <i class="fas fa-calendar-alt mr-2"></i>
                                            {{ $featuredPosts[0]->published_at->format('M d, Y') }}
                                        </span>
                                        <span class="text-gray-200 text-sm ml-4">
                                            <i class="fas fa-user mr-2"></i>
                                            {{ $featuredPosts[0]->user->name }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            
            <!-- Secondary Featured Posts -->
            <div class="lg:col-span-2 grid grid-cols-1 gap-6">
                @for($i = 1; $i < min(3, $featuredPosts->count()); $i++)
                    <a href="{{ route('blog.show', $featuredPosts[$i]->slug) }}" class="block group">
                        <div class="rounded-lg overflow-hidden shadow-md h-full">
                            <div class="flex flex-col md:flex-row h-full">
                                <div class="md:w-2/5 relative">
                                    @if($featuredPosts[$i]->featured_image)
                                        <img src="{{ asset('storage/' . $featuredPosts[$i]->featured_image) }}" alt="{{ $featuredPosts[$i]->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-full bg-blue-500 flex items-center justify-center aspect-video md:aspect-auto">
                                            <i class="fas fa-newspaper text-white text-3xl"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="md:w-3/5 p-5 bg-white flex flex-col justify-center">
                                    <span class="text-xs text-blue-600 font-semibold mb-1">
                                        {{ $featuredPosts[$i]->category ?? 'Technology' }}
                                    </span>
                                    <h3 class="font-bold text-lg mb-2 group-hover:text-blue-600 transition-colors">{{ $featuredPosts[$i]->title }}</h3>
                                    <p class="text-gray-600 text-sm line-clamp-2">{{ $featuredPosts[$i]->excerpt }}</p>
                                    <span class="text-gray-500 text-xs mt-2">
                                        {{ $featuredPosts[$i]->published_at->format('M d, Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                @endfor
            </div>
        </div>
    </div>
</section>
@endif

<!-- Blog Categories -->
<section class="py-10 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="flex flex-wrap justify-center items-center gap-4">
            <a href="{{ route('blog.index') }}" class="px-4 py-2 {{ request()->routeIs('blog.index') && !request('category') ? 'bg-blue-600 text-white' : 'bg-white border border-gray-300 text-gray-700' }} rounded-md hover:bg-blue-600 hover:text-white transition-colors">All Posts</a>
            
            @foreach($categories as $category)
                <a href="{{ route('blog.category', $category->slug) }}" class="px-4 py-2 {{ request('category') == $category->slug ? 'bg-blue-600 text-white' : 'bg-white border border-gray-300 text-gray-700' }} rounded-md hover:bg-blue-600 hover:text-white transition-colors">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Blog Posts -->
<section class="py-12">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($posts as $post)
                <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform hover:shadow-lg flex flex-col h-full">
                    <a href="{{ route('blog.show', $post->slug) }}" class="block overflow-hidden">
                        <div class="h-48 bg-gray-200 relative overflow-hidden">
                            @if($post->featured_image)
                                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="flex items-center justify-center h-full bg-blue-600 text-white">
                                    <i class="fas fa-newspaper text-5xl"></i>
                                </div>
                            @endif
                        </div>
                    </a>
                    
                    <div class="p-6 flex-grow flex flex-col">
                        <div class="flex items-center text-gray-500 text-sm mb-3">
                            <span>
                                <i class="far fa-calendar mr-1"></i>
                                {{ $post->published_at->format('M d, Y') }}
                            </span>
                            <span class="mx-2">•</span>
                            <span>
                                <i class="far fa-clock mr-1"></i>
                                {{ ceil(str_word_count(strip_tags($post->content)) / 200) }} min read
                            </span>
                        </div>
                        
                        <a href="{{ route('blog.show', $post->slug) }}" class="block group">
                            <h3 class="text-xl font-bold mb-3 group-hover:text-blue-600 transition-colors">{{ $post->title }}</h3>
                        </a>
                        
                        <p class="text-gray-600 mb-6 line-clamp-3 flex-grow">{{ $post->excerpt }}</p>
                        
                        <div class="flex items-center justify-between mt-auto">
                            <a href="{{ route('blog.show', $post->slug) }}" class="text-blue-600 hover:text-blue-800 font-medium inline-flex items-center">
                                Read More
                                <i class="fas fa-arrow-right ml-2 text-sm"></i>
                            </a>
                            
                            <div class="flex items-center text-gray-500 text-sm">
                                <span>
                                    <i class="far fa-comment mr-1"></i>
                                    {{ $post->comments_count ?? 0 }}
                                </span>
                                <span class="ml-3">
                                    <i class="far fa-eye mr-1"></i>
                                    {{ $post->views ?? 0 }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-20">
                    <div class="text-5xl text-gray-300 mb-4">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    <h3 class="text-xl font-medium text-gray-600 mb-1">No Posts Found</h3>
                    <p class="text-gray-500">Check back later for new content or try a different category.</p>
                </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        <div class="mt-12">
            {{ $posts->links() }}
        </div>
    </div>
</section>

<!-- Newsletter Signup -->
<section class="py-16 bg-blue-700 text-white">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center">
            <h3 class="text-2xl font-bold mb-4">Subscribe to Our Newsletter</h3>
            <p class="text-blue-100 mb-6">Stay updated with the latest insights, tutorials, and news from our team</p>
            
            <form class="flex flex-col md:flex-row gap-3">
                <input type="email" placeholder="Your email address" class="flex-grow px-4 py-3 rounded-md focus:outline-none text-gray-800">
                <button type="submit" class="bg-white text-blue-700 px-6 py-3 rounded-md font-semibold hover:bg-blue-50 transition-colors">
                    Subscribe
                </button>
            </form>
            
            <p class="text-sm text-blue-200 mt-4">We respect your privacy. Unsubscribe at any time.</p>
        </div>
    </div>
</section>
@endsection