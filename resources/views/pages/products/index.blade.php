@extends('layouts.app')

@section('title', 'Software Products')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl font-bold mb-4">Our Software Solutions</h1>
            <p class="text-xl text-blue-100">Discover powerful software tools designed to streamline your business operations and boost productivity</p>
        </div>
    </div>
</section>

<!-- Product Categories -->
<section class="py-10 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="flex flex-wrap justify-center items-center gap-4">
            <a href="{{ route('products.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">All Products</a>
            @foreach($categories as $category)
                <a href="{{ route('products.category', $category->slug) }}" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-md hover:bg-gray-100 transition-colors">{{ $category->name }}</a>
            @endforeach
        </div>
    </div>
</section>

<!-- Products Grid -->
<section class="py-12">
    <div class="container mx-auto px-4">
        <!-- Filters and Sort -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8">
            <div class="mb-4 md:mb-0">
                <h2 class="text-2xl font-bold">{{ $categoryName ?? 'All Products' }}</h2>
                <p class="text-gray-600">{{ $products->total() }} software products available</p>
            </div>
            <div class="flex items-center">
                <label for="sort" class="mr-2 text-gray-600">Sort by:</label>
                <select id="sort" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
                    <option value="newest">Newest</option>
                    <option value="price-low">Price: Low to High</option>
                    <option value="price-high">Price: High to Low</option>
                    <option value="name">Name</option>
                </select>
            </div>
        </div>
        
        <!-- Products Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($products as $product)
                <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform hover:transform hover:scale-105 hover:shadow-lg flex flex-col h-full">
                    <div class="h-48 bg-gray-200 relative overflow-hidden">
                        @if($product->thumbnail)
                            <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="flex items-center justify-center h-full bg-blue-600 text-white">
                                <i class="fas fa-box text-5xl"></i>
                            </div>
                        @endif
                        
                        @if($product->sale_price && $product->sale_price < $product->price)
                            <div class="absolute top-4 right-4 bg-red-600 text-white text-sm px-2 py-1 rounded-md">
                                {{ round((($product->price - $product->sale_price) / $product->price) * 100) }}% OFF
                            </div>
                        @endif
                    </div>
                    
                    <div class="p-6 flex-grow">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium px-2 py-1 bg-blue-100 text-blue-800 rounded-md">{{ $product->category->name }}</span>
                            <div class="text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                        
                        <h3 class="text-xl font-bold mb-2">{{ $product->name }}</h3>
                        <p class="text-gray-600 mb-4 line-clamp-2">{{ $product->short_description }}</p>
                        
                        <div class="mb-6">
                            <span class="text-xl font-bold text-blue-600">
                                @if($product->sale_price)
                                    ${{ number_format($product->sale_price, 2) }}
                                    <span class="text-sm text-gray-500 line-through ml-2">${{ number_format($product->price, 2) }}</span>
                                @else
                                    ${{ number_format($product->price, 2) }}
                                @endif
                            </span>
                            <span class="ml-2 text-sm text-gray-500">{{ $product->license_required ? 'License required' : 'One-time purchase' }}</span>
                        </div>
                    </div>
                    
                    <div class="p-4 bg-gray-50 border-t border-gray-100">
                        <div class="flex items-center justify-between">
                            <a href="{{ route('products.show', $product->slug) }}" class="text-blue-600 hover:text-blue-800 font-medium">View Details</a>
                            <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                                    <i class="fas fa-shopping-cart mr-1"></i> Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12">
                    <div class="text-5xl text-gray-300 mb-4">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <h3 class="text-xl font-medium text-gray-600 mb-1">No Products Found</h3>
                    <p class="text-gray-500">We couldn't find any products that match your criteria.</p>
                </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        <div class="mt-12">
            {{ $products->links() }}
        </div>
    </div>
</section>

<!-- Featured Categories -->
<section class="py-16 bg-gray-100">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-12 text-center">Browse by Category</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($featuredCategories as $category)
                <a href="{{ route('products.category', $category->slug) }}" class="bg-white rounded-lg shadow-md p-8 hover:shadow-lg transition-shadow flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold mb-2">{{ $category->name }}</h3>
                        <p class="text-gray-600">{{ $category->products_count }} Products</p>
                    </div>
                    <div class="text-4xl text-blue-600">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="bg-blue-700 text-white py-16">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4">Need a Custom Solution?</h2>
        <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">Our team can develop tailored software solutions to address your unique business challenges</p>
        <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
            <a href="{{ route('contact') }}" class="bg-white text-blue-600 hover:bg-gray-100 font-semibold rounded-md px-8 py-3 transition-all duration-200">Contact Us</a>
            <a href="{{ route('about') }}" class="bg-transparent border-2 border-white hover:bg-white hover:text-blue-600 text-white font-semibold rounded-md px-8 py-3 transition-all duration-200">Learn More</a>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sortSelect = document.getElementById('sort');
        const currentUrl = new URL(window.location.href);
        
        // Set initial value from URL params
        const urlSort = currentUrl.searchParams.get('sort');
        if (urlSort) {
            sortSelect.value = urlSort;
        }
        
        // Update URL when sort option changes
        sortSelect.addEventListener('change', function() {
            currentUrl.searchParams.set('sort', this.value);
            window.location.href = currentUrl.toString();
        });

        // AJAX Add to Cart functionality for product listings
        document.querySelectorAll('.add-to-cart-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalBtnText = submitBtn.innerHTML;
                
                // Show loading state
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
                
                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        const alertBox = document.createElement('div');
                        alertBox.className = 'fixed top-4 right-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 z-50';
                        alertBox.innerHTML = `
                            <div class="flex items-center">
                                <i class="fas fa-check-circle mr-2"></i>
                                <p>${data.message}</p>
                            </div>
                        `;
                        document.body.appendChild(alertBox);
                        
                        // Update cart counter in header
                        const cartCounter = document.querySelector('.cart-counter');
                        if (cartCounter) {
                            cartCounter.textContent = data.cart_count;
                            cartCounter.classList.remove('hidden');
                        }
                        
                        // Remove the alert after 3 seconds
                        setTimeout(() => {
                            alertBox.remove();
                        }, 3000);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                })
                .finally(() => {
                    // Restore button
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;
                });
            });
        });
    });
</script>
@endpush