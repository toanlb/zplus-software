@extends('layouts.app')

@section('title', 'Shopping Cart')

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
                        <span class="text-gray-500 text-sm">Shopping Cart</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>
</section>

<!-- Cart Content -->
<section class="py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-8">Shopping Cart</h1>
        
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if($cartItems->count() > 0)
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Cart Items -->
                <div class="w-full lg:w-2/3">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($cartItems as $item)
                                    <tr class="cart-item" data-id="{{ $item->id }}">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-16 w-16 bg-gray-100 rounded-md overflow-hidden">
                                                    @if($item->product && $item->product->thumbnail)
                                                        <img src="{{ asset('storage/' . $item->product->thumbnail) }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                            <i class="fas fa-box text-2xl"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <h3 class="text-sm font-medium text-gray-900">{{ $item->name }}</h3>
                                                    @if($item->options && count($item->options) > 0)
                                                        <div class="text-xs text-gray-500 mt-1">
                                                            @foreach($item->options as $key => $value)
                                                                <span>{{ ucfirst($key) }}: {{ $value }}</span>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center text-sm text-gray-500">${{ number_format($item->price, 2) }}</td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center justify-center">
                                                <button type="button" class="quantity-btn" data-action="decrease">
                                                    <i class="fas fa-minus text-gray-500 hover:text-blue-600"></i>
                                                </button>
                                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" 
                                                       class="item-quantity mx-2 border-gray-300 rounded-md text-center w-16 focus:ring-blue-500 focus:border-blue-500">
                                                <button type="button" class="quantity-btn" data-action="increase">
                                                    <i class="fas fa-plus text-gray-500 hover:text-blue-600"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center text-sm font-medium text-gray-900 item-total">
                                            ${{ number_format($item->price * $item->quantity, 2) }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <button type="button" class="remove-item text-red-600 hover:text-red-900" data-id="{{ $item->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="flex justify-between mb-8">
                        <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i> Continue Shopping
                        </a>
                        <button id="clear-cart" class="inline-flex items-center px-4 py-2 bg-red-100 text-red-700 rounded-md hover:bg-red-200 transition-colors">
                            <i class="fas fa-trash mr-2"></i> Clear Cart
                        </button>
                    </div>
                </div>

                <!-- Cart Summary -->
                <div class="w-full lg:w-1/3">
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-6">
                        <h2 class="text-lg font-bold mb-6 pb-4 border-b border-gray-200">Order Summary</h2>
                        
                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-medium cart-subtotal">${{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Shipping</span>
                                <span class="font-medium">$0.00</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tax</span>
                                <span class="font-medium">$0.00</span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between pt-4 border-t border-gray-200">
                            <span class="text-lg font-bold">Total</span>
                            <span class="text-lg font-bold cart-total">${{ number_format($subtotal, 2) }}</span>
                        </div>
                        
                        <a href="{{ route('checkout.index') }}" class="block text-center mt-6 px-4 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                            Proceed to Checkout
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <div class="text-gray-400 mb-4">
                    <i class="fas fa-shopping-cart text-5xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-2">Your cart is empty</h3>
                <p class="text-gray-600 mb-6">Looks like you haven't added any products to your cart yet.</p>
                <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-all duration-200">
                    Browse Products
                </a>
            </div>
        @endif
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Update quantity when +/- buttons are clicked
        document.querySelectorAll('.quantity-btn').forEach(button => {
            button.addEventListener('click', function() {
                const input = this.parentElement.querySelector('input.item-quantity');
                const action = this.getAttribute('data-action');
                
                let value = parseInt(input.value);
                if (action === 'increase') {
                    value = value + 1;
                } else if (action === 'decrease' && value > 1) {
                    value = value - 1;
                }
                
                input.value = value;
                updateCartItem(input);
            });
        });

        // Update quantity when input is changed
        document.querySelectorAll('input.item-quantity').forEach(input => {
            input.addEventListener('change', function() {
                updateCartItem(this);
            });
        });

        // Remove item from cart
        document.querySelectorAll('.remove-item').forEach(button => {
            button.addEventListener('click', function() {
                const itemId = this.getAttribute('data-id');
                removeCartItem(itemId);
            });
        });

        // Clear entire cart
        document.getElementById('clear-cart').addEventListener('click', function() {
            if (confirm('Are you sure you want to clear your cart?')) {
                clearCart();
            }
        });

        // Function to update cart item
        function updateCartItem(input) {
            const itemRow = input.closest('.cart-item');
            const itemId = itemRow.getAttribute('data-id');
            const quantity = input.value;

            fetch(`/cart/${itemId}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    quantity: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update item total
                    itemRow.querySelector('.item-total').textContent = '$' + data.item_total;
                    
                    // Update cart subtotal and total
                    document.querySelector('.cart-subtotal').textContent = '$' + data.cart_subtotal;
                    document.querySelector('.cart-total').textContent = '$' + data.cart_subtotal;
                    
                    // Update cart count in header
                    updateCartCount(data.cart_count);
                }
            });
        }

        // Function to remove cart item
        function removeCartItem(itemId) {
            fetch(`/cart/${itemId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove the item row
                    document.querySelector(`.cart-item[data-id="${itemId}"]`).remove();
                    
                    // Update cart subtotal and total
                    document.querySelector('.cart-subtotal').textContent = '$' + data.cart_subtotal;
                    document.querySelector('.cart-total').textContent = '$' + data.cart_subtotal;
                    
                    // Update cart count in header
                    updateCartCount(data.cart_count);
                    
                    // If no more items, refresh the page to show empty cart message
                    if (data.cart_count === 0) {
                        window.location.reload();
                    }
                }
            });
        }

        // Function to clear cart
        function clearCart() {
            fetch('/cart/clear', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Refresh the page to show empty cart message
                    window.location.reload();
                }
            });
        }

        // Function to update cart count in header
        function updateCartCount(count) {
            const cartCounter = document.querySelector('.cart-counter');
            if (cartCounter) {
                cartCounter.textContent = count;
                
                // Show/hide based on count
                if (count > 0) {
                    cartCounter.classList.remove('hidden');
                } else {
                    cartCounter.classList.add('hidden');
                }
            }
        }
    });
</script>
@endpush