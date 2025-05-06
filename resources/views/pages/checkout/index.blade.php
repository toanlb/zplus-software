@extends('layouts.app')

@section('title', __('checkout.checkout_title'))

@section('content')
    <!-- Checkout Header Section -->
    <section class="bg-blue-600 py-16 text-white">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-4xl font-bold mb-4">{{ __('checkout.checkout_title') }}</h1>
                <p class="text-xl text-blue-100">{{ __('checkout.checkout_subtitle') }}</p>
            </div>
        </div>
    </section>
    
    <!-- Checkout Content Section -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <!-- Checkout Steps -->
            <div class="mb-8">
                <div class="flex flex-wrap text-center">
                    <div class="w-1/3">
                        <div class="relative">
                            <div class="h-3 bg-blue-600 rounded-l-full"></div>
                            <div class="absolute inset-x-0 top-0 -mt-4 flex justify-center">
                                <div class="bg-blue-600 text-white w-10 h-10 rounded-full flex items-center justify-center font-semibold">
                                    1
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 text-blue-600 font-medium">{{ __('checkout.information') }}</div>
                    </div>
                    <div class="w-1/3">
                        <div class="relative">
                            <div class="h-3 bg-gray-300"></div>
                            <div class="absolute inset-x-0 top-0 -mt-4 flex justify-center">
                                <div class="bg-gray-300 text-gray-600 w-10 h-10 rounded-full flex items-center justify-center font-semibold">
                                    2
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 text-gray-500">{{ __('checkout.payment') }}</div>
                    </div>
                    <div class="w-1/3">
                        <div class="relative">
                            <div class="h-3 bg-gray-300 rounded-r-full"></div>
                            <div class="absolute inset-x-0 top-0 -mt-4 flex justify-center">
                                <div class="bg-gray-300 text-gray-600 w-10 h-10 rounded-full flex items-center justify-center font-semibold">
                                    3
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 text-gray-500">{{ __('checkout.confirmation') }}</div>
                    </div>
                </div>
            </div>
            
            <!-- Checkout Form and Summary -->
            <div class="flex flex-wrap -mx-4">
                <!-- Checkout Form Column -->
                <div class="w-full lg:w-2/3 px-4 mb-8 lg:mb-0">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
                            @csrf
                            
                            <!-- Contact Information -->
                            <div class="mb-8">
                                <h2 class="text-2xl font-bold mb-4">{{ __('checkout.contact_information') }}</h2>
                                
                                <div class="mb-4">
                                    <label for="email" class="block text-gray-700 font-medium mb-2">{{ __('checkout.email_address') }} <span class="text-red-600">*</span></label>
                                    <input type="email" id="email" name="email" value="{{ auth()->user()->email ?? old('email') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    @error('email')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="phone" class="block text-gray-700 font-medium mb-2">{{ __('checkout.phone_number') }} <span class="text-red-600">*</span></label>
                                    <input type="tel" id="phone" name="phone" value="{{ auth()->user()->phone ?? old('phone') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    @error('phone')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Billing Information -->
                            <div class="mb-8">
                                <h2 class="text-2xl font-bold mb-4">{{ __('checkout.billing_information') }}</h2>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label for="first_name" class="block text-gray-700 font-medium mb-2">{{ __('checkout.first_name') }} <span class="text-red-600">*</span></label>
                                        <input type="text" id="first_name" name="first_name" value="{{ auth()->user()->first_name ?? old('first_name') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        @error('first_name')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="last_name" class="block text-gray-700 font-medium mb-2">{{ __('checkout.last_name') }} <span class="text-red-600">*</span></label>
                                        <input type="text" id="last_name" name="last_name" value="{{ auth()->user()->last_name ?? old('last_name') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        @error('last_name')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="address" class="block text-gray-700 font-medium mb-2">{{ __('checkout.address') }} <span class="text-red-600">*</span></label>
                                    <input type="text" id="address" name="address" value="{{ auth()->user()->address ?? old('address') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    @error('address')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="address_2" class="block text-gray-700 font-medium mb-2">{{ __('checkout.address_2') }} <span class="text-gray-500 font-normal">({{ __('checkout.optional') }})</span></label>
                                    <input type="text" id="address_2" name="address_2" value="{{ auth()->user()->address_2 ?? old('address_2') }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                    <div>
                                        <label for="city" class="block text-gray-700 font-medium mb-2">{{ __('checkout.city') }} <span class="text-red-600">*</span></label>
                                        <input type="text" id="city" name="city" value="{{ auth()->user()->city ?? old('city') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        @error('city')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="state" class="block text-gray-700 font-medium mb-2">{{ __('checkout.state') }} <span class="text-red-600">*</span></label>
                                        <input type="text" id="state" name="state" value="{{ auth()->user()->state ?? old('state') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        @error('state')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="zip" class="block text-gray-700 font-medium mb-2">{{ __('checkout.zip_code') }} <span class="text-red-600">*</span></label>
                                        <input type="text" id="zip" name="zip" value="{{ auth()->user()->zip ?? old('zip') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        @error('zip')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="country" class="block text-gray-700 font-medium mb-2">{{ __('checkout.country') }} <span class="text-red-600">*</span></label>
                                    <select id="country" name="country" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">{{ __('checkout.select_country') }}</option>
                                        <option value="US" {{ (auth()->user()->country ?? old('country')) == 'US' ? 'selected' : '' }}>United States</option>
                                        <option value="CA" {{ (auth()->user()->country ?? old('country')) == 'CA' ? 'selected' : '' }}>Canada</option>
                                        <option value="GB" {{ (auth()->user()->country ?? old('country')) == 'GB' ? 'selected' : '' }}>United Kingdom</option>
                                        <option value="AU" {{ (auth()->user()->country ?? old('country')) == 'AU' ? 'selected' : '' }}>Australia</option>
                                        <!-- Add more countries as needed -->
                                    </select>
                                    @error('country')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Order Notes -->
                            <div class="mb-8">
                                <h2 class="text-2xl font-bold mb-4">{{ __('checkout.order_notes') }}</h2>
                                
                                <div class="mb-4">
                                    <label for="notes" class="block text-gray-700 font-medium mb-2">{{ __('checkout.notes_placeholder') }} <span class="text-gray-500 font-normal">({{ __('checkout.optional') }})</span></label>
                                    <textarea id="notes" name="notes" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('notes') }}</textarea>
                                </div>
                            </div>
                            
                            <!-- Checkbox Options -->
                            <div class="mb-8">
                                <div class="mb-4">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="create_account" value="1" {{ old('create_account') ? 'checked' : '' }} class="h-5 w-5 text-blue-600 rounded focus:ring-blue-500">
                                        <span class="ml-2 text-gray-700">{{ __('checkout.create_account') }}</span>
                                    </label>
                                </div>
                                
                                <div class="mb-4">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="different_shipping" value="1" {{ old('different_shipping') ? 'checked' : '' }} id="different-shipping-checkbox" class="h-5 w-5 text-blue-600 rounded focus:ring-blue-500">
                                        <span class="ml-2 text-gray-700">{{ __('checkout.different_shipping') }}</span>
                                    </label>
                                </div>
                                
                                <div id="shipping-address-container" class="mt-6 hidden">
                                    <h3 class="text-lg font-bold mb-4">{{ __('checkout.shipping_address') }}</h3>
                                    
                                    <!-- Shipping address fields will be shown/hidden based on the checkbox -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <label for="shipping_first_name" class="block text-gray-700 font-medium mb-2">{{ __('checkout.first_name') }} <span class="text-red-600">*</span></label>
                                            <input type="text" id="shipping_first_name" name="shipping_first_name" value="{{ old('shipping_first_name') }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        </div>
                                        
                                        <div>
                                            <label for="shipping_last_name" class="block text-gray-700 font-medium mb-2">{{ __('checkout.last_name') }} <span class="text-red-600">*</span></label>
                                            <input type="text" id="shipping_last_name" name="shipping_last_name" value="{{ old('shipping_last_name') }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="shipping_address" class="block text-gray-700 font-medium mb-2">{{ __('checkout.address') }} <span class="text-red-600">*</span></label>
                                        <input type="text" id="shipping_address" name="shipping_address" value="{{ old('shipping_address') }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="shipping_address_2" class="block text-gray-700 font-medium mb-2">{{ __('checkout.address_2') }} <span class="text-gray-500 font-normal">({{ __('checkout.optional') }})</span></label>
                                        <input type="text" id="shipping_address_2" name="shipping_address_2" value="{{ old('shipping_address_2') }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                        <div>
                                            <label for="shipping_city" class="block text-gray-700 font-medium mb-2">{{ __('checkout.city') }} <span class="text-red-600">*</span></label>
                                            <input type="text" id="shipping_city" name="shipping_city" value="{{ old('shipping_city') }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        </div>
                                        
                                        <div>
                                            <label for="shipping_state" class="block text-gray-700 font-medium mb-2">{{ __('checkout.state') }} <span class="text-red-600">*</span></label>
                                            <input type="text" id="shipping_state" name="shipping_state" value="{{ old('shipping_state') }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        </div>
                                        
                                        <div>
                                            <label for="shipping_zip" class="block text-gray-700 font-medium mb-2">{{ __('checkout.zip_code') }} <span class="text-red-600">*</span></label>
                                            <input type="text" id="shipping_zip" name="shipping_zip" value="{{ old('shipping_zip') }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="shipping_country" class="block text-gray-700 font-medium mb-2">{{ __('checkout.country') }} <span class="text-red-600">*</span></label>
                                        <select id="shipping_country" name="shipping_country" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="">{{ __('checkout.select_country') }}</option>
                                            <option value="US" {{ old('shipping_country') == 'US' ? 'selected' : '' }}>United States</option>
                                            <option value="CA" {{ old('shipping_country') == 'CA' ? 'selected' : '' }}>Canada</option>
                                            <option value="GB" {{ old('shipping_country') == 'GB' ? 'selected' : '' }}>United Kingdom</option>
                                            <option value="AU" {{ old('shipping_country') == 'AU' ? 'selected' : '' }}>Australia</option>
                                            <!-- Add more countries as needed -->
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Submit Button (handled in the Order Summary) -->
                        </form>
                    </div>
                </div>
                
                <!-- Order Summary Column -->
                <div class="w-full lg:w-1/3 px-4">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="p-6 border-b border-gray-200">
                            <h2 class="text-2xl font-bold">{{ __('checkout.order_summary') }}</h2>
                        </div>
                        
                        <div class="p-6">
                            <!-- Order Items -->
                            <div class="mb-6">
                                <h3 class="text-lg font-medium mb-4">{{ __('checkout.items_in_cart') }}</h3>
                                
                                <div class="max-h-64 overflow-y-auto mb-4">
                                    @foreach($cartItems as $item)
                                        <div class="flex mb-4 items-center">
                                            <div class="w-16 h-16 bg-gray-100 rounded-md overflow-hidden flex-shrink-0">
                                                @if($item->product && $item->product->featured_image)
                                                    <img src="{{ asset($item->product->featured_image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                        <i class="fas fa-box"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4 flex-grow">
                                                <h4 class="text-sm font-medium">
                                                    {{ $item->product->name }}
                                                </h4>
                                                <div class="flex justify-between mt-1 text-sm text-gray-500">
                                                    <span>{{ __('checkout.quantity') }}: {{ $item->quantity }}</span>
                                                    <span>${{ number_format($item->total, 2) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            
                            <!-- Order Totals -->
                            <div class="mb-6">
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">{{ __('checkout.subtotal') }}</span>
                                        <span>${{ number_format($subtotal, 2) }}</span>
                                    </div>
                                    
                                    @if($discount > 0)
                                        <div class="flex justify-between text-green-600">
                                            <span>{{ __('checkout.discount') }}</span>
                                            <span>-${{ number_format($discount, 2) }}</span>
                                        </div>
                                    @endif
                                    
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">{{ __('checkout.shipping') }}</span>
                                        <span>${{ number_format($shipping, 2) }}</span>
                                    </div>
                                    
                                    @if($tax > 0)
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">{{ __('checkout.tax') }} ({{ $taxRate }}%)</span>
                                            <span>${{ number_format($tax, 2) }}</span>
                                        </div>
                                    @endif
                                    
                                    <div class="flex justify-between font-bold text-lg pt-2 mt-2 border-t border-gray-200">
                                        <span>{{ __('checkout.total') }}</span>
                                        <span>${{ number_format($total, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Payment Methods (simplified for display) -->
                            <div class="mb-6">
                                <h3 class="text-lg font-medium mb-4">{{ __('checkout.payment_method') }}</h3>
                                
                                <div class="space-y-3">
                                    <label class="block border border-gray-300 rounded-md p-3 cursor-pointer hover:border-blue-500 transition-colors">
                                        <div class="flex items-center">
                                            <input type="radio" name="payment_method" value="credit_card" checked class="h-5 w-5 text-blue-600">
                                            <span class="ml-3 flex items-center">
                                                <i class="far fa-credit-card mr-2 text-gray-600"></i>
                                                <span>{{ __('checkout.credit_card') }}</span>
                                            </span>
                                        </div>
                                    </label>
                                    
                                    <label class="block border border-gray-300 rounded-md p-3 cursor-pointer hover:border-blue-500 transition-colors">
                                        <div class="flex items-center">
                                            <input type="radio" name="payment_method" value="paypal" class="h-5 w-5 text-blue-600">
                                            <span class="ml-3 flex items-center">
                                                <i class="fab fa-paypal mr-2 text-blue-500"></i>
                                                <span>PayPal</span>
                                            </span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Place Order Button -->
                            <div>
                                <button type="submit" form="checkout-form" class="block w-full bg-blue-600 text-white font-medium text-center py-3 rounded-md hover:bg-blue-700 transition-colors">
                                    {{ __('checkout.place_order') }}
                                </button>
                                
                                <p class="mt-4 text-sm text-gray-600 text-center">
                                    {{ __('checkout.agree_to_terms') }} 
                                    <a href="#" class="text-blue-600 hover:underline">{{ __('checkout.terms_conditions') }}</a>.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Secure Checkout -->
                    <div class="mt-6 bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center justify-center text-center">
                            <div>
                                <div class="text-green-600 mb-2">
                                    <i class="fas fa-lock text-2xl"></i>
                                </div>
                                <h3 class="font-medium mb-1">{{ __('checkout.secure_checkout') }}</h3>
                                <p class="text-sm text-gray-600">
                                    {{ __('checkout.safe_payment') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const differentShippingCheckbox = document.getElementById('different-shipping-checkbox');
        const shippingAddressContainer = document.getElementById('shipping-address-container');
        
        function toggleShippingAddress() {
            if (differentShippingCheckbox.checked) {
                shippingAddressContainer.classList.remove('hidden');
                // Add required attribute to shipping fields
                document.querySelectorAll('#shipping-address-container input:not([name="shipping_address_2"])').forEach(input => {
                    input.setAttribute('required', '');
                });
            } else {
                shippingAddressContainer.classList.add('hidden');
                // Remove required attribute from shipping fields
                document.querySelectorAll('#shipping-address-container input').forEach(input => {
                    input.removeAttribute('required');
                });
            }
        }
        
        // Initial state
        toggleShippingAddress();
        
        // Listen for changes
        differentShippingCheckbox.addEventListener('change', toggleShippingAddress);
    });
</script>
@endpush