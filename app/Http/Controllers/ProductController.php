<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'newest');
        
        // Base query
        $query = Product::where('is_active', true);
        
        // Apply sorting
        switch ($sort) {
            case 'price-low':
                $query->orderBy('price', 'asc');
                break;
            case 'price-high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
        }
        
        // Get products with pagination
        $products = $query->with('category')->paginate(9);
        
        // Get all categories for filter
        $categories = Category::where('is_active', true)->get();
        
        // Get featured categories (with product count)
        $featuredCategories = Category::where('is_active', true)
            ->withCount('products')
            ->orderByDesc('products_count')
            ->take(6)
            ->get();
        
        return view('pages.products.index', compact('products', 'categories', 'featuredCategories'));
    }
    
    /**
     * Display products by category.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $slug  Category slug
     * @return \Illuminate\View\View
     */
    public function category(Request $request, $slug)
    {
        $category = Category::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
            
        $sort = $request->get('sort', 'newest');
        
        // Base query
        $query = Product::where('is_active', true)
            ->where('category_id', $category->id);
        
        // Apply sorting
        switch ($sort) {
            case 'price-low':
                $query->orderBy('price', 'asc');
                break;
            case 'price-high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
        }
        
        // Get products with pagination
        $products = $query->with('category')->paginate(9);
        
        // Get all categories for filter
        $categories = Category::where('is_active', true)->get();
        
        // Get featured categories (with product count)
        $featuredCategories = Category::where('is_active', true)
            ->withCount('products')
            ->orderByDesc('products_count')
            ->take(6)
            ->get();
        
        // Add category name for display
        $categoryName = $category->name;
        
        return view('pages.products.index', compact('products', 'categories', 'featuredCategories', 'categoryName'));
    }
    
    /**
     * Display the specified product.
     *
     * @param  string  $slug  Product slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        // Find the product by slug
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->with('category')
            ->firstOrFail();
        
        // Get related products (same category, excluding current product)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();
            
        return view('pages.products.show', compact('product', 'relatedProducts'));
    }
}