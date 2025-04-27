@extends('layouts.app')

@section('title', 'Checkout')

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
                        <a href="{{ route('cart.index') }}" class="text-gray-700 hover:text-blue-600 text-sm">Shopping Cart</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 text-sm mx-1"></i>
                        <span class="text-gray-500 text-sm">Checkout</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>
</section>

<!-- Checkout Content -->
<section class="py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-8">Checkout</h1>
        
        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @csrf
            
            <!-- Customer Information and Shipping -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Customer Information -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold mb-4">Customer Information</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name <span class="text-red-600">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name', Auth::user()->name ?? '') }}" required 
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                            @error('name')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address <span class="text-red-600">*</span></label>
                            <input type="email" name="email" id="email" value="{{ old('email', Auth::user()->email ?? '') }}" required 
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                            @error('email')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                        <input type="tel" name="phone" id="phone" value="{{ old('phone', Auth::user()->phone ?? '') }}" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        @error('phone')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Order Notes (Optional)</label>
                        <textarea name="notes" id="notes" rows="3" 
                                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">{{ old('notes') }}</textarea>
                    </div>
                </div>
                
                <!-- Payment Methods -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold mb-4">Payment Method</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="payment_method" value="credit_card" class="form-radio text-blue-600 h-5 w-5" checked>
                                <span class="ml-2">Credit Card</span>
                                <span class="ml-auto flex space-x-2">
                                    <i class="fab fa-cc-visa text-2xl text-blue-800"></i>
                                    <i class="fab fa-cc-mastercard text-2xl text-red-600"></i>
                                    <i class="fab fa-cc-amex text-2xl text-blue-500"></i>
                                </span>
                            </label>
                            
                            <div class="credit-card-form mt-4 p-4 bg-gray-50 rounded-md">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label for="card_name" class="block text-sm font-medium text-gray-700 mb-1">Name on Card</label>
                                        <input type="text" id="card_name" name="card_name" 
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                    </div>
                                    
                                    <div>
                                        <label for="card_number" class="block text-sm font-medium text-gray-700 mb-1">Card Number</label>
                                        <input type="text" id="card_number" name="card_number" placeholder="**** **** **** ****" 
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                    <div class="col-span-1">
                                        <label for="card_expiry_month" class="block text-sm font-medium text-gray-700 mb-1">Expiration Month</label>
                                        <select id="card_expiry_month" name="card_expiry_month" 
                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                            @foreach(range(1, 12) as $month)
                                                <option value="{{ sprintf('%02d', $month) }}">{{ sprintf('%02d', $month) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="col-span-1">
                                        <label for="card_expiry_year" class="block text-sm font-medium text-gray-700 mb-1">Expiration Year</label>
                                        <select id="card_expiry_year" name="card_expiry_year" 
                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                            @foreach(range(date('Y'), date('Y') + 10) as $year)
                                                <option value="{{ $year }}">{{ $year }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="col-span-1">
                                        <label for="card_cvv" class="block text-sm font-medium text-gray-700 mb-1">CVV</label>
                                        <input type="text" id="card_cvv" name="card_cvv" placeholder="***" 
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                    </div>
                                </div>
                                
                                <p class="mt-4 text-xs text-gray-500">
                                    <i class="fas fa-lock mr-1"></i>
                                    Your payment information is processed securely. We do not store your credit card details.
                                </p>
                            </div>
                        </div>
                        
                        <div>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="payment_method" value="paypal" class="form-radio text-blue-600 h-5 w-5">
                                <span class="ml-2">PayPal</span>
                                <span class="ml-auto">
                                    <i class="fab fa-paypal text-2xl text-blue-700"></i>
                                </span>
                            </label>
                            
                            <div class="paypal-info hidden mt-4 p-4 bg-gray-50 rounded-md">
                                <p class="text-sm text-gray-600">
                                    You will be redirected to PayPal to complete your payment.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold mb-4">Order Summary</h2>
                    
                    <!-- Order Items -->
                    <div class="border-b border-gray-200 pb-4 mb-4">
                        @foreach($cartItems as $item)
                            <div class="flex justify-between py-2">
                                <div>
                                    <span class="font-medium">{{ $item->name }}</span>
                                    <span class="text-gray-500 text-sm block">Qty: {{ $item->quantity }}</span>
                                </div>
                                <span>${{ number_format($item->price * $item->quantity, 2) }}</span>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Order Totals -->
                    <div class="space-y-2 border-b border-gray-200 pb-4 mb-4">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal</span>
                            <span>${{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tax</span>
                            <span>${{ number_format($tax, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Shipping</span>
                            <span>${{ number_format($shipping, 2) }}</span>
                        </div>
                    </div>
                    
                    <!-- Total -->
                    <div class="flex justify-between font-bold text-lg">
                        <span>Total</span>
                        <span>${{ number_format($total, 2) }}</span>
                    </div>
                    
                    <!-- Place Order Button -->
                    <button type="submit" class="w-full mt-6 bg-blue-600 text-white py-3 px-4 rounded-md hover:bg-blue-700 transition-colors">
                        Place Order
                    </button>
                    
                    <p class="mt-4 text-xs text-gray-500 text-center">
                        By placing your order, you agree to our <a href="#" class="text-blue-600 hover:underline">Terms of Service</a> and <a href="#" class="text-blue-600 hover:underline">Privacy Policy</a>
                    </p>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle payment method forms
        const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
        const creditCardForm = document.querySelector('.credit-card-form');
        const paypalInfo = document.querySelector('.paypal-info');
        
        paymentMethods.forEach(method => {
            method.addEventListener('change', function() {
                if (this.value === 'credit_card') {
                    creditCardForm.classList.remove('hidden');
                    paypalInfo.classList.add('hidden');
                } else if (this.value === 'paypal') {
                    creditCardForm.classList.add('hidden');
                    paypalInfo.classList.remove('hidden');
                }
            });
        });
        
        // Credit card formatting
        const cardNumber = document.getElementById('card_number');
        if (cardNumber) {
            cardNumber.addEventListener('input', function() {
                let value = this.value.replace(/\D/g, '');
                if (value.length > 16) {
                    value = value.substr(0, 16);
                }
                
                // Format the number with spaces
                let formattedValue = '';
                for (let i = 0; i < value.length; i++) {
                    if (i > 0 && i % 4 === 0) {
                        formattedValue += ' ';
                    }
                    formattedValue += value[i];
                }
                
                this.value = formattedValue;
            });
        }
        
        // CVV formatting - only allow numbers and max 4 digits
        const cardCvv = document.getElementById('card_cvv');
        if (cardCvv) {
            cardCvv.addEventListener('input', function() {
                let value = this.value.replace(/\D/g, '');
                if (value.length > 4) {
                    value = value.substr(0, 4);
                }
                this.value = value;
            });
        }
    });
</script>
@endpush