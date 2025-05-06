<!-- Mini Cart Dropdown -->
<div id="mini-cart-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg z-50 overflow-hidden border border-gray-200">
    <div class="p-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold">{{ __('cart.your_cart') }}</h3>
    </div>

    <div class="mini-cart-items max-h-60 overflow-y-auto">
        <!-- Cart items will be loaded here via JavaScript -->
        <div class="mini-cart-empty py-6 text-center text-gray-500 hidden">
            <i class="fas fa-shopping-cart text-3xl mb-2"></i>
            <p>{{ __('cart.cart_empty') }}</p>
        </div>
    </div>

    <div class="p-4 border-t border-gray-200">
        <div class="flex justify-between font-medium mb-4">
            <span>{{ __('cart.subtotal') }}:</span>
            <span class="mini-cart-subtotal">$0.00</span>
        </div>
        <a href="{{ route('cart.index') }}" class="block text-center bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition-colors mb-2">
            {{ __('cart.view_cart') }}
        </a>
        <a href="{{ route('checkout.index') }}" class="block text-center bg-green-600 text-white py-2 rounded-md hover:bg-green-700 transition-colors">
            {{ __('cart.checkout') }}
        </a>
    </div>
</div>