@extends('layouts.app')

@section('title', 'Order Complete')

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
                        <span class="text-gray-500 text-sm">Order Complete</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>
</section>

<!-- Order Complete Content -->
<section class="py-12">
    <div class="container mx-auto px-4 max-w-4xl">
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-md p-8 text-center mb-8">
            <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-green-100 text-green-600 mb-6">
                <i class="fas fa-check text-2xl"></i>
            </div>
            
            <h1 class="text-3xl font-bold mb-2">Thank You For Your Order!</h1>
            <p class="text-gray-600 mb-6">Order #{{ $order->order_number }} has been placed successfully.</p>
            
            <div class="flex flex-col md:flex-row items-center justify-center space-y-4 md:space-y-0 md:space-x-4">
                @if(Auth::check())
                    <a href="{{ route('customer.orders') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                        <i class="fas fa-box mr-2"></i> View Your Orders
                    </a>
                @endif
                
                <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-colors">
                    <i class="fas fa-shopping-bag mr-2"></i> Continue Shopping
                </a>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="border-b border-gray-200 p-6">
                <h2 class="text-xl font-bold">Order Details</h2>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h3 class="font-semibold text-gray-700 mb-2">Order Information</h3>
                        <p class="mb-1"><span class="font-medium">Order Number:</span> #{{ $order->order_number }}</p>
                        <p class="mb-1"><span class="font-medium">Date:</span> {{ $order->created_at->format('F d, Y') }}</p>
                        <p class="mb-1"><span class="font-medium">Status:</span> 
                            @if($order->status === 'pending')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Pending
                                </span>
                            @elseif($order->status === 'paid')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Paid
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ ucfirst($order->status) }}
                                </span>
                            @endif
                        </p>
                        <p class="mb-1"><span class="font-medium">Payment Method:</span> {{ ucfirst($order->payment_method) }}</p>
                    </div>
                    
                    <div>
                        <h3 class="font-semibold text-gray-700 mb-2">Customer Information</h3>
                        <p class="mb-1"><span class="font-medium">Name:</span> {{ $order->name }}</p>
                        <p class="mb-1"><span class="font-medium">Email:</span> {{ $order->email }}</p>
                        @if($order->phone)
                            <p class="mb-1"><span class="font-medium">Phone:</span> {{ $order->phone }}</p>
                        @endif
                    </div>
                </div>
                
                <!-- Order Items -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="font-semibold text-gray-700 mb-4">Order Items</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($order->items as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 bg-gray-200 rounded-md overflow-hidden">
                                                @if($item->product && $item->product->thumbnail)
                                                    <img src="{{ asset('storage/' . $item->product->thumbnail) }}" alt="{{ $item->product ? $item->product->name : 'Product' }}" class="h-full w-full object-cover">
                                                @else
                                                    <div class="h-full w-full flex items-center justify-center text-gray-400">
                                                        <i class="fas fa-box"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $item->product ? $item->product->name : 'Product unavailable' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                        ${{ number_format($item->price, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                        {{ $item->quantity }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        ${{ number_format($item->price * $item->quantity, 2) }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-right text-sm font-medium text-gray-500">Subtotal</td>
                                    <td class="px-6 py-4 text-right text-sm font-medium">${{ number_format($order->total_price, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-right text-sm font-medium text-gray-500">Tax</td>
                                    <td class="px-6 py-4 text-right text-sm font-medium">$0.00</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-right text-sm font-medium text-gray-900">Total</td>
                                    <td class="px-6 py-4 text-right text-sm font-bold">${{ number_format($order->total_price, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                
                @if($order->items->whereHas('product', function($query) { return $query->where('download_link', '!=', null); })->count() > 0 && $order->isPaid())
                    <div class="mt-8 border-t border-gray-200 pt-6">
                        <h3 class="font-semibold text-gray-700 mb-4">Digital Downloads</h3>
                        
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-info-circle text-blue-400"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-700">
                                        Your downloads are available. You can access them in your <a href="{{ route('customer.downloads') }}" class="font-medium underline">downloads section</a>.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                
                @if($order->status === 'pending')
                    <div class="mt-8 border-t border-gray-200 pt-6">
                        <h3 class="font-semibold text-gray-700 mb-4">Payment</h3>
                        
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-yellow-700">
                                        Your payment is pending. Please complete your payment to access your digital purchases.
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <form action="{{ route('checkout.confirm-payment', ['order' => $order->id]) }}" method="POST">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                                    <i class="fas fa-credit-card mr-2"></i> Complete Payment
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Next Steps -->
        <div class="mt-8 text-center">
            <h2 class="text-xl font-bold mb-4">What's Next?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="text-blue-600 text-4xl mb-4">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h3 class="font-bold mb-2">Check Your Email</h3>
                    <p class="text-gray-600 text-sm">
                        We've sent a confirmation email to {{ $order->email }} with your order details.
                    </p>
                </div>
                
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="text-blue-600 text-4xl mb-4">
                        <i class="fas fa-download"></i>
                    </div>
                    <h3 class="font-bold mb-2">Access Your Downloads</h3>
                    <p class="text-gray-600 text-sm">
                        After payment, digital products are available in your downloads section.
                    </p>
                </div>
                
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="text-blue-600 text-4xl mb-4">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3 class="font-bold mb-2">Get Support</h3>
                    <p class="text-gray-600 text-sm">
                        Need help? Our support team is ready to assist you with any questions.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection