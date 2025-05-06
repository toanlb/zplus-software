@extends('layouts.app')

@section('title', __('products.products_title'))

@section('content')
    <!-- Products Header Section -->
    <section class="bg-blue-600 py-16 text-white">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-4xl font-bold mb-4">{{ __('products.products_title') }}</h1>
                <p class="text-xl text-blue-100">{{ __('products.products_subtitle') }}</p>
            </div>
        </div>
    </section>
    
    <!-- Products Listing Section -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap -mx-4">
                <!-- Sidebar Filters -->
                <aside class="w-full lg:w-1/4 px-4 mb-8 lg:mb-0">
                    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                        <h3 class="text-lg font-semibold mb-4">{{ __('products.categories') }}</h3>
                        <ul class="space-y-2">
                            <li>
                                <a href="{{ route('products.index') }}" class="flex items-center justify-between py-2 px-3 rounded-md hover:bg-gray-100 {{ !isset($categoryName) ? 'bg-blue-100 text-blue-600 font-medium' : 'text-gray-700' }}">
                                    <span>{{ __('products.all_categories') }}</span>
                                </a>
                            </li>
                            @foreach($categories as $category)
                                <li>
                                    <a href="{{ route('products.category', $category->slug) }}" 
                                    class="flex items-center justify-between py-2 px-3 rounded-md hover:bg-gray-100 {{ isset($categoryName) && $category->name === $categoryName ? 'bg-blue-100 text-blue-600 font-medium' : 'text-gray-700' }}">
                                        <span>{{ $category->name }}</span>
                                        <span class="bg-gray-200 text-gray-700 text-xs rounded-full px-2 py-1">{{ $category->products_count ?? $category->products->count() }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold mb-4">{{ __('products.filter_by') }}</h3>
                        
                        <div class="mb-4">
                            <h4 class="font-medium mb-2">{{ __('products.sort_by') }}:</h4>
                            <form action="{{ request()->url() }}" method="get" id="sort-form">
                                <select name="sort" id="sort" class="w-full border border-gray-300 rounded p-2" onchange="document.getElementById('sort-form').submit()">
                                    <option value="newest" {{ request('sort') == 'newest' || !request('sort') ? 'selected' : '' }}>{{ __('general.newest') }}</option>
                                    <option value="price-low" {{ request('sort') == 'price-low' ? 'selected' : '' }}>{{ __('products.price') }}: {{ __('general.low_to_high') }}</option>
                                    <option value="price-high" {{ request('sort') == 'price-high' ? 'selected' : '' }}>{{ __('products.price') }}: {{ __('general.high_to_low') }}</option>
                                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>{{ __('general.name') }} (A-Z)</option>
                                </select>
                            </form>
                        </div>
                        
                        <div>
                            <h4 class="font-medium mb-2">{{ __('products.price_range') }}:</h4>
                            <form action="{{ request()->url() }}" method="get">
                                @if(request('sort'))
                                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                                @endif
                                <div class="grid grid-cols-2 gap-2 mb-3">
                                    <div>
                                        <label for="min_price" class="text-xs text-gray-500">{{ __('general.min') }}</label>
                                        <input type="number" id="min_price" name="min_price" value="{{ request('min_price') }}" class="w-full border border-gray-300 rounded p-2" min="0">
                                    </div>
                                    <div>
                                        <label for="max_price" class="text-xs text-gray-500">{{ __('general.max') }}</label>
                                        <input type="number" id="max_price" name="max_price" value="{{ request('max_price') }}" class="w-full border border-gray-300 rounded p-2" min="0">
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <button type="submit" class="bg-blue-600 text-white rounded px-4 py-2 text-sm hover:bg-blue-700">
                                        {{ __('products.apply_filters') }}
                                    </button>
                                    <a href="{{ request()->url() }}" class="bg-gray-200 text-gray-800 rounded px-4 py-2 text-sm hover:bg-gray-300">
                                        {{ __('products.clear_filters') }}
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </aside>
                
                <!-- Products Grid -->
                <div class="w-full lg:w-3/4 px-4">
                    <!-- Category Title (if applicable) -->
                    @if(isset($categoryName))
                        <div class="mb-6">
                            <h2 class="text-2xl font-bold mb-1">{{ $categoryName }}</h2>
                            <p class="text-gray-600">{{ __('products.showing') }} {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} {{ __('products.of') }} {{ $products->total() }} {{ __('products.results') }}</p>
                        </div>
                    @endif
                    
                    <!-- Products Grid -->
                    @if($products->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                            @foreach($products as $product)
                                <div class="bg-white rounded-lg shadow-md overflow-hidden transition duration-300 hover:shadow-lg">
                                    <a href="{{ route('products.show', $product->slug) }}" class="block">
                                        <div class="h-48 bg-gray-200 relative">
                                            @if($product->featured_image)
                                                <img src="{{ asset($product->featured_image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-gray-500">
                                                    <i class="fas fa-box fa-2x"></i>
                                                </div>
                                            @endif
                                            
                                            @if($product->is_featured)
                                                <span class="absolute top-2 left-2 bg-yellow-500 text-white text-xs uppercase py-1 px-2 rounded">
                                                    {{ __('products.featured') }}
                                                </span>
                                            @endif
                                            
                                            @if($product->sale_price && $product->sale_price < $product->regular_price)
                                                <span class="absolute top-2 right-2 bg-red-500 text-white text-xs uppercase py-1 px-2 rounded">
                                                    {{ __('products.sale') }}
                                                </span>
                                            @endif
                                        </div>
                                    </a>
                                    
                                    <div class="p-4">
                                        @if($product->category)
                                            <div class="text-xs text-gray-500 mb-1">{{ $product->category->name }}</div>
                                        @endif
                                        
                                        <h3 class="font-semibold text-lg mb-2">
                                            <a href="{{ route('products.show', $product->slug) }}" class="text-gray-800 hover:text-blue-600">
                                                {{ $product->name }}
                                            </a>
                                        </h3>
                                        
                                        <div class="flex items-end justify-between mt-3">
                                            <div>
                                                @if($product->sale_price && $product->sale_price < $product->regular_price)
                                                    <span class="text-gray-400 line-through text-sm">{{ __('products.currency_symbol') }}{{ number_format($product->regular_price, 2) }}</span>
                                                    <span class="text-red-600 font-bold ml-1">{{ __('products.currency_symbol') }}{{ number_format($product->sale_price, 2) }}</span>
                                                @else
                                                    <span class="text-gray-800 font-bold">{{ __('products.currency_symbol') }}{{ number_format($product->price, 2) }}</span>
                                                @endif
                                            </div>
                                            
                                            <div class="text-sm">
                                                @if($product->stock_status === 'instock')
                                                    <span class="text-green-600">{{ __('products.in_stock') }}</span>
                                                @else
                                                    <span class="text-red-600">{{ __('products.out_of_stock') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="mt-4 flex space-x-2">
                                            <a href="{{ route('products.show', $product->slug) }}" class="bg-blue-600 text-white text-sm px-4 py-2 rounded flex-1 text-center hover:bg-blue-700 transition">
                                                {{ __('general.view_details') }}
                                            </a>
                                            
                                            @if($product->stock_status === 'instock')
                                                <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    <input type="hidden" name="quantity" value="1">
                                                    <button type="submit" class="w-full bg-gray-800 text-white text-sm px-3 py-2 rounded hover:bg-gray-700 transition">
                                                        <i class="fas fa-shopping-cart mr-1"></i>
                                                        {{ __('products.add_to_cart') }}
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Pagination -->
                        <div class="mt-8">
                            {{ $products->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="bg-white rounded-lg shadow p-8 text-center">
                            <div class="text-gray-500 text-lg mb-4">{{ __('products.no_products_found') }}</div>
                            <a href="{{ route('products.index') }}" class="inline-block bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                                {{ __('products.view_all_products') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection