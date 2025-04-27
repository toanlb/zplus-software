@extends('layouts.app')

@section('title', 'Customer Dashboard')

@section('content')
<!-- Dashboard Header -->
<section class="bg-blue-600 py-10 text-white">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Welcome, {{ Auth::user()->name }}</h1>
                <p>Manage your account, track orders, and download your purchases</p>
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
        <!-- Dashboard Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <!-- Orders Card -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="bg-blue-100 p-3 rounded-full">
                        <i class="fas fa-shopping-cart text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-bold">My Orders</h3>
                        <p class="text-gray-500">Track your purchases</p>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('customer.orders') }}" class="text-blue-600 hover:underline flex items-center font-medium">
                        View All Orders
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Downloads Card -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="bg-green-100 p-3 rounded-full">
                        <i class="fas fa-download text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-bold">Downloads</h3>
                        <p class="text-gray-500">Access your digital products</p>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('customer.downloads') }}" class="text-green-600 hover:underline flex items-center font-medium">
                        View All Downloads
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Profile Card -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="bg-purple-100 p-3 rounded-full">
                        <i class="fas fa-user text-purple-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-bold">My Profile</h3>
                        <p class="text-gray-500">Update your information</p>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('customer.profile') }}" class="text-purple-600 hover:underline flex items-center font-medium">
                        Edit Profile
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Recent Orders -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b">
                        <h3 class="text-lg font-bold">Recent Orders</h3>
                    </div>
                    <div class="p-6">
                        @if(isset($recentOrders) && $recentOrders->count() > 0)
                            <div class="space-y-4">
                                @foreach($recentOrders as $order)
                                    <div class="border-b border-gray-200 pb-4 last:border-0 last:pb-0">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <h4 class="font-medium">Order #{{ $order->id }}</h4>
                                                <p class="text-sm text-gray-600">{{ $order->created_at->format('M d, Y') }}</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="font-bold">${{ number_format($order->total, 2) }}</p>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    @if($order->status === 'completed') bg-green-100 text-green-800
                                                    @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                                    @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                                                    @else bg-yellow-100 text-yellow-800
                                                    @endif">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-6">
                                <a href="{{ route('customer.orders') }}" class="text-blue-600 hover:underline flex items-center font-medium justify-center">
                                    View All Orders
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <div class="text-gray-400 mb-4">
                                    <i class="fas fa-shopping-bag text-4xl"></i>
                                </div>
                                <h3 class="text-lg font-bold mb-2">No Orders Yet</h3>
                                <p class="text-gray-600 mb-6">You haven't placed any orders yet.</p>
                                <a href="#" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-all duration-200">
                                    Browse Products
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Recent Downloads -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b">
                        <h3 class="text-lg font-bold">Recent Downloads</h3>
                    </div>
                    <div class="p-6">
                        @if(isset($downloads) && $downloads->count() > 0)
                            <div class="space-y-4">
                                @foreach($downloads as $item)
                                    <div class="border-b border-gray-200 pb-4 last:border-0 last:pb-0">
                                        <h4 class="font-medium">{{ $item->product->name }}</h4>
                                        <p class="text-sm text-gray-600">
                                            {{ $item->download_count ?? 0 }} / {{ $item->download_limit ?? 'Unlimited' }} downloads
                                        </p>
                                        @if((!$item->download_limit || $item->download_count < $item->download_limit) && 
                                            (!$item->download_expiry || now()->lessThan($item->download_expiry)))
                                            <a href="{{ route('customer.download', ['item' => $item->id, 'token' => $item->download_token]) }}" 
                                                class="text-sm text-blue-600 hover:underline flex items-center mt-2">
                                                <i class="fas fa-download mr-1"></i> Download
                                            </a>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-6">
                                <a href="{{ route('customer.downloads') }}" class="text-blue-600 hover:underline flex items-center font-medium justify-center">
                                    View All Downloads
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <div class="text-gray-400 mb-4">
                                    <i class="fas fa-file-download text-4xl"></i>
                                </div>
                                <h3 class="text-lg font-bold mb-2">No Downloads</h3>
                                <p class="text-gray-600">Purchase digital products to see downloads here.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection