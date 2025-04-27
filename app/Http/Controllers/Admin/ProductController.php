<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'short_description' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'version' => 'required|string|max:50',
            'license_required' => 'boolean',
            'is_active' => 'boolean',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'download_file' => 'nullable|file|max:102400', // 100MB max
        ]);

        // Generate slug
        $validated['slug'] = Str::slug($validated['name']);
        
        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('products/thumbnails', 'public');
            $validated['thumbnail'] = $path;
        }
        
        // Handle download file upload
        if ($request->hasFile('download_file')) {
            $path = $request->file('download_file')->store('products/downloads', 'private');
            $validated['download_link'] = $path;
        }
        
        // Set default values
        $validated['downloads_count'] = 0;
        
        Product::create($validated);
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Sản phẩm đã được tạo thành công.');
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'short_description' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'version' => 'required|string|max:50',
            'license_required' => 'boolean',
            'is_active' => 'boolean',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'download_file' => 'nullable|file|max:102400', // 100MB max
        ]);

        // Update slug
        $validated['slug'] = Str::slug($validated['name']);
        
        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($product->thumbnail) {
                Storage::disk('public')->delete($product->thumbnail);
            }
            
            $path = $request->file('thumbnail')->store('products/thumbnails', 'public');
            $validated['thumbnail'] = $path;
        }
        
        // Handle download file upload
        if ($request->hasFile('download_file')) {
            // Delete old file if exists
            if ($product->download_link) {
                Storage::disk('private')->delete($product->download_link);
            }
            
            $path = $request->file('download_file')->store('products/downloads', 'private');
            $validated['download_link'] = $path;
        }
        
        $product->update($validated);
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Sản phẩm đã được cập nhật thành công.');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        // Check if product has any related order items
        if ($product->orderItems()->exists()) {
            return redirect()->route('admin.products.index')
                ->with('error', 'Không thể xóa sản phẩm này vì có đơn hàng liên quan.');
        }
        
        // Delete thumbnail if exists
        if ($product->thumbnail) {
            Storage::disk('public')->delete($product->thumbnail);
        }
        
        // Delete download file if exists
        if ($product->download_link) {
            Storage::disk('private')->delete($product->download_link);
        }
        
        // Delete licenses associated with this product
        $product->licenses()->delete();
        
        // Delete the product
        $product->delete();
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Sản phẩm đã được xóa thành công.');
    }
    
    /**
     * Download the product file.
     */
    public function downloadFile(Product $product)
    {
        if (!$product->download_link) {
            return back()->with('error', 'Không có file để tải xuống.');
        }
        
        return Storage::disk('private')->download($product->download_link);
    }
}