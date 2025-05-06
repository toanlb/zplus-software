<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the blog posts.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get featured posts
        $featuredPosts = Post::where('is_featured', true)
            ->where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();
        
        // Get regular posts with pagination
        $posts = Post::where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->paginate(9);
        
        // Get post categories
        $categories = Category::withCount(['posts' => function ($query) {
                $query->where('status', 'published');
            }])
            ->having('posts_count', '>', 0)
            ->orderBy('name')
            ->get();
        
        // Get recent posts for sidebar
        $recentPosts = Post::where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->take(5)
            ->get();
        
        return view('pages.blog.index', compact('posts', 'featuredPosts', 'categories', 'recentPosts'));
    }
    
    /**
     * Display posts by category.
     *
     * @param  string  $slug  Category slug
     * @return \Illuminate\View\View
     */
    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        
        // Get posts in this category
        $posts = Post::where('status', 'published')
            ->where('category_id', $category->id)
            ->orderBy('published_at', 'desc')
            ->paginate(9);
        
        // Get featured posts in this category
        $featuredPosts = Post::where('is_featured', true)
            ->where('status', 'published')
            ->where('category_id', $category->id)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();
        
        // If we don't have enough featured posts in this category, get general featured posts
        if ($featuredPosts->count() < 3) {
            $additionalFeaturedPosts = Post::where('is_featured', true)
                ->where('status', 'published')
                ->whereNotIn('id', $featuredPosts->pluck('id')->toArray())
                ->orderBy('published_at', 'desc')
                ->take(3 - $featuredPosts->count())
                ->get();
            
            $featuredPosts = $featuredPosts->concat($additionalFeaturedPosts);
        }
        
        // Get all categories
        $categories = Category::withCount(['posts' => function ($query) {
                $query->where('status', 'published');
            }])
            ->having('posts_count', '>', 0)
            ->orderBy('name')
            ->get();
        
        // Get recent posts for sidebar
        $recentPosts = Post::where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->take(5)
            ->get();
        
        return view('pages.blog.index', compact('posts', 'featuredPosts', 'categories', 'category', 'recentPosts'));
    }
    
    /**
     * Display the specified blog post.
     *
     * @param  string  $slug  Post slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        // Find the post by slug
        $post = Post::where('slug', $slug)
            ->where('status', 'published')
            ->with(['user', 'category'])
            ->firstOrFail();
        
        // Increment view count
        $post->increment('views');
        
        // Get related posts (same category, excluding current post)
        $relatedPosts = Post::where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();
        
        // If we don't have enough related posts, get recent posts
        if ($relatedPosts->count() < 3) {
            $additionalPosts = Post::where('id', '!=', $post->id)
                ->whereNotIn('id', $relatedPosts->pluck('id')->toArray())
                ->where('status', 'published')
                ->orderBy('published_at', 'desc')
                ->take(3 - $relatedPosts->count())
                ->get();
            
            $relatedPosts = $relatedPosts->concat($additionalPosts);
        }
        
        // Get categories for sidebar
        $categories = Category::withCount(['posts' => function ($query) {
                $query->where('status', 'published');
            }])
            ->having('posts_count', '>', 0)
            ->orderBy('name')
            ->get();
        
        // Get recent posts for sidebar
        $recentPosts = Post::where('id', '!=', $post->id)
            ->where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->take(5)
            ->get();
        
        // Get previous and next posts for navigation
        $previousPost = Post::where('status', 'published')
            ->where('published_at', '<', $post->published_at)
            ->orderBy('published_at', 'desc')
            ->first();
        
        $nextPost = Post::where('status', 'published')
            ->where('published_at', '>', $post->published_at)
            ->orderBy('published_at', 'asc')
            ->first();
        
        // Get all tags from posts
        $allTags = Post::where('status', 'published')
            ->whereNotNull('tags')
            ->pluck('tags')
            ->filter()
            ->map(function ($tagString) {
                return array_map('trim', explode(',', $tagString));
            })
            ->flatten()
            ->countBy();
        
        // Sort tags by count (most used first)
        $tags = $allTags->sortDesc()->take(15);
        
        return view('pages.blog.show', compact(
            'post', 
            'relatedPosts', 
            'categories', 
            'recentPosts', 
            'previousPost',
            'nextPost',
            'tags'
        ));
    }
}