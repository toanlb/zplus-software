<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share product categories with all views
        View::composer('layouts.app', function ($view) {
            $featuredCategories = Category::where('is_active', true)
                ->withCount('products')
                ->orderByDesc('products_count')
                ->take(5)
                ->get();
                
            $view->with('featuredCategories', $featuredCategories);
        });
    }
}
