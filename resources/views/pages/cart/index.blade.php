@extends('layouts.app')

@section('title', __('cart.cart_title'))

@section('content')
    <!-- Cart Header Section -->
    <section class="bg-blue-600 py-16 text-white">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-4xl font-bold mb-4">{{ __('cart.cart_title') }}</h1>
                <p class="text-xl text-blue-100">{{ __('cart.cart_subtitle') }}</p>
            </div>
        </div>
    </section>
    
    <!-- Cart Content Section -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <!-- Empty Cart Message -->
            @if($cartItems->isEmpty())
                <div class="bg-white rounded-lg shadow-md p-8 text-center">
                    <div class="text-6xl text-gray-300 mb-6">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ __('cart.empty_cart') }}</h2>
                    <p class="text-gray-600 mb-6">{{ __('cart.continue_shopping_message') }}</p>
                    <a href="{{ route('products.index') }}" class="inline-block bg-blue-600 text-white font-medium px-6 py-3 rounded-md hover:bg-blue-700 transition-colors">
                        {{ __('cart.continue_shopping') }}
                    </a>
                </div>
            @else
                <div class="flex flex-wrap -mx-4">
                    <!-- Cart Items Column -->
                    <div class="w-full lg:w-2/3 px-4 mb-8 lg:mb-0">
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="p-6 border-b border-gray-200">
                                <h2 class="text-2xl font-bold">{{ __('cart.cart_items') }}</h2>
                            </div>
                            
                            <!-- Cart Items Table -->
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                {{ __('cart.product') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                {{ __('cart.price') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                {{ __('cart.quantity') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                {{ __('cart.subtotal') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                <!-- Actions -->
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($cartItems as $item)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-16 w-16 bg-gray-100 rounded-md overflow-hidden">
                                                            @if($item->product && $item->product->featured_image)
                                                                <img src="{{ asset($item->product->featured_image) }}" alt="{{ $item->product->name }}" class="h-full w-full object-cover">
                                                            @else
                                                                <div class="h-full w-full flex items-center justify-center">
                                                                    <i class="fas fa-box text-gray-400"></i>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-gray-900">
                                                                @if($item->product)
                                                                    <a href="{{ route('products.show', $item->product->slug) }}" class="hover:text-blue-600">
                                                                        {{ $item->product->name }}
                                                                    </a>
                                                                @else
                                                                    <span class="text-red-500">{{ __('cart.product_unavailable') }}</span>
                                                                @endif
                                                            </div>
                                                            @if($item->product && $item->product->sku)
                                                                <div class="text-xs text-gray-500">
                                                                    {{ __('cart.sku') }}: {{ $item->product->sku }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">
                                                        @if($item->product)
                                                            @if($item->product->sale_price && $item->product->sale_price < $item->product->regular_price)
                                                                <span class="text-gray-400 line-through text-xs mr-1">${{ number_format($item->product->regular_price, 2) }}</span>
                                                                <span>${{ number_format($item->product->sale_price, 2) }}</span>
                                                            @else
                                                                <span>${{ number_format($item->product->price, 2) }}</span>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                                    <form action="{{ route('cart.update') }}" method="POST" class="flex items-center justify-center">
                                                        @csrf
                                                        <input type="hidden" name="cart_item_id" value="{{ $item->id }}">
                                                        <div class="flex items-center border border-gray-300 rounded-md w-24">
                                                            <button type="button" class="px-3 py-1 bg-gray-100 text-gray-600 hover:bg-gray-200 quantity-decrease">
                                                                <i class="fas fa-minus text-xs"></i>
                                                            </button>
                                                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="99" class="w-full px-2 py-1 text-center focus:outline-none text-sm">
                                                            <button type="button" class="px-3 py-1 bg-gray-100 text-gray-600 hover:bg-gray-200 quantity-increase">
                                                                <i class="fas fa-plus text-xs"></i>
                                                            </button>
                                                        </div>
                                                        <button type="submit" class="ml-2 text-blue-600 hover:text-blue-800">
                                                            <i class="fas fa-sync-alt"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    @if($item->product)
                                                        <span>${{ number_format($item->total, 2) }}</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <form action="{{ route('cart.remove') }}" method="POST" class="inline-block">
                                                        @csrf
                                                        <input type="hidden" name="cart_item_id" value="{{ $item->id }}">
                                                        <button type="submit" class="text-red-600 hover:text-red-900" title="{{ __('cart.remove_item') }}">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Cart Actions -->
                            <div class="p-6 border-t border-gray-200 flex justify-between">
                                <a href="{{ route('products.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-arrow-left mr-2"></i>
                                    {{ __('cart.continue_shopping') }}
                                </a>
                                
                                <form action="{{ route('cart.clear') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center text-red-600 hover:text-red-800">
                                        <i class="fas fa-trash mr-2"></i>
                                        {{ __('cart.clear_cart') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Cart Summary Column -->
                    <div class="w-full lg:w-1/3 px-4">
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="p-6 border-b border-gray-200">
                                <h2 class="text-2xl font-bold">{{ __('cart.cart_summary') }}</h2>
                            </div>
                            
                            <div class="p-6">
                                <div class="space-y-4">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">{{ __('cart.subtotal') }}</span>
                                        <span class="font-medium">${{ number_format($subtotal, 2) }}</span>
                                    </div>
                                    
                                    @if($discount > 0)
                                        <div class="flex justify-between text-green-600">
                                            <span>{{ __('cart.discount') }}</span>
                                            <span>-${{ number_format($discount, 2) }}</span>
                                        </div>
                                    @endif
                                    
                                    @if($tax > 0)
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">{{ __('cart.tax') }} ({{ $taxRate }}%)</span>
                                            <span>${{ number_format($tax, 2) }}</span>
                                        </div>
                                    @endif
                                    
                                    <div class="border-t border-gray-200 pt-4 mt-4">
                                        <div class="flex justify-between font-bold text-lg">
                                            <span>{{ __('cart.total') }}</span>
                                            <span>${{ number_format($total, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Discount Code Form -->
                                <div class="mt-6 pt-6 border-t border-gray-200">
                                    <h3 class="text-lg font-medium mb-4">{{ __('cart.discount_code') }}</h3>
                                    <form action="{{ route('cart.apply-coupon') }}" method="POST">
                                        @csrf
                                        <div class="flex">
                                            <input type="text" name="coupon_code" placeholder="{{ __('cart.enter_discount_code') }}" class="flex-grow border border-gray-300 rounded-l-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-r-md hover:bg-blue-700 transition-colors">
                                                {{ __('cart.apply') }}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                
                                <!-- Checkout Button -->
                                <div class="mt-6">
                                    <a href="{{ route('checkout.index') }}" class="block w-full bg-blue-600 text-white font-medium text-center py-3 rounded-md hover:bg-blue-700 transition-colors">
                                        {{ __('cart.proceed_to_checkout') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Accepted Payment Methods -->
                        <div class="mt-6 bg-white rounded-lg shadow-md p-6">
                            <h3 class="text-lg font-medium mb-4">{{ __('cart.accepted_payment_methods') }}</h3>
                            <div class="flex flex-wrap gap-3 text-3xl text-gray-400">
                                <i class="fab fa-cc-visa"></i>
                                <i class="fab fa-cc-mastercard"></i>
                                <i class="fab fa-cc-amex"></i>
                                <i class="fab fa-cc-discover"></i>
                                <i class="fab fa-cc-paypal"></i>
                                <i class="fab fa-cc-apple-pay"></i>
                            </div>
                            <p class="mt-4 text-sm text-gray-600">
                                {{ __('cart.secure_checkout_message') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Quantity adjustment buttons
        document.querySelectorAll('.quantity-decrease').forEach(button => {
            button.addEventListener('click', function() {
                const input = this.parentNode.querySelector('input[name="quantity"]');
                const value = parseInt(input.value);
                if (value > 1) {
                    input.value = value - 1;
                }
            });
        });
        
        document.querySelectorAll('.quantity-increase').forEach(button => {
            button.addEventListener('click', function() {
                const input = this.parentNode.querySelector('input[name="quantity"]');
                const value = parseInt(input.value);
                if (value < parseInt(input.max)) {
                    input.value = value + 1;
                }
            });
        });
    });
</script>
@endpush