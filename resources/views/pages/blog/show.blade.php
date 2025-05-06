@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <!-- Blog Post Header -->
    <section class="bg-blue-600 py-16 text-white">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <div class="mb-4">
                    @if($post->category)
                        <a href="{{ route('blog.category', $post->category->slug) }}" class="inline-block bg-blue-800 text-white text-sm px-3 py-1 rounded-full mb-4">
                            {{ $post->category->name }}
                        </a>
                    @endif
                    <h1 class="text-4xl font-bold mb-4 leading-tight">{{ $post->title }}</h1>
                    <div class="flex items-center text-blue-100">
                        <div class="flex items-center mr-6">
                            <i class="fas fa-user-circle mr-2"></i>
                            <span>{{ __('blog.author') }}: {{ $post->user->name }}</span>
                        </div>
                        <div class="flex items-center mr-6">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            <span>{{ __('blog.published_on') }}: {{ \Carbon\Carbon::parse($post->published_at)->format('M d, Y') }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-clock mr-2"></i>
                            <span>{{ $post->read_time ?? 5 }} {{ __('blog.minutes') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Main Blog Content -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap -mx-4">
                <!-- Main Content Column -->
                <div class="w-full lg:w-2/3 px-4">
                    <article class="bg-white rounded-lg shadow-md overflow-hidden">
                        @if($post->featured_image)
                            <div class="h-96 bg-gray-200">
                                <img src="{{ asset($post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                            </div>
                        @endif
                        
                        <div class="p-6 lg:p-8">
                            <div class="prose prose-lg max-w-none">
                                {!! $post->content !!}
                            </div>
                            
                            <!-- Tags -->
                            @if(isset($post->tags) && !empty($post->tags))
                                <div class="mt-8 pt-6 border-t border-gray-200">
                                    <h3 class="text-lg font-semibold mb-3">{{ __('blog.tags') }}:</h3>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach(explode(',', $post->tags) as $tag)
                                            <a href="#" class="bg-gray-100 text-gray-700 hover:bg-gray-200 px-3 py-1 rounded-md text-sm">
                                                {{ trim($tag) }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Share Buttons -->
                            <div class="mt-8 pt-6 border-t border-gray-200">
                                <h3 class="text-lg font-semibold mb-3">{{ __('blog.share_post') }}:</h3>
                                <div class="flex space-x-4">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="bg-blue-600 text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-blue-700">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->title) }}" target="_blank" class="bg-blue-400 text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-blue-500">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" target="_blank" class="bg-blue-800 text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-blue-900">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                    <a href="mailto:?subject={{ urlencode($post->title) }}&body={{ urlencode(url()->current()) }}" class="bg-red-500 text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-red-600">
                                        <i class="fas fa-envelope"></i>
                                    </a>
                                </div>
                            </div>
                            
                            <!-- Author Bio -->
                            @if(isset($post->user) && !empty($post->user->bio))
                                <div class="mt-8 pt-6 border-t border-gray-200">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 mr-4">
                                            <div class="w-16 h-16 bg-gray-200 rounded-full overflow-hidden">
                                                @if($post->user->avatar)
                                                    <img src="{{ asset($post->user->avatar) }}" alt="{{ $post->user->name }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-gray-500 bg-gray-300">
                                                        <i class="fas fa-user text-2xl"></i>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-semibold mb-2">{{ __('blog.author') }}: {{ $post->user->name }}</h3>
                                            <p class="text-gray-600">{{ $post->user->bio }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Post Navigation -->
                            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-between">
                                <div>
                                    @if(isset($previousPost))
                                        <a href="{{ route('blog.show', $previousPost->slug) }}" class="flex items-center text-gray-700 hover:text-blue-600">
                                            <i class="fas fa-chevron-left mr-2"></i>
                                            <span>{{ __('blog.previous_post') }}</span>
                                        </a>
                                    @endif
                                </div>
                                <div>
                                    @if(isset($nextPost))
                                        <a href="{{ route('blog.show', $nextPost->slug) }}" class="flex items-center text-gray-700 hover:text-blue-600">
                                            <span>{{ __('blog.next_post') }}</span>
                                            <i class="fas fa-chevron-right ml-2"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </article>
                    
                    <!-- Related Posts -->
                    @if(isset($relatedPosts) && $relatedPosts->count() > 0)
                        <div class="mt-12">
                            <h2 class="text-2xl font-bold mb-6">{{ __('blog.related_posts') }}</h2>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                @foreach($relatedPosts as $relatedPost)
                                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                                        <div class="h-48 bg-gray-200 relative">
                                            @if($relatedPost->featured_image)
                                                <img src="{{ asset($relatedPost->featured_image) }}" alt="{{ $relatedPost->title }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-gray-500">
                                                    <i class="fas fa-image text-4xl"></i>
                                                </div>
                                            @endif
                                            @if($relatedPost->category)
                                                <span class="absolute top-2 right-2 bg-blue-600 text-white text-xs uppercase py-1 px-2 rounded">
                                                    {{ $relatedPost->category->name }}
                                                </span>
                                            @endif
                                        </div>
                                        <div class="p-4">
                                            <h3 class="text-lg font-semibold mb-2">
                                                <a href="{{ route('blog.show', $relatedPost->slug) }}" class="text-gray-800 hover:text-blue-600">
                                                    {{ $relatedPost->title }}
                                                </a>
                                            </h3>
                                            <div class="flex items-center text-sm text-gray-500 mb-3">
                                                <span class="mr-4">{{ \Carbon\Carbon::parse($relatedPost->published_at)->format('M d, Y') }}</span>
                                                <span>{{ $relatedPost->read_time ?? 5 }} {{ __('blog.minutes') }}</span>
                                            </div>
                                            <p class="text-gray-600 mb-4 line-clamp-3">{{ $relatedPost->excerpt }}</p>
                                            <a href="{{ route('blog.show', $relatedPost->slug) }}" class="text-blue-600 font-medium hover:text-blue-800">
                                                {{ __('general.read_more') }} →
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    
                    <!-- Comments Section -->
                    <div class="mt-12">
                        <h2 class="text-2xl font-bold mb-6">{{ __('blog.comments') }}</h2>
                        
                        <!-- Comment Form -->
                        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                            <h3 class="text-xl font-semibold mb-4">{{ __('blog.leave_comment') }}</h3>
                            <form action="#" method="post">
                                @csrf
                                <div class="mb-4">
                                    <label for="comment" class="block text-gray-700 font-medium mb-2">{{ __('blog.comment_text') }}</label>
                                    <textarea id="comment" name="comment" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
                                </div>
                                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition-all duration-200">
                                    {{ __('blog.submit_comment') }}
                                </button>
                            </form>
                        </div>
                        
                        <!-- Comment List -->
                        <div>
                            @if(isset($comments) && $comments->count() > 0)
                                @foreach($comments as $comment)
                                    <div class="bg-white rounded-lg shadow-md p-6 mb-4">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0 mr-4">
                                                <div class="w-12 h-12 bg-gray-200 rounded-full overflow-hidden">
                                                    @if($comment->user && $comment->user->avatar)
                                                        <img src="{{ asset($comment->user->avatar) }}" alt="{{ $comment->user->name }}" class="w-full h-full object-cover">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center text-gray-500 bg-gray-300">
                                                            <i class="fas fa-user"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="flex-grow">
                                                <div class="flex justify-between items-start mb-2">
                                                    <h4 class="font-semibold">
                                                        {{ $comment->user ? $comment->user->name : 'Anonymous' }}
                                                    </h4>
                                                    <span class="text-sm text-gray-500">
                                                        {{ $comment->created_at->diffForHumans() }}
                                                    </span>
                                                </div>
                                                <p class="text-gray-700">{{ $comment->content }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="bg-white rounded-lg shadow-md p-6 text-center">
                                    <p class="text-gray-600">{{ __('blog.no_comments') ?? 'No comments yet. Be the first to comment!' }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Sidebar Column -->
                <div class="w-full lg:w-1/3 px-4 mt-12 lg:mt-0">
                    <!-- Categories Widget -->
                    @if(isset($categories) && $categories->count() > 0)
                        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                            <h3 class="text-xl font-bold mb-4">{{ __('blog.categories') }}</h3>
                            <ul class="space-y-2">
                                @foreach($categories as $cat)
                                    <li>
                                        <a href="{{ route('blog.category', $cat->slug) }}" 
                                           class="flex items-center justify-between py-2 px-3 rounded-md hover:bg-gray-100 {{ isset($post->category) && $post->category->id === $cat->id ? 'bg-blue-100 text-blue-600 font-medium' : 'text-gray-700' }}">
                                            <span>{{ $cat->name }}</span>
                                            <span class="bg-gray-200 text-gray-700 text-xs rounded-full px-2 py-1">{{ $cat->posts_count ?? 0 }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <!-- Recent Posts Widget -->
                    @if(isset($recentPosts) && $recentPosts->count() > 0)
                        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                            <h3 class="text-xl font-bold mb-4">{{ __('blog.recent_posts') }}</h3>
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
                        </div>
                    @endif
                    
                    <!-- Tags Cloud Widget -->
                    @if(isset($tags) && !empty($tags))
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h3 class="text-xl font-bold mb-4">{{ __('blog.tags') }}</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($tags as $tag => $count)
                                    <a href="#" class="bg-gray-100 text-gray-700 hover:bg-gray-200 px-3 py-1 rounded-md text-sm">
                                        {{ $tag }} <span class="text-gray-500">({{ $count }})</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection