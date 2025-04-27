@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<!-- Dashboard Header -->
<section class="bg-blue-600 py-10 text-white">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">My Orders</h1>
                <p>View and track your order history</p>
            </div>
            <div>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-transparent border border-white text-white hover:bg-white hover:text-blue-600 py-2 px-4 rounded-md transition-all duration-200">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Dashboard Navigation -->
<section class="bg-gray-100 py-4 border-b">
    <div class="container mx-auto px-4">
        <div class="flex overflow-x-auto whitespace-nowrap pb-1">
            <a href="{{ route('customer.dashboard') }}" class="px-5 py-2 mr-2 rounded-md font-medium {{ request()->routeIs('customer.dashboard') ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-200' }}">
                <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
            </a>
            <a href="{{ route('customer.orders') }}" class="px-5 py-2 mr-2 rounded-md font-medium {{ request()->routeIs('customer.orders') ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-200' }}">
                <i class="fas fa-shopping-cart mr-2"></i> My Orders
            </a>
            <a href="{{ route('customer.downloads') }}" class="px-5 py-2 mr-2 rounded-md font-medium {{ request()->routeIs('customer.downloads') ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-200' }}">
                <i class="fas fa-download mr-2"></i> Downloads
            </a>
            <a href="{{ route('customer.profile') }}" class="px-5 py-2 rounded-md font-medium {{ request()->routeIs('customer.profile') ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-200' }}">
                <i class="fas fa-user mr-2"></i> My Profile
            </a>
        </div>
    </div>
</section>

<!-- Dashboard Content -->
<section class="py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Orders -->
            @if(isset($orders) && $orders->count() > 0)
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                    <div class="bg-gray-50 px-6 py-4 border-b">
                        <h3 class="text-lg font-bold">Order History</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-8">
                            @foreach($orders as $order)
                                <div class="border-b border-gray-200 pb-8 last:border-b-0 last:pb-0">
                                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
                                        <div>
                                            <h3 class="text-lg font-bold mb-1">Order #{{ $order->id }}</h3>
                                            <p class="text-gray-600 text-sm">
                                                Placed on {{ $order->created_at->format('F j, Y') }}
                                            </p>
                                        </div>
                                        <div class="mt-2 md:mt-0">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                                @if($order->status === 'completed') bg-green-100 text-green-800
                                                @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                                @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                                                @else bg-yellow-100 text-yellow-800
                                                @endif">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <!-- Order Items -->
                                    <div class="bg-gray-50 rounded-md overflow-hidden border">
                                        <div class="divide-y divide-gray-200">
                                            @foreach($order->items as $item)
                                                <div class="flex items-center p-4">
                                                    <div class="flex-shrink-0 w-16 h-16 bg-gray-200 rounded overflow-hidden mr-4">
                                                        @if(isset($item->product) && $item->product->image)
                                                            <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                                        @else
                                                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                                <i class="fas fa-image text-2xl"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="flex-grow">
                                                        <h4 class="font-medium">
                                                            {{ isset($item->product) ? $item->product->name : 'Product Unavailable' }}
                                                        </h4>
                                                        <p class="text-gray-600 text-sm">
                                                            Qty: {{ $item->quantity }} × ${{ number_format($item->price, 2) }}
                                                        </p>
                                                    </div>
                                                    <div class="text-right pl-4">
                                                        <p class="font-bold">${{ number_format($item->quantity * $item->price, 2) }}</p>
                                                        
                                                        @if(isset($item->product) && $item->product->is_downloadable)
                                                            <a href="{{ route('customer.downloads') }}" class="text-sm text-blue-600 hover:underline flex items-center justify-end mt-1">
                                                                <i class="fas fa-download mr-1"></i> Download
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    
                                    <!-- Order Summary -->
                                    <div class="mt-4 flex justify-end">
                                        <div class="w-full max-w-xs">
                                            <table class="w-full text-right">
                                                <tr>
                                                    <td class="py-1 text-gray-600">Subtotal:</td>
                                                    <td class="py-1 pl-4 font-medium">${{ number_format($order->subtotal, 2) }}</td>
                                                </tr>
                                                @if($order->tax_amount > 0)
                                                <tr>
                                                    <td class="py-1 text-gray-600">Tax:</td>
                                                    <td class="py-1 pl-4 font-medium">${{ number_format($order->tax_amount, 2) }}</td>
                                                </tr>
                                                @endif
                                                @if($order->discount_amount > 0)
                                                <tr>
                                                    <td class="py-1 text-gray-600">Discount:</td>
                                                    <td class="py-1 pl-4 font-medium text-green-600">-${{ number_format($order->discount_amount, 2) }}</td>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <td class="py-1 text-gray-600 font-bold">Total:</td>
                                                    <td class="py-1 pl-4 font-bold">${{ number_format($order->total, 2) }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-lg shadow-md p-8 text-center">
                    <div class="text-gray-400 mb-4">
                        <i class="fas fa-shopping-bag text-5xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">No Orders Yet</h3>
                    <p class="text-gray-600 mb-6">You haven't placed any orders yet.</p>
                    <a href="#" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-all duration-200">
                        Browse Products
                    </a>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection