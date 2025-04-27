<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <title>@yield('title', 'Z+ Software Solutions') - Z+ Software Company</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600|poppins:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
        
        <!-- Tailwind CSS via CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Instrument Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        },
                    }
                }
            }
        </script>
        
        <!-- Custom styles -->
        <style>
            /* Add any custom styles here */
            .btn {
                @apply px-4 py-2 rounded font-medium transition-all duration-200;
            }
            
            .btn-primary {
                @apply bg-blue-600 text-white hover:bg-blue-700;
            }
            
            .btn-secondary {
                @apply bg-gray-200 text-gray-800 hover:bg-gray-300;
            }
            
            .card {
                @apply bg-white rounded-lg shadow-md p-6;
            }
        </style>
        
        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        @stack('styles')
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-900 min-h-screen flex flex-col">
        <!-- Header/Navigation -->
        <header class="bg-white shadow-sm sticky top-0 z-50">
            <div class="container mx-auto px-4 py-4">
                <div class="flex items-center justify-between">
                    <!-- Logo -->
                    <a href="{{ url('/') }}" class="flex items-center">
                        <img src="{{ asset('img/zplus.png') }}" alt="Z+ Software" class="h-14">
                    </a>
                    
                    <!-- Desktop Navigation -->
                    <nav class="hidden lg:flex space-x-8">
                        <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600 font-medium py-2 transition-all duration-200 {{ request()->routeIs('home') ? 'text-blue-600 border-b-2 border-blue-600' : '' }}">Home</a>
                        <a href="{{ route('about') }}" class="text-gray-700 hover:text-blue-600 font-medium py-2 transition-all duration-200 {{ request()->routeIs('about') ? 'text-blue-600 border-b-2 border-blue-600' : '' }}">About Us</a>
                        <a href="{{ route('projects.index') }}" class="text-gray-700 hover:text-blue-600 font-medium py-2 transition-all duration-200 {{ request()->routeIs('projects.*') ? 'text-blue-600 border-b-2 border-blue-600' : '' }}">Projects</a>
                        <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-blue-600 font-medium py-2 transition-all duration-200 {{ request()->routeIs('products.*') ? 'text-blue-600 border-b-2 border-blue-600' : '' }}">Products</a>
                        <a href="{{ route('blog.index') }}" class="text-gray-700 hover:text-blue-600 font-medium py-2 transition-all duration-200 {{ request()->routeIs('blog.*') ? 'text-blue-600 border-b-2 border-blue-600' : '' }}">Blog</a>
                        <a href="{{ route('contact') }}" class="text-gray-700 hover:text-blue-600 font-medium py-2 transition-all duration-200 {{ request()->routeIs('contact') ? 'text-blue-600 border-b-2 border-blue-600' : '' }}">Contact</a>
                    </nav>
                    
                    <!-- User menu / Login buttons -->
                    <div class="hidden lg:flex items-center space-x-4">
                        <!-- Shopping Cart -->
                        <div class="relative cart-dropdown">
                            <button type="button" class="cart-toggle flex items-center px-3 py-2 text-gray-700 hover:text-blue-600 relative">
                                <i class="fas fa-shopping-cart text-lg"></i>
                                <span class="cart-counter absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center {{ App\Models\CartItem::where('session_id', Session::get('cart_id', ''))->sum('quantity') > 0 ? '' : 'hidden' }}">
                                    {{ App\Models\CartItem::where('session_id', Session::get('cart_id', ''))->sum('quantity') }}
                                </span>
                            </button>
                            
                            @include('partials.cart.mini-cart')
                        </div>
                        
                        @auth
                            <div class="relative group">
                                <button type="button" class="flex items-center px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-md hover:bg-gray-50 transition-all duration-200">
                                    <span class="mr-2">{{ Auth::user()->name }}</span>
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </button>
                                <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 hidden group-hover:block">
                                    <a href="{{ route('customer.dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Dashboard</a>
                                    <a href="{{ route('customer.profile') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">My Profile</a>
                                    <a href="{{ route('customer.orders') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Orders</a>
                                    <a href="{{ route('customer.downloads') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Downloads</a>
                                    <div class="border-t border-gray-200 my-1"></div>
                                    <form method="POST" action="{{ route('logout') }}" class="block">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-all duration-200">Register</a>
                            @endif
                        @endauth
                    </div>
                    
                    <!-- Mobile menu button -->
                    <div class="lg:hidden">
                        <button type="button" class="mobile-menu-button text-gray-700 hover:text-blue-600 focus:outline-none">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <!-- Mobile Menu -->
                <div class="mobile-menu hidden lg:hidden mt-4 pb-2">
                    <a href="{{ route('home') }}" class="block py-2 text-gray-700 hover:text-blue-600 {{ request()->routeIs('home') ? 'text-blue-600 font-medium' : '' }}">Home</a>
                    <a href="{{ route('about') }}" class="block py-2 text-gray-700 hover:text-blue-600 {{ request()->routeIs('about') ? 'text-blue-600 font-medium' : '' }}">About Us</a>
                    <a href="{{ route('projects.index') }}" class="block py-2 text-gray-700 hover:text-blue-600 {{ request()->routeIs('projects.*') ? 'text-blue-600 font-medium' : '' }}">Projects</a>
                    <a href="{{ route('products.index') }}" class="block py-2 text-gray-700 hover:text-blue-600 {{ request()->routeIs('products.*') ? 'text-blue-600 font-medium' : '' }}">Products</a>
                    <a href="{{ route('blog.index') }}" class="block py-2 text-gray-700 hover:text-blue-600 {{ request()->routeIs('blog.*') ? 'text-blue-600 font-medium' : '' }}">Blog</a>
                    <a href="{{ route('contact') }}" class="block py-2 text-gray-700 hover:text-blue-600 {{ request()->routeIs('contact') ? 'text-blue-600 font-medium' : '' }}">Contact</a>
                    
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <!-- Mobile cart link -->
                        <a href="{{ route('cart.index') }}" class="flex items-center py-2 text-gray-700 hover:text-blue-600">
                            <i class="fas fa-shopping-cart mr-2"></i> 
                            <span>Shopping Cart</span>
                            <span class="cart-counter ml-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center {{ App\Models\CartItem::where('session_id', Session::get('cart_id', ''))->sum('quantity') > 0 ? '' : 'hidden' }}">
                                {{ App\Models\CartItem::where('session_id', Session::get('cart_id', ''))->sum('quantity') }}
                            </span>
                        </a>
                        
                        @auth
                            <a href="{{ route('customer.dashboard') }}" class="block py-2 text-gray-700 hover:text-blue-600">Dashboard</a>
                            <a href="{{ route('customer.profile') }}" class="block py-2 text-gray-700 hover:text-blue-600">My Profile</a>
                            <a href="{{ route('customer.orders') }}" class="block py-2 text-gray-700 hover:text-blue-600">Orders</a>
                            <a href="{{ route('customer.downloads') }}" class="block py-2 text-gray-700 hover:text-blue-600">Downloads</a>
                            
                            <form method="POST" action="{{ route('logout') }}" class="block pt-2">
                                @csrf
                                <button type="submit" class="w-full text-left py-2 text-gray-700 hover:text-blue-600">
                                    Logout
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="block py-2 text-gray-700 hover:text-blue-600">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="block mt-2 w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-all duration-200 text-center">Register</a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </header>
        
        <!-- Main Content -->
        <main class="flex-grow">
            @yield('content')
        </main>
        
        <!-- Footer -->
        <footer class="bg-gray-800 text-white py-12">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Company Info -->
                    <div>
                        <h3 class="text-xl font-bold mb-4">Z+ Software</h3>
                        <p class="text-gray-300 mb-4">Developing innovative software solutions to empower businesses and individuals.</p>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-300 hover:text-white"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="text-gray-300 hover:text-white"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="text-gray-300 hover:text-white"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" class="text-gray-300 hover:text-white"><i class="fab fa-github"></i></a>
                        </div>
                    </div>
                    
                    <!-- Quick Links -->
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                        <ul class="space-y-2">
                            <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-white">Home</a></li>
                            <li><a href="{{ route('about') }}" class="text-gray-300 hover:text-white">About Us</a></li>
                            <li><a href="{{ route('projects.index') }}" class="text-gray-300 hover:text-white">Projects</a></li>
                            <li><a href="{{ route('products.index') }}" class="text-gray-300 hover:text-white">Products</a></li>
                            <li><a href="{{ route('blog.index') }}" class="text-gray-300 hover:text-white">Blog</a></li>
                            <li><a href="{{ route('contact') }}" class="text-gray-300 hover:text-white">Contact</a></li>
                        </ul>
                    </div>
                    
                    <!-- Products -->
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Our Products</h4>
                        <ul class="space-y-2">
                            <li><a href="{{ route('products.index') }}" class="text-gray-300 hover:text-white">All Products</a></li>
                            @foreach($featuredCategories ?? [] as $category)
                                <li><a href="{{ route('products.category', $category->slug) }}" class="text-gray-300 hover:text-white">{{ $category->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <!-- Contact Info -->
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Contact Us</h4>
                        <ul class="space-y-2">
                            <li class="flex items-start">
                                <i class="fas fa-map-marker-alt mt-1 mr-3 text-blue-400"></i>
                                <span>123 Software Avenue, Tech District, City 10000</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-phone mr-3 text-blue-400"></i>
                                <span>+1 234 567 8900</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-envelope mr-3 text-blue-400"></i>
                                <span>info@zplussoftware.com</span>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                    <p>&copy; {{ date('Y') }} Z+ Software Company. All rights reserved.</p>
                </div>
            </div>
        </footer>
        
        <script>
            // Mobile menu toggle
            document.addEventListener('DOMContentLoaded', function() {
                const mobileMenuButton = document.querySelector('.mobile-menu-button');
                const mobileMenu = document.querySelector('.mobile-menu');
                
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
                
                // Mini-cart functionality
                const cartToggle = document.querySelector('.cart-toggle');
                const miniCartDropdown = document.getElementById('mini-cart-dropdown');
                
                if (cartToggle && miniCartDropdown) {
                    // Toggle mini-cart visibility
                    cartToggle.addEventListener('click', function(e) {
                        e.preventDefault();
                        miniCartDropdown.classList.toggle('hidden');
                        
                        // Only fetch cart items when opening the dropdown
                        if (!miniCartDropdown.classList.contains('hidden')) {
                            loadMiniCartItems();
                        }
                    });
                    
                    // Close mini-cart when clicking outside
                    document.addEventListener('click', function(e) {
                        if (!cartToggle.contains(e.target) && !miniCartDropdown.contains(e.target)) {
                            miniCartDropdown.classList.add('hidden');
                        }
                    });
                }
                
                // Load mini-cart items
                function loadMiniCartItems() {
                    fetch('{{ route('cart.mini') }}')
                        .then(response => response.json())
                        .then(data => {
                            const miniCartItems = document.querySelector('.mini-cart-items');
                            const miniCartEmpty = document.querySelector('.mini-cart-empty');
                            const miniCartSubtotal = document.querySelector('.mini-cart-subtotal');
                            
                            // Clear existing items
                            miniCartItems.innerHTML = '';
                            
                            if (data.cart_count > 0) {
                                // Hide empty cart message
                                miniCartEmpty.classList.add('hidden');
                                
                                // Create and append cart items
                                data.cart_items.forEach(item => {
                                    const itemElement = document.createElement('div');
                                    itemElement.className = 'flex items-center p-4 border-b border-gray-200';
                                    itemElement.innerHTML = `
                                        <div class="flex-shrink-0 w-12 h-12 bg-gray-100 rounded-md overflow-hidden mr-4">
                                            ${item.image ? `<img src="${item.image}" alt="${item.name}" class="w-full h-full object-cover">` : 
                                            '<div class="w-full h-full flex items-center justify-center text-gray-400"><i class="fas fa-box"></i></div>'}
                                        </div>
                                        <div class="flex-grow">
                                            <h4 class="text-sm font-medium">${item.name}</h4>
                                            <div class="flex items-center justify-between">
                                                <span class="text-xs text-gray-500">${item.quantity} × $${item.price}</span>
                                                <span class="text-sm font-medium">$${item.total}</span>
                                            </div>
                                        </div>
                                        <button class="ml-2 text-gray-400 hover:text-red-600 mini-cart-remove-item" data-id="${item.id}">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    `;
                                    miniCartItems.appendChild(itemElement);
                                });
                                
                                // Setup remove buttons
                                document.querySelectorAll('.mini-cart-remove-item').forEach(btn => {
                                    btn.addEventListener('click', function() {
                                        const itemId = this.getAttribute('data-id');
                                        removeCartItem(itemId);
                                    });
                                });
                                
                                // Update subtotal
                                miniCartSubtotal.textContent = '$' + data.cart_subtotal;
                            } else {
                                // Show empty cart message
                                miniCartEmpty.classList.remove('hidden');
                                miniCartItems.appendChild(miniCartEmpty);
                                
                                // Update subtotal
                                miniCartSubtotal.textContent = '$0.00';
                            }
                        })
                        .catch(error => {
                            console.error('Error loading mini-cart:', error);
                        });
                }
                
                // Function to remove cart item
                function removeCartItem(itemId) {
                    fetch(`/cart/${itemId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update cart count in header
                            const cartCounter = document.querySelector('.cart-counter');
                            if (cartCounter) {
                                cartCounter.textContent = data.cart_count;
                                
                                if (data.cart_count > 0) {
                                    cartCounter.classList.remove('hidden');
                                } else {
                                    cartCounter.classList.add('hidden');
                                }
                            }
                            
                            // Reload mini-cart items
                            loadMiniCartItems();
                        }
                    })
                    .catch(error => {
                        console.error('Error removing item:', error);
                    });
                }
            });
        </script>
        
        @stack('scripts')
    </body>
</html>