@extends('layouts.app')

@section('title', 'My Downloads')

@section('content')
<!-- Dashboard Header -->
<section class="bg-blue-600 py-10 text-white">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">My Downloads</h1>
                <p>Access your digital product purchases</p>
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
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif
            
            <!-- Downloads -->
            @if(isset($downloadItems) && $downloadItems->count() > 0)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b">
                        <h3 class="text-lg font-bold">Available Downloads</h3>
                    </div>
                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Product
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Order
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Date
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Downloads
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($downloadItems as $item)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10 bg-gray-200 rounded-md overflow-hidden">
                                                        @if(isset($item->product) && $item->product->image)
                                                            <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}" class="h-10 w-10 object-cover">
                                                        @else
                                                            <div class="h-10 w-10 flex items-center justify-center text-gray-400">
                                                                <i class="fas fa-file-alt"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ isset($item->product) ? $item->product->name : 'Product Unavailable' }}
                                                        </div>
                                                        @if(isset($item->product) && $item->product->version)
                                                            <div class="text-sm text-gray-500">
                                                                v{{ $item->product->version }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    #{{ $item->order->id ?? 'N/A' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ isset($item->order) ? $item->order->created_at->format('M d, Y') : 'N/A' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($item->download_limit)
                                                    <span class="text-sm text-gray-700">{{ $item->download_count ?? 0 }} / {{ $item->download_limit }}</span>
                                                @else
                                                    <span class="text-sm text-gray-700">{{ $item->download_count ?? 0 }} / ∞</span>
                                                @endif
                                                
                                                @if($item->download_expiry)
                                                    <div class="text-xs text-gray-500 mt-1">
                                                        @if(now()->lessThan($item->download_expiry))
                                                            Expires: {{ $item->download_expiry->format('M d, Y') }}
                                                        @else
                                                            <span class="text-red-500">Expired: {{ $item->download_expiry->format('M d, Y') }}</span>
                                                        @endif
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                @if((!$item->download_limit || $item->download_count < $item->download_limit) && 
                                                   (!$item->download_expiry || now()->lessThan($item->download_expiry)))
                                                    <a href="{{ route('customer.download', ['item' => $item->id, 'token' => $item->download_token]) }}" 
                                                       class="text-blue-600 hover:text-blue-900 font-medium flex items-center">
                                                        <i class="fas fa-download mr-1"></i> Download
                                                    </a>
                                                @else
                                                    <span class="text-gray-400">
                                                        <i class="fas fa-download mr-1"></i> No longer available
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        @if($downloadItems->hasPages())
                            <div class="mt-4">
                                {{ $downloadItems->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="bg-white rounded-lg shadow-md p-8 text-center">
                    <div class="text-gray-400 mb-4">
                        <i class="fas fa-file-download text-5xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">No Downloads Available</h3>
                    <p class="text-gray-600 mb-6">You don't have any downloadable products yet.</p>
                    <a href="#" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-all duration-200">
                        Browse Products
                    </a>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection