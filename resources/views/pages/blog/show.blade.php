@extends('layouts.app')

@section('title', $post->title)

@section('content')
<!-- Breadcrumbs -->
<section class="bg-gray-50 py-4 border-b">
    <div class="container mx-auto px-4">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600 text-sm">
                        <i class="fas fa-home mr-2"></i>
                        Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 text-sm mx-1"></i>
                        <a href="{{ route('blog.index') }}" class="text-gray-700 hover:text-blue-600 text-sm">Blog</a>
                    </div>
                </li>
                @if($post->category)
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 text-sm mx-1"></i>
                        <a href="{{ route('blog.category', $post->category->slug) }}" class="text-gray-700 hover:text-blue-600 text-sm">{{ $post->category->name }}</a>
                    </div>
                </li>
                @endif
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 text-sm mx-1"></i>
                        <span class="text-gray-500 text-sm">{{ Str::limit($post->title, 40) }}</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>
</section>

<div class="bg-white py-12">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-12">
            <!-- Main Content -->
            <div class="lg:w-2/3">
                <!-- Article Header -->
                <div class="mb-8">
                    <h1 class="text-3xl md:text-4xl font-bold mb-4">{{ $post->title }}</h1>
                    
                    <div class="flex flex-wrap gap-4 items-center text-sm text-gray-600 mb-6">
                        <span class="flex items-center">
                            <i class="far fa-calendar mr-2"></i>
                            {{ $post->published_at->format('F d, Y') }}
                        </span>
                        
                        <span class="flex items-center">
                            <i class="far fa-user mr-2"></i>
                            {{ $post->user->name }}
                        </span>
                        
                        @if($post->category)
                            <a href="{{ route('blog.category', $post->category->slug) }}" class="flex items-center hover:text-blue-600">
                                <i class="far fa-folder mr-2"></i>
                                {{ $post->category->name }}
                            </a>
                        @endif
                        
                        <span class="flex items-center">
                            <i class="far fa-eye mr-2"></i>
                            {{ $post->views ?? 0 }} Views
                        </span>
                        
                        <span class="flex items-center">
                            <i class="far fa-clock mr-2"></i>
                            {{ ceil(str_word_count(strip_tags($post->content)) / 200) }} min read
                        </span>
                    </div>
                    
                    <!-- Share Buttons -->
                    <div class="flex gap-2">
                        <a href="#" class="w-8 h-8 bg-blue-600 text-white flex items-center justify-center rounded-full hover:bg-blue-700 transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-8 h-8 bg-blue-400 text-white flex items-center justify-center rounded-full hover:bg-blue-500 transition-colors">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-8 h-8 bg-blue-700 text-white flex items-center justify-center rounded-full hover:bg-blue-800 transition-colors">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="w-8 h-8 bg-green-600 text-white flex items-center justify-center rounded-full hover:bg-green-700 transition-colors">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="#" class="w-8 h-8 bg-gray-100 text-gray-500 flex items-center justify-center rounded-full hover:bg-gray-200 transition-colors">
                            <i class="fas fa-link"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Featured Image -->
                @if($post->featured_image)
                    <div class="mb-8 rounded-lg overflow-hidden shadow-md">
                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-auto">
                    </div>
                @endif
                
                <!-- Article Content -->
                <div class="prose max-w-none mb-10">
                    {!! $post->content !!}
                </div>
                
                <!-- Tags -->
                @if(isset($post->tags) && count($post->tags) > 0)
                    <div class="flex flex-wrap gap-2 mb-10">
                        @foreach($post->tags as $tag)
                            <a href="#" class="bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm px-3 py-1 rounded-full transition-colors">
                                #{{ $tag }}
                            </a>
                        @endforeach
                    </div>
                @endif
                
                <!-- Author Box -->
                <div class="bg-gray-50 p-6 rounded-lg mb-10 border border-gray-200">
                    <div class="flex items-center">
                        <div class="mr-4">
                            @if($post->user->avatar)
                                <img src="{{ asset('storage/' . $post->user->avatar) }}" alt="{{ $post->user->name }}" class="w-16 h-16 rounded-full">
                            @else
                                <div class="w-16 h-16 rounded-full bg-blue-600 flex items-center justify-center text-white text-xl font-bold">
                                    {{ substr($post->user->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        
                        <div class="flex-grow">
                            <h3 class="font-bold text-lg">{{ $post->user->name }}</h3>
                            @if($post->user->title)
                                <p class="text-gray-600 text-sm">{{ $post->user->title }}</p>
                            @else
                                <p class="text-gray-600 text-sm">Author</p>
                            @endif
                            <div class="flex gap-2 mt-2">
                                <a href="#" class="text-blue-600 hover:text-blue-800"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="text-blue-600 hover:text-blue-800"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#" class="text-blue-600 hover:text-blue-800"><i class="fab fa-github"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Navigation -->
                <div class="flex flex-col sm:flex-row justify-between border-t border-b border-gray-200 py-6 mb-10">
                    <a href="#" class="group flex items-center mb-4 sm:mb-0">
                        <i class="fas fa-arrow-left mr-3 text-gray-400 group-hover:text-blue-600"></i>
                        <div>
                            <span class="block text-xs text-gray-500">Previous Post</span>
                            <span class="font-medium group-hover:text-blue-600">How to optimize your software development process</span>
                        </div>
                    </a>
                    
                    <a href="#" class="group flex items-center text-right">
                        <div>
                            <span class="block text-xs text-gray-500">Next Post</span>
                            <span class="font-medium group-hover:text-blue-600">Top 10 emerging technologies in 2025</span>
                        </div>
                        <i class="fas fa-arrow-right ml-3 text-gray-400 group-hover:text-blue-600"></i>
                    </a>
                </div>
                
                <!-- Comments Section -->
                <div class="mb-10">
                    <h3 class="text-xl font-bold mb-6">Comments (5)</h3>
                    
                    <!-- Comment Form -->
                    <div class="bg-gray-50 p-6 rounded-lg mb-8 border border-gray-200">
                        <h4 class="font-medium mb-4">Leave a Comment</h4>
                        <form>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                                    <input type="text" id="name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600" required>
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                                    <input type="email" id="email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="comment" class="block text-sm font-medium text-gray-700 mb-1">Comment *</label>
                                <textarea id="comment" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600" required></textarea>
                            </div>
                            <div class="flex items-center mb-4">
                                <input type="checkbox" id="saveInfo" class="mr-2">
                                <label for="saveInfo" class="text-sm text-gray-700">Save my name and email for the next time I comment</label>
                            </div>
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors">
                                Submit Comment
                            </button>
                        </form>
                    </div>
                    
                    <!-- Comments List -->
                    <div class="space-y-6">
                        <!-- Comment 1 -->
                        <div class="border-b border-gray-200 pb-6">
                            <div class="flex mb-4">
                                <div class="mr-3">
                                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-semibold">
                                        JD
                                    </div>
                                </div>
                                <div class="flex-grow">
                                    <div class="flex justify-between items-center mb-1">
                                        <h5 class="font-medium">Jane Doe</h5>
                                        <span class="text-xs text-gray-500">April 24, 2025</span>
                                    </div>
                                    <p class="text-gray-600">This is such a helpful article! I've been struggling with the concepts explained here, and this made it much clearer. Thank you for sharing your expertise.</p>
                                    <button class="text-blue-600 text-sm mt-2 hover:text-blue-800">Reply</button>
                                </div>
                            </div>
                            
                            <!-- Nested Reply -->
                            <div class="flex ml-12 mt-4">
                                <div class="mr-3">
                                    <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold">
                                        {{ substr($post->user->name, 0, 1) }}
                                    </div>
                                </div>
                                <div class="flex-grow">
                                    <div class="flex justify-between items-center mb-1">
                                        <h5 class="font-medium">{{ $post->user->name }} <span class="text-xs bg-blue-100 text-blue-600 px-2 py-0.5 rounded-full">Author</span></h5>
                                        <span class="text-xs text-gray-500">April 24, 2025</span>
                                    </div>
                                    <p class="text-gray-600">Thank you for your kind words, Jane! I'm glad you found the article helpful. Let me know if you have any questions.</p>
                                    <button class="text-blue-600 text-sm mt-2 hover:text-blue-800">Reply</button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Comment 2 -->
                        <div>
                            <div class="flex mb-4">
                                <div class="mr-3">
                                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-semibold">
                                        MS
                                    </div>
                                </div>
                                <div class="flex-grow">
                                    <div class="flex justify-between items-center mb-1">
                                        <h5 class="font-medium">Mike Smith</h5>
                                        <span class="text-xs text-gray-500">April 23, 2025</span>
                                    </div>
                                    <p class="text-gray-600">I've implemented some of these strategies in my own workflow and have seen great improvements. One thing I'd like to add is the importance of regular code reviews, which helps catch issues early on.</p>
                                    <button class="text-blue-600 text-sm mt-2 hover:text-blue-800">Reply</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="lg:w-1/3 space-y-8">
                <!-- Search -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="font-bold mb-4">Search</h3>
                    <form>
                        <div class="flex">
                            <input type="text" placeholder="Search articles..." class="flex-grow px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent">
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-r-md hover:bg-blue-700 transition-colors">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Categories -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="font-bold mb-4">Categories</h3>
                    <ul class="space-y-2">
                        @foreach($categories ?? [] as $category)
                            <li>
                                <a href="{{ route('blog.category', $category->slug) }}" class="flex justify-between items-center text-gray-700 hover:text-blue-600">
                                    <span>{{ $category->name }}</span>
                                    <span class="bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded-full">{{ $category->posts_count }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                
                <!-- Recent Posts -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="font-bold mb-4">Recent Posts</h3>
                    <div class="space-y-4">
                        @foreach($recentPosts ?? $relatedPosts ?? [] as $recentPost)
                            <a href="{{ route('blog.show', $recentPost->slug) }}" class="flex group">
                                <div class="w-20 h-20 bg-gray-200 rounded overflow-hidden mr-4">
                                    @if($recentPost->featured_image)
                                        <img src="{{ asset('storage/' . $recentPost->featured_image) }}" alt="{{ $recentPost->title }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-blue-600 flex items-center justify-center text-white">
                                            <i class="fas fa-newspaper"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="font-medium group-hover:text-blue-600">{{ Str::limit($recentPost->title, 50) }}</h4>
                                    <p class="text-xs text-gray-500">{{ $recentPost->published_at->format('M d, Y') }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
                
                <!-- Tags Cloud -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="font-bold mb-4">Tags</h3>
                    <div class="flex flex-wrap gap-2">
                        <a href="#" class="bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm px-3 py-1 rounded-full transition-colors">
                            #technology
                        </a>
                        <a href="#" class="bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm px-3 py-1 rounded-full transition-colors">
                            #software
                        </a>
                        <a href="#" class="bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm px-3 py-1 rounded-full transition-colors">
                            #development
                        </a>
                        <a href="#" class="bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm px-3 py-1 rounded-full transition-colors">
                            #programming
                        </a>
                        <a href="#" class="bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm px-3 py-1 rounded-full transition-colors">
                            #ai
                        </a>
                        <a href="#" class="bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm px-3 py-1 rounded-full transition-colors">
                            #machinelearning
                        </a>
                        <a href="#" class="bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm px-3 py-1 rounded-full transition-colors">
                            #web
                        </a>
                        <a href="#" class="bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm px-3 py-1 rounded-full transition-colors">
                            #database
                        </a>
                    </div>
                </div>
                
                <!-- Newsletter -->
                <div class="bg-blue-600 text-white p-6 rounded-lg shadow-md">
                    <h3 class="font-bold mb-4">Subscribe to Our Newsletter</h3>
                    <p class="text-blue-100 mb-4">Get the latest posts and updates delivered straight to your inbox.</p>
                    <form>
                        <div class="mb-3">
                            <input type="email" placeholder="Your email address" class="w-full px-4 py-2 text-gray-800 rounded-md focus:outline-none">
                        </div>
                        <button type="submit" class="w-full bg-white text-blue-600 font-medium px-4 py-2 rounded-md hover:bg-blue-50 transition-colors">
                            Subscribe Now
                        </button>
                    </form>
                    <p class="text-xs text-blue-200 mt-3">We respect your privacy. Unsubscribe anytime.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Related Posts -->
<section class="bg-gray-50 py-16">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-12 text-center">Related Articles</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($relatedPosts as $relatedPost)
                <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform hover:shadow-lg">
                    <a href="{{ route('blog.show', $relatedPost->slug) }}" class="block overflow-hidden">
                        <div class="h-48 bg-gray-200 relative overflow-hidden">
                            @if($relatedPost->featured_image)
                                <img src="{{ asset('storage/' . $relatedPost->featured_image) }}" alt="{{ $relatedPost->title }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="flex items-center justify-center h-full bg-blue-600 text-white">
                                    <i class="fas fa-newspaper text-5xl"></i>
                                </div>
                            @endif
                        </div>
                    </a>
                    
                    <div class="p-6">
                        <div class="flex items-center text-gray-500 text-sm mb-2">
                            <span>
                                <i class="far fa-calendar mr-1"></i>
                                {{ $relatedPost->published_at->format('M d, Y') }}
                            </span>
                        </div>
                        
                        <a href="{{ route('blog.show', $relatedPost->slug) }}" class="block group">
                            <h3 class="text-xl font-bold mb-3 group-hover:text-blue-600 transition-colors">{{ $relatedPost->title }}</h3>
                        </a>
                        
                        <p class="text-gray-600 mb-4 line-clamp-2">{{ $relatedPost->excerpt }}</p>
                        
                        <a href="{{ route('blog.show', $relatedPost->slug) }}" class="text-blue-600 hover:text-blue-800 font-medium inline-flex items-center">
                            Read More
                            <i class="fas fa-arrow-right ml-2 text-sm"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection