@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <!-- Product Detail -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <!-- Breadcrumb -->
            <div class="mb-8">
                <div class="flex items-center text-sm">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-blue-600">{{ __('general.home') }}</a>
                    <span class="mx-2 text-gray-400">/</span>
                    <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-blue-600">{{ __('products.products_title') }}</a>
                    @if($product->category)
                        <span class="mx-2 text-gray-400">/</span>
                        <a href="{{ route('products.category', $product->category->slug) }}" class="text-gray-600 hover:text-blue-600">{{ $product->category->name }}</a>
                    @endif
                    <span class="mx-2 text-gray-400">/</span>
                    <span class="text-gray-800 font-medium">{{ $product->name }}</span>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="flex flex-wrap">
                    <!-- Product Image -->
                    <div class="w-full lg:w-1/2 p-6">
                        <div class="bg-gray-100 rounded-lg overflow-hidden">
                            @if($product->featured_image)
                                <img src="{{ asset($product->featured_image) }}" alt="{{ $product->name }}" class="w-full h-auto object-cover">
                            @else
                                <div class="w-full h-96 flex items-center justify-center text-gray-500 bg-gray-200">
                                    <i class="fas fa-box fa-3x"></i>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Product Image Gallery -->
                        @if(isset($product->gallery) && !empty($product->gallery))
                            <div class="grid grid-cols-4 gap-4 mt-4">
                                @foreach(json_decode($product->gallery) as $image)
                                    <div class="bg-gray-100 rounded-lg overflow-hidden">
                                        <img src="{{ asset($image) }}" alt="{{ $product->name }}" class="w-full h-24 object-cover cursor-pointer hover:opacity-80 transition">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    
                    <!-- Product Details -->
                    <div class="w-full lg:w-1/2 p-6 lg:border-l border-gray-200">
                        <div class="mb-6">
                            @if($product->category)
                                <div class="text-sm text-gray-500 mb-2">{{ $product->category->name }}</div>
                            @endif
                            <h1 class="text-3xl font-bold mb-2">{{ $product->name }}</h1>
                            
                            <!-- Product pricing -->
                            <div class="flex items-center mt-4">
                                @if($product->sale_price && $product->sale_price < $product->regular_price)
                                    <span class="text-gray-400 line-through text-xl mr-2">{{ __('products.currency_symbol') }}{{ number_format($product->regular_price, 2) }}</span>
                                    <span class="text-red-600 font-bold text-2xl">{{ __('products.currency_symbol') }}{{ number_format($product->sale_price, 2) }}</span>
                                    <span class="ml-2 bg-red-100 text-red-800 text-xs px-2 py-1 rounded-md uppercase font-semibold">{{ __('products.sale') }}</span>
                                @else
                                    <span class="text-gray-800 font-bold text-2xl">{{ __('products.currency_symbol') }}{{ number_format($product->price, 2) }}</span>
                                @endif
                            </div>
                            
                            <!-- Product availability -->
                            <div class="mt-3">
                                @if($product->stock_status === 'instock')
                                    <span class="text-green-600 flex items-center">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        {{ __('products.in_stock') }}
                                    </span>
                                @else
                                    <span class="text-red-600 flex items-center">
                                        <i class="fas fa-times-circle mr-1"></i>
                                        {{ __('products.out_of_stock') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Short description -->
                        @if($product->short_description)
                            <div class="mb-6">
                                <div class="prose prose-sm max-w-none">
                                    {!! $product->short_description !!}
                                </div>
                            </div>
                        @endif
                        
                        <!-- Product features/highlights -->
                        @if(isset($product->features) && !empty($product->features))
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold mb-3">{{ __('products.features') }}:</h3>
                                <ul class="space-y-2">
                                    @foreach(explode("\n", $product->features) as $feature)
                                        @if(!empty(trim($feature)))
                                            <li class="flex items-start">
                                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                                <span>{{ trim($feature) }}</span>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <!-- Add to cart form -->
                        @if($product->stock_status === 'instock')
                            <div class="mt-8">
                                <form action="{{ route('cart.add') }}" method="POST" class="flex flex-wrap items-end">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    
                                    <div class="w-24 mr-4">
                                        <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">{{ __('products.quantity') }}</label>
                                        <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock_quantity ?? 99 }}" class="w-full border border-gray-300 rounded p-2">
                                    </div>
                                    
                                    <div class="flex-1 flex space-x-3">
                                        <button type="submit" class="flex-1 bg-blue-600 text-white px-6 py-3 rounded-md font-medium hover:bg-blue-700 transition">
                                            <i class="fas fa-shopping-cart mr-2"></i>
                                            {{ __('products.add_to_cart') }}
                                        </button>
                                        
                                        <button type="submit" name="buy_now" value="1" class="flex-1 bg-gray-800 text-white px-6 py-3 rounded-md font-medium hover:bg-gray-900 transition">
                                            {{ __('products.buy_now') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif
                        
                        <!-- Product meta -->
                        <div class="mt-8 border-t border-gray-200 pt-6">
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                @if($product->sku)
                                    <div>
                                        <span class="text-gray-500">{{ __('products.sku') }}:</span>
                                        <span class="font-medium ml-1">{{ $product->sku }}</span>
                                    </div>
                                @endif
                                
                                @if($product->category)
                                    <div>
                                        <span class="text-gray-500">{{ __('products.category') }}:</span>
                                        <a href="{{ route('products.category', $product->category->slug) }}" class="font-medium ml-1 text-blue-600 hover:text-blue-800">
                                            {{ $product->category->name }}
                                        </a>
                                    </div>
                                @endif
                                
                                @if(isset($product->tags) && !empty($product->tags))
                                    <div class="col-span-2">
                                        <span class="text-gray-500">{{ __('products.tags') }}:</span>
                                        <div class="inline-flex flex-wrap gap-2 ml-1">
                                            @foreach(explode(',', $product->tags) as $tag)
                                                <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs">{{ trim($tag) }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Share product -->
                        <div class="mt-6">
                            <div class="text-sm font-medium mb-2">{{ __('products.share_product') }}:</div>
                            <div class="flex space-x-3">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="bg-blue-600 text-white w-8 h-8 rounded-full flex items-center justify-center hover:bg-blue-700">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($product->name) }}" target="_blank" class="bg-blue-400 text-white w-8 h-8 rounded-full flex items-center justify-center hover:bg-blue-500">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" target="_blank" class="bg-blue-800 text-white w-8 h-8 rounded-full flex items-center justify-center hover:bg-blue-900">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                                <a href="mailto:?subject={{ urlencode($product->name) }}&body={{ urlencode(url()->current()) }}" class="bg-red-500 text-white w-8 h-8 rounded-full flex items-center justify-center hover:bg-red-600">
                                    <i class="fas fa-envelope"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Product Tabs -->
                <div class="border-t border-gray-200 p-6" x-data="{ activeTab: 'description' }">
                    <!-- Tabs Navigation -->
                    <div class="flex border-b border-gray-200 mb-6">
                        <button @click="activeTab = 'description'" :class="{ 'border-blue-600 text-blue-600': activeTab === 'description', 'border-transparent text-gray-500 hover:text-gray-700': activeTab !== 'description' }" class="py-3 px-6 border-b-2 font-medium text-lg">
                            {{ __('products.description') }}
                        </button>
                        
                        <button @click="activeTab = 'specifications'" :class="{ 'border-blue-600 text-blue-600': activeTab === 'specifications', 'border-transparent text-gray-500 hover:text-gray-700': activeTab !== 'specifications' }" class="py-3 px-6 border-b-2 font-medium text-lg">
                            {{ __('products.specifications') }}
                        </button>
                        
                        <button @click="activeTab = 'reviews'" :class="{ 'border-blue-600 text-blue-600': activeTab === 'reviews', 'border-transparent text-gray-500 hover:text-gray-700': activeTab !== 'reviews' }" class="py-3 px-6 border-b-2 font-medium text-lg">
                            {{ __('products.reviews') }}
                        </button>
                    </div>
                    
                    <!-- Tab Content -->
                    <div>
                        <!-- Description Tab -->
                        <div x-show="activeTab === 'description'" class="prose prose-lg max-w-none">
                            @if($product->description)
                                {!! $product->description !!}
                            @else
                                <p class="text-gray-500">{{ __('products.no_description') }}</p>
                            @endif
                        </div>
                        
                        <!-- Specifications Tab -->
                        <div x-show="activeTab === 'specifications'" class="prose prose-lg max-w-none" style="display: none;">
                            @if($product->specifications)
                                {!! $product->specifications !!}
                            @else
                                <table class="min-w-full border border-gray-200">
                                    <tbody>
                                        @if($product->sku)
                                            <tr class="border-b border-gray-200">
                                                <td class="px-4 py-3 bg-gray-50 font-medium">{{ __('products.sku') }}</td>
                                                <td class="px-4 py-3">{{ $product->sku }}</td>
                                            </tr>
                                        @endif
                                        @if($product->weight)
                                            <tr class="border-b border-gray-200">
                                                <td class="px-4 py-3 bg-gray-50 font-medium">{{ __('products.weight') }}</td>
                                                <td class="px-4 py-3">{{ $product->weight }} {{ $product->weight_unit ?? 'kg' }}</td>
                                            </tr>
                                        @endif
                                        @if($product->dimensions)
                                            <tr class="border-b border-gray-200">
                                                <td class="px-4 py-3 bg-gray-50 font-medium">{{ __('products.dimensions') }}</td>
                                                <td class="px-4 py-3">{{ $product->dimensions }}</td>
                                            </tr>
                                        @endif
                                        @if($product->material)
                                            <tr class="border-b border-gray-200">
                                                <td class="px-4 py-3 bg-gray-50 font-medium">{{ __('products.material') }}</td>
                                                <td class="px-4 py-3">{{ $product->material }}</td>
                                            </tr>
                                        @endif
                                        <!-- Additional specifications as needed -->
                                    </tbody>
                                </table>
                            @endif
                        </div>
                        
                        <!-- Reviews Tab -->
                        <div x-show="activeTab === 'reviews'" style="display: none;">
                            <!-- Reviews will be implemented here -->
                            <div class="text-center py-8">
                                <p class="text-gray-500 mb-4">{{ __('products.no_reviews_yet') }}</p>
                                <button type="button" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">
                                    {{ __('products.write_review') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Related Products -->
            @if($relatedProducts->count() > 0)
                <div class="mt-12">
                    <h2 class="text-2xl font-bold mb-6">{{ __('products.related_products') }}</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($relatedProducts as $relatedProduct)
                            <div class="bg-white rounded-lg shadow-md overflow-hidden transition duration-300 hover:shadow-lg">
                                <a href="{{ route('products.show', $relatedProduct->slug) }}" class="block">
                                    <div class="h-48 bg-gray-200 relative">
                                        @if($relatedProduct->featured_image)
                                            <img src="{{ asset($relatedProduct->featured_image) }}" alt="{{ $relatedProduct->name }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-500">
                                                <i class="fas fa-box fa-2x"></i>
                                            </div>
                                        @endif
                                        
                                        @if($relatedProduct->sale_price && $relatedProduct->sale_price < $relatedProduct->regular_price)
                                            <span class="absolute top-2 right-2 bg-red-500 text-white text-xs uppercase py-1 px-2 rounded">
                                                {{ __('products.sale') }}
                                            </span>
                                        @endif
                                    </div>
                                </a>
                                
                                <div class="p-4">
                                    <h3 class="font-semibold mb-2">
                                        <a href="{{ route('products.show', $relatedProduct->slug) }}" class="text-gray-800 hover:text-blue-600">
                                            {{ $relatedProduct->name }}
                                        </a>
                                    </h3>
                                    
                                    <div class="flex items-end justify-between mt-3">
                                        <div>
                                            @if($relatedProduct->sale_price && $relatedProduct->sale_price < $relatedProduct->regular_price)
                                                <span class="text-gray-400 line-through text-sm">{{ __('products.currency_symbol') }}{{ number_format($relatedProduct->regular_price, 2) }}</span>
                                                <span class="text-red-600 font-bold ml-1">{{ __('products.currency_symbol') }}{{ number_format($relatedProduct->sale_price, 2) }}</span>
                                            @else
                                                <span class="text-gray-800 font-bold">{{ __('products.currency_symbol') }}{{ number_format($relatedProduct->price, 2) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4">
                                        <a href="{{ route('products.show', $relatedProduct->slug) }}" class="block text-center bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
                                            {{ __('general.view_details') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        // Product image gallery functionality could be added here
    });
</script>
@endpush