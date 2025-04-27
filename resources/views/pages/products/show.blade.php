@extends('layouts.app')

@section('title', $product->name)

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
                        <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-blue-600 text-sm">Products</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 text-sm mx-1"></i>
                        <a href="{{ route('products.category', $product->category->slug) }}" class="text-gray-700 hover:text-blue-600 text-sm">{{ $product->category->name }}</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 text-sm mx-1"></i>
                        <span class="text-gray-500 text-sm">{{ $product->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>
</section>

<!-- Product Details -->
<section class="py-12">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Product Image -->
            <div class="space-y-6">
                <!-- Main Image -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    @if($product->thumbnail)
                        <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}" class="w-full h-auto object-contain" id="main-product-image">
                    @else
                        <div class="flex items-center justify-center h-96 bg-blue-600 text-white">
                            <i class="fas fa-box text-8xl"></i>
                        </div>
                    @endif
                </div>

                <!-- Product Screenshots -->
                <div class="grid grid-cols-4 gap-3">
                    @if($product->thumbnail)
                        <div class="cursor-pointer border-2 border-blue-600 rounded-md overflow-hidden">
                            <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}" class="w-full h-24 object-cover">
                        </div>
                    @endif
                    <!-- Additional screenshots would be displayed here -->
                    <div class="cursor-pointer border-2 border-gray-200 rounded-md overflow-hidden">
                        <img src="https://via.placeholder.com/600x400?text=Screenshot+1" alt="Screenshot 1" class="w-full h-24 object-cover">
                    </div>
                    <div class="cursor-pointer border-2 border-gray-200 rounded-md overflow-hidden">
                        <img src="https://via.placeholder.com/600x400?text=Screenshot+2" alt="Screenshot 2" class="w-full h-24 object-cover">
                    </div>
                    <div class="cursor-pointer border-2 border-gray-200 rounded-md overflow-hidden">
                        <img src="https://via.placeholder.com/600x400?text=Screenshot+3" alt="Screenshot 3" class="w-full h-24 object-cover">
                    </div>
                </div>
            </div>

            <!-- Product Info -->
            <div class="space-y-8">
                <div>
                    <div class="flex items-center mb-2">
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-md">{{ $product->category->name }}</span>
                        <span class="ml-3 text-gray-500">Version {{ $product->version }}</span>
                    </div>
                    
                    <h1 class="text-3xl font-bold mb-4">{{ $product->name }}</h1 }
                    
                    <!-- Ratings -->
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400 mr-2">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <span class="text-gray-600">4.5 (28 reviews)</span>
                    </div>
                    
                    <!-- Short Description -->
                    <p class="text-gray-600 mb-6">{{ $product->short_description }}</p>
                    
                    <!-- Price -->
                    <div class="mb-6">
                        @if($product->sale_price && $product->sale_price < $product->price)
                            <div class="flex items-center mb-2">
                                <span class="text-3xl font-bold text-blue-600">${{ number_format($product->sale_price, 2) }}</span>
                                <span class="ml-3 text-xl text-gray-500 line-through">${{ number_format($product->price, 2) }}</span>
                                <span class="ml-3 px-2 py-1 bg-red-600 text-white rounded-md">
                                    {{ round((($product->price - $product->sale_price) / $product->price) * 100) }}% OFF
                                </span>
                            </div>
                        @else
                            <span class="text-3xl font-bold text-blue-600">${{ number_format($product->price, 2) }}</span>
                        @endif
                        
                        <p class="text-gray-500">
                            @if($product->license_required)
                                <i class="fas fa-key mr-2"></i> Includes license key for {{ $product->license_duration ?? 'lifetime' }} 
                            @else
                                <i class="fas fa-download mr-2"></i> One-time download, no license required
                            @endif
                        </p>
                    </div>
                    
                    <!-- Add to Cart -->
                    <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 mb-8">
                        <form action="{{ route('cart.add') }}" method="POST" id="add-to-cart-form" class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 w-full">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="flex border border-gray-300 rounded-md overflow-hidden">
                                <button type="button" class="px-4 py-2 bg-gray-100 border-r border-gray-300 hover:bg-gray-200 transition-colors quantity-btn" data-action="decrease">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" name="quantity" value="1" min="1" class="w-16 text-center focus:outline-none">
                                <button type="button" class="px-4 py-2 bg-gray-100 border-l border-gray-300 hover:bg-gray-200 transition-colors quantity-btn" data-action="increase">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <div class="flex-1 flex space-x-2">
                                <button type="submit" class="flex-1 bg-blue-600 text-white rounded-md px-4 py-3 hover:bg-blue-700 transition-colors flex items-center justify-center">
                                    <i class="fas fa-shopping-cart mr-2"></i>
                                    Add to Cart
                                </button>
                                <button type="button" id="buy-now-btn" class="flex-1 bg-green-600 text-white rounded-md px-4 py-3 hover:bg-green-700 transition-colors flex items-center justify-center">
                                    <i class="fas fa-bolt mr-2"></i>
                                    Buy Now
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Features -->
                    <div class="border-t border-gray-200 pt-6 space-y-4">
                        <div class="flex items-start">
                            <div class="text-blue-600 mr-3">
                                <i class="fas fa-check-circle mt-1"></i>
                            </div>
                            <div>
                                <h4 class="font-medium">Instant Digital Download</h4>
                                <p class="text-sm text-gray-600">Get immediate access to your software after purchase</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="text-blue-600 mr-3">
                                <i class="fas fa-check-circle mt-1"></i>
                            </div>
                            <div>
                                <h4 class="font-medium">Free Software Updates</h4>
                                <p class="text-sm text-gray-600">Access to all minor updates within your license period</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="text-blue-600 mr-3">
                                <i class="fas fa-check-circle mt-1"></i>
                            </div>
                            <div>
                                <h4 class="font-medium">Premium Customer Support</h4>
                                <p class="text-sm text-gray-600">Priority technical assistance for 12 months</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Product Description Tabs -->
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <!-- Tabs Navigation -->
        <div class="border-b border-gray-200 mb-8">
            <div class="flex flex-wrap -mb-px">
                <button class="tab-button active" data-tab="description">
                    Description
                </button>
                <button class="tab-button" data-tab="features">
                    Features
                </button>
                <button class="tab-button" data-tab="system-requirements">
                    System Requirements
                </button>
                <button class="tab-button" data-tab="reviews">
                    Reviews (28)
                </button>
                <button class="tab-button" data-tab="faq">
                    FAQ
                </button>
            </div>
        </div>
        
        <!-- Tab Contents -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <!-- Description Tab -->
            <div class="tab-content active" id="description">
                <div class="prose max-w-none">
                    {!! $product->description !!}
                </div>
            </div>
            
            <!-- Features Tab -->
            <div class="tab-content hidden" id="features">
                <div class="grid md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-xl font-bold mb-4">Key Features</h3>
                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <span class="text-blue-600 mr-2"><i class="fas fa-check-circle mt-1"></i></span>
                                <span>Automated data processing with advanced algorithms</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-blue-600 mr-2"><i class="fas fa-check-circle mt-1"></i></span>
                                <span>Real-time analytics dashboard with customizable views</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-blue-600 mr-2"><i class="fas fa-check-circle mt-1"></i></span>
                                <span>Secure cloud storage with automated backups</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-blue-600 mr-2"><i class="fas fa-check-circle mt-1"></i></span>
                                <span>Comprehensive reporting system with export options</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-blue-600 mr-2"><i class="fas fa-check-circle mt-1"></i></span>
                                <span>Multi-platform compatibility (Windows, Mac, Linux)</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-blue-600 mr-2"><i class="fas fa-check-circle mt-1"></i></span>
                                <span>Integration with popular third-party applications</span>
                            </li>
                        </ul>
                    </div>
                    
                    <div>
                        <h3 class="text-xl font-bold mb-4">Advanced Capabilities</h3>
                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <span class="text-blue-600 mr-2"><i class="fas fa-check-circle mt-1"></i></span>
                                <span>API access for custom integrations</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-blue-600 mr-2"><i class="fas fa-check-circle mt-1"></i></span>
                                <span>Automated workflow templates for common business processes</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-blue-600 mr-2"><i class="fas fa-check-circle mt-1"></i></span>
                                <span>Role-based access control for team management</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-blue-600 mr-2"><i class="fas fa-check-circle mt-1"></i></span>
                                <span>Advanced data visualization tools</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-blue-600 mr-2"><i class="fas fa-check-circle mt-1"></i></span>
                                <span>Customizable alerts and notifications system</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-blue-600 mr-2"><i class="fas fa-check-circle mt-1"></i></span>
                                <span>Extensive documentation and video tutorials</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- System Requirements Tab -->
            <div class="tab-content hidden" id="system-requirements">
                <div class="grid md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-xl font-bold mb-4">Minimum Requirements</h3>
                        <ul class="space-y-2">
                            <li class="flex">
                                <span class="font-medium w-32">Operating System:</span>
                                <span>Windows 10/11, macOS 11+, or Linux (Ubuntu 20.04+)</span>
                            </li>
                            <li class="flex">
                                <span class="font-medium w-32">Processor:</span>
                                <span>Intel Core i3 / AMD Ryzen 3 or equivalent</span>
                            </li>
                            <li class="flex">
                                <span class="font-medium w-32">Memory:</span>
                                <span>4 GB RAM</span>
                            </li>
                            <li class="flex">
                                <span class="font-medium w-32">Storage:</span>
                                <span>5 GB available space</span>
                            </li>
                            <li class="flex">
                                <span class="font-medium w-32">Graphics:</span>
                                <span>Compatible with DirectX 11 / Metal</span>
                            </li>
                            <li class="flex">
                                <span class="font-medium w-32">Internet:</span>
                                <span>Broadband connection for activation</span>
                            </li>
                        </ul>
                    </div>
                    
                    <div>
                        <h3 class="text-xl font-bold mb-4">Recommended Requirements</h3>
                        <ul class="space-y-2">
                            <li class="flex">
                                <span class="font-medium w-32">Operating System:</span>
                                <span>Windows 11, macOS 12+, or Linux (Ubuntu 22.04+)</span>
                            </li>
                            <li class="flex">
                                <span class="font-medium w-32">Processor:</span>
                                <span>Intel Core i7 / AMD Ryzen 7 or equivalent</span>
                            </li>
                            <li class="flex">
                                <span class="font-medium w-32">Memory:</span>
                                <span>16 GB RAM</span>
                            </li>
                            <li class="flex">
                                <span class="font-medium w-32">Storage:</span>
                                <span>20 GB SSD</span>
                            </li>
                            <li class="flex">
                                <span class="font-medium w-32">Graphics:</span>
                                <span>Dedicated GPU with 2GB+ VRAM</span>
                            </li>
                            <li class="flex">
                                <span class="font-medium w-32">Internet:</span>
                                <span>High-speed broadband connection</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Reviews Tab -->
            <div class="tab-content hidden" id="reviews">
                <div class="mb-8">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold">Customer Reviews</h3>
                        <button class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                            Write a Review
                        </button>
                    </div>
                    
                    <div class="grid md:grid-cols-2 gap-8 mb-8">
                        <div>
                            <div class="flex items-center mb-4">
                                <span class="text-2xl font-bold mr-2">4.5</span>
                                <div class="flex text-yellow-400 mr-2">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <span class="text-sm text-gray-600">Based on 28 reviews</span>
                            </div>
                            
                            <!-- Rating Breakdown -->
                            <div class="space-y-2">
                                <div class="flex items-center">
                                    <span class="w-12 text-sm text-gray-600">5 stars</span>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5 ml-2 mr-2">
                                        <div class="bg-yellow-400 h-2.5 rounded-full" style="width: 70%"></div>
                                    </div>
                                    <span class="w-8 text-sm text-gray-600">70%</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="w-12 text-sm text-gray-600">4 stars</span>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5 ml-2 mr-2">
                                        <div class="bg-yellow-400 h-2.5 rounded-full" style="width: 20%"></div>
                                    </div>
                                    <span class="w-8 text-sm text-gray-600">20%</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="w-12 text-sm text-gray-600">3 stars</span>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5 ml-2 mr-2">
                                        <div class="bg-yellow-400 h-2.5 rounded-full" style="width: 5%"></div>
                                    </div>
                                    <span class="w-8 text-sm text-gray-600">5%</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="w-12 text-sm text-gray-600">2 stars</span>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5 ml-2 mr-2">
                                        <div class="bg-yellow-400 h-2.5 rounded-full" style="width: 3%"></div>
                                    </div>
                                    <span class="w-8 text-sm text-gray-600">3%</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="w-12 text-sm text-gray-600">1 star</span>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5 ml-2 mr-2">
                                        <div class="bg-yellow-400 h-2.5 rounded-full" style="width: 2%"></div>
                                    </div>
                                    <span class="w-8 text-sm text-gray-600">2%</span>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h4 class="font-medium mb-2">Review this product</h4>
                            <p class="text-gray-600 text-sm mb-4">Share your experience with other customers</p>
                            <button class="w-full px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50 transition-colors">
                                Write a customer review
                            </button>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-200 pt-8">
                        <!-- Sample Review 1 -->
                        <div class="mb-8">
                            <div class="flex justify-between items-start mb-2">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-semibold mr-3">
                                        JD
                                    </div>
                                    <div>
                                        <p class="font-medium">John D.</p>
                                        <p class="text-xs text-gray-500">Verified Purchase</p>
                                    </div>
                                </div>
                                <span class="text-sm text-gray-500">March 15, 2025</span>
                            </div>
                            
                            <div class="flex text-yellow-400 mb-2">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            
                            <h4 class="font-semibold mb-2">Exceptional software that saved our business time and money</h4>
                            <p class="text-gray-600 mb-4">
                                This product has completely transformed our workflow. The automation features alone have saved us countless hours each week. 
                                Setup was straightforward and the learning curve wasn't steep at all. Customer support has been responsive whenever we had questions.
                                Highly recommended for any business looking to streamline their operations.
                            </p>
                        </div>
                        
                        <!-- Sample Review 2 -->
                        <div class="mb-8">
                            <div class="flex justify-between items-start mb-2">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-semibold mr-3">
                                        SM
                                    </div>
                                    <div>
                                        <p class="font-medium">Sarah M.</p>
                                        <p class="text-xs text-gray-500">Verified Purchase</p>
                                    </div>
                                </div>
                                <span class="text-sm text-gray-500">January 8, 2025</span>
                            </div>
                            
                            <div class="flex text-yellow-400 mb-2">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                            </div>
                            
                            <h4 class="font-semibold mb-2">Great product with a few minor issues</h4>
                            <p class="text-gray-600 mb-4">
                                Overall I'm very satisfied with this software. The reporting features are incredibly detailed and have given us insights
                                we never had access to before. The only reason I'm giving 4 stars instead of 5 is the occasional lag when processing very large 
                                datasets. That said, the development team is actively working on optimizations so I expect this will improve soon.
                            </p>
                        </div>
                        
                        <div class="text-center">
                            <button class="px-6 py-2 border border-gray-300 rounded-md hover:bg-gray-50 transition-colors">
                                Load More Reviews
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- FAQ Tab -->
            <div class="tab-content hidden" id="faq">
                <div class="space-y-6 mb-8">
                    <h3 class="text-xl font-bold mb-4">Frequently Asked Questions</h3>
                    
                    <!-- FAQ Item 1 -->
                    <div class="border-b border-gray-200 pb-4">
                        <button class="faq-question w-full flex justify-between items-center text-left" data-target="faq-1">
                            <span class="font-medium">Is this a one-time purchase or subscription?</span>
                            <i class="fas fa-chevron-down text-gray-500 transition-transform"></i>
                        </button>
                        <div id="faq-1" class="faq-answer mt-2 text-gray-600 hidden">
                            This is a one-time purchase which includes 12 months of updates and support. After that period, you can continue using the software indefinitely, but to receive updates and support beyond the initial period, a maintenance plan is available for purchase.
                        </div>
                    </div>
                    
                    <!-- FAQ Item 2 -->
                    <div class="border-b border-gray-200 pb-4">
                        <button class="faq-question w-full flex justify-between items-center text-left" data-target="faq-2">
                            <span class="font-medium">How many devices can I install this on?</span>
                            <i class="fas fa-chevron-down text-gray-500 transition-transform"></i>
                        </button>
                        <div id="faq-2" class="faq-answer mt-2 text-gray-600 hidden">
                            The standard license allows installation on up to 2 devices for a single user. If you need to install the software on more devices or for multiple users, please check our volume licensing options or contact our sales team.
                        </div>
                    </div>
                    
                    <!-- FAQ Item 3 -->
                    <div class="border-b border-gray-200 pb-4">
                        <button class="faq-question w-full flex justify-between items-center text-left" data-target="faq-3">
                            <span class="font-medium">Do you offer refunds if I'm not satisfied?</span>
                            <i class="fas fa-chevron-down text-gray-500 transition-transform"></i>
                        </button>
                        <div id="faq-3" class="faq-answer mt-2 text-gray-600 hidden">
                            Yes, we offer a 30-day money-back guarantee. If you're not completely satisfied with our software, you can request a full refund within 30 days of purchase, no questions asked.
                        </div>
                    </div>
                    
                    <!-- FAQ Item 4 -->
                    <div class="border-b border-gray-200 pb-4">
                        <button class="faq-question w-full flex justify-between items-center text-left" data-target="faq-4">
                            <span class="font-medium">Is there a trial version available?</span>
                            <i class="fas fa-chevron-down text-gray-500 transition-transform"></i>
                        </button>
                        <div id="faq-4" class="faq-answer mt-2 text-gray-600 hidden">
                            Yes, we offer a fully-functional 14-day trial version. You can download it from our website and test all features before making a purchase decision.
                        </div>
                    </div>
                    
                    <!-- FAQ Item 5 -->
                    <div class="border-b border-gray-200 pb-4">
                        <button class="faq-question w-full flex justify-between items-center text-left" data-target="faq-5">
                            <span class="font-medium">What kind of customer support do you provide?</span>
                            <i class="fas fa-chevron-down text-gray-500 transition-transform"></i>
                        </button>
                        <div id="faq-5" class="faq-answer mt-2 text-gray-600 hidden">
                            Our customer support includes email help desk, knowledge base access, and community forums. Premium support with dedicated phone lines and faster response times is available with our Business and Enterprise licenses.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Products -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-12 text-center">You May Also Like</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($relatedProducts as $relatedProduct)
                <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform hover:transform hover:scale-105 hover:shadow-lg">
                    <div class="h-48 bg-gray-200 relative overflow-hidden">
                        @if($relatedProduct->thumbnail)
                            <img src="{{ asset('storage/' . $relatedProduct->thumbnail) }}" alt="{{ $relatedProduct->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="flex items-center justify-center h-full bg-blue-600 text-white">
                                <i class="fas fa-box text-5xl"></i>
                            </div>
                        @endif
                    </div>
                    
                    <div class="p-4">
                        <span class="text-xs font-medium px-2 py-1 bg-blue-100 text-blue-800 rounded-md">{{ $relatedProduct->category->name }}</span>
                        <h3 class="text-lg font-bold mt-2 mb-1">{{ $relatedProduct->name }}</h3>
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-blue-600">${{ number_format($relatedProduct->sale_price ?? $relatedProduct->price, 2) }}</span>
                            <a href="{{ route('products.show', $relatedProduct->slug) }}" class="text-blue-600 hover:text-blue-800 text-sm">View Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .tab-button {
        @apply inline-block px-4 py-2 font-medium text-gray-600 hover:text-blue-600 border-b-2 border-transparent hover:border-blue-600 focus:outline-none;
    }
    
    .tab-button.active {
        @apply text-blue-600 border-blue-600;
    }
    
    .tab-content {
        display: none;
    }
    
    .tab-content.active {
        display: block;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Product Tabs
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');
        
        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Update active tab button
                tabButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                // Show corresponding content
                const tabId = this.getAttribute('data-tab');
                tabContents.forEach(content => {
                    content.classList.remove('active');
                    content.classList.add('hidden');
                });
                document.getElementById(tabId).classList.remove('hidden');
                document.getElementById(tabId).classList.add('active');
            });
        });
        
        // FAQ Accordions
        const faqQuestions = document.querySelectorAll('.faq-question');
        
        faqQuestions.forEach(question => {
            question.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const answer = document.getElementById(targetId);
                const icon = this.querySelector('i');
                
                // Toggle answer visibility
                answer.classList.toggle('hidden');
                
                // Rotate icon
                if (answer.classList.contains('hidden')) {
                    icon.style.transform = 'rotate(0deg)';
                } else {
                    icon.style.transform = 'rotate(180deg)';
                }
            });
        });
        
        // Product image gallery
        const thumbnails = document.querySelectorAll('.product-thumbnail');
        const mainImage = document.getElementById('main-product-image');
        
        thumbnails.forEach(thumbnail => {
            thumbnail.addEventListener('click', function() {
                // Update main image
                mainImage.src = this.querySelector('img').src;
                
                // Update active thumbnail border
                thumbnails.forEach(thumb => {
                    thumb.classList.remove('border-blue-600');
                    thumb.classList.add('border-gray-200');
                });
                this.classList.remove('border-gray-200');
                this.classList.add('border-blue-600');
            });
        });
    });

    // Quantity buttons functionality
    document.querySelectorAll('.quantity-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = document.querySelector('input[name="quantity"]');
            const currentValue = parseInt(input.value, 10);
            if (this.getAttribute('data-action') === 'increase') {
                input.value = currentValue + 1;
            } else if (this.getAttribute('data-action') === 'decrease' && currentValue > 1) {
                input.value = currentValue - 1;
            }
        });
    });

    // Add to cart form submission via AJAX
    document.getElementById('add-to-cart-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const form = this;
        const formData = new FormData(form);
        
        fetch(form.action, {
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
                
                // Update cart counter in the header if it exists
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
        });
    });

    // Buy Now functionality
    document.getElementById('buy-now-btn').addEventListener('click', function() {
        const form = document.getElementById('add-to-cart-form');
        const formData = new FormData(form);
        formData.append('buy_now', 'true');
        
        fetch(form.action, {
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
                // Redirect to checkout page
                window.location.href = data.redirect || '{{ route('checkout.index') }}';
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
</script>
@endpush