<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the posts.
     */
    public function index()
    {
        $posts = Post::with('user')
            ->latest()
            ->paginate(10);
            
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new post.
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created post in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
            'is_featured' => 'boolean',
        ]);

        // Handle slug
        $validated['slug'] = Str::slug($request->title);
        
        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('posts', 'public');
            $validated['featured_image'] = $path;
        }
        
        // Set user ID
        $validated['user_id'] = auth()->id();
        
        // Set published_at if status is published
        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }
        
        // Set is_featured default value
        $validated['is_featured'] = $request->has('is_featured');
        
        $post = Post::create($validated);
        
        return redirect()->route('admin.posts.index')
            ->with('success', 'Bài viết đã được tạo thành công.');
    }

    /**
     * Show the post details.
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the post.
     */
    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the post in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
            'is_featured' => 'boolean',
        ]);

        // Handle slug
        if ($request->title !== $post->title) {
            $validated['slug'] = Str::slug($request->title);
        }
        
        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            
            $path = $request->file('featured_image')->store('posts', 'public');
            $validated['featured_image'] = $path;
        }
        
        // Set published_at if status changes to published
        if ($validated['status'] === 'published' && ($post->status !== 'published' || empty($post->published_at))) {
            $validated['published_at'] = now();
        }
        
        // Set is_featured default value
        $validated['is_featured'] = $request->has('is_featured');
        
        $post->update($validated);
        
        return redirect()->route('admin.posts.index')
            ->with('success', 'Bài viết đã được cập nhật thành công.');
    }

    /**
     * Remove the post from storage.
     */
    public function destroy(Post $post)
    {
        // Delete featured image if exists
        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }
        
        $post->delete();
        
        return redirect()->route('admin.posts.index')
            ->with('success', 'Bài viết đã được xóa thành công.');
    }
    
    /**
     * Publish the post.
     */
    public function publish(Post $post)
    {
        $post->update([
            'status' => 'published',
            'published_at' => now(),
        ]);
        
        return redirect()->back()->with('success', 'Bài viết đã được xuất bản.');
    }
    
    /**
     * Unpublish the post.
     */
    public function unpublish(Post $post)
    {
        $post->update([
            'status' => 'draft',
        ]);
        
        return redirect()->back()->with('success', 'Bài viết đã được hủy xuất bản.');
    }
    
    /**
     * Mark the post as featured.
     */
    public function feature(Post $post)
    {
        $post->update([
            'is_featured' => true,
        ]);
        
        return redirect()->back()->with('success', 'Bài viết đã được đánh dấu là nổi bật.');
    }
    
    /**
     * Remove the featured mark from the post.
     */
    public function unfeature(Post $post)
    {
        $post->update([
            'is_featured' => false,
        ]);
        
        return redirect()->back()->with('success', 'Bài viết đã được hủy đánh dấu nổi bật.');
    }
}
