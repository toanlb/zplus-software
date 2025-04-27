@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<!-- Dashboard Header -->
<section class="bg-blue-600 py-10 text-white">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">My Profile</h1>
                <p>Manage your account information</p>
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
        <div class="max-w-3xl mx-auto">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b">
                    <h3 class="text-lg font-bold">Account Information</h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('customer.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-gray-700 font-medium mb-2">Full Name</label>
                                <input type="text" name="name" id="name" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 @error('name') border-red-500 @enderror" value="{{ old('name', auth()->user()->name) }}" required>
                                
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
                                <input type="email" name="email" id="email" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 @error('email') border-red-500 @enderror" value="{{ old('email', auth()->user()->email) }}" required>
                                
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Phone Number -->
                            <div>
                                <label for="phone" class="block text-gray-700 font-medium mb-2">Phone Number</label>
                                <input type="tel" name="phone" id="phone" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 @error('phone') border-red-500 @enderror" value="{{ old('phone', auth()->user()->phone ?? '') }}">
                                
                                @error('phone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Company -->
                            <div>
                                <label for="company" class="block text-gray-700 font-medium mb-2">Company (Optional)</label>
                                <input type="text" name="company" id="company" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 @error('company') border-red-500 @enderror" value="{{ old('company', auth()->user()->company ?? '') }}">
                                
                                @error('company')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Address -->
                            <div>
                                <label for="address" class="block text-gray-700 font-medium mb-2">Address</label>
                                <input type="text" name="address" id="address" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 @error('address') border-red-500 @enderror" value="{{ old('address', auth()->user()->address ?? '') }}">
                                
                                @error('address')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- City -->
                            <div>
                                <label for="city" class="block text-gray-700 font-medium mb-2">City</label>
                                <input type="text" name="city" id="city" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 @error('city') border-red-500 @enderror" value="{{ old('city', auth()->user()->city ?? '') }}">
                                
                                @error('city')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                            <!-- State/Province -->
                            <div>
                                <label for="state" class="block text-gray-700 font-medium mb-2">State/Province</label>
                                <input type="text" name="state" id="state" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 @error('state') border-red-500 @enderror" value="{{ old('state', auth()->user()->state ?? '') }}">
                                
                                @error('state')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Postal Code -->
                            <div>
                                <label for="postal_code" class="block text-gray-700 font-medium mb-2">Postal/ZIP Code</label>
                                <input type="text" name="postal_code" id="postal_code" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 @error('postal_code') border-red-500 @enderror" value="{{ old('postal_code', auth()->user()->postal_code ?? '') }}">
                                
                                @error('postal_code')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Country -->
                            <div>
                                <label for="country" class="block text-gray-700 font-medium mb-2">Country</label>
                                <input type="text" name="country" id="country" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 @error('country') border-red-500 @enderror" value="{{ old('country', auth()->user()->country ?? '') }}">
                                
                                @error('country')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mt-6 border-t pt-6">
                            <button type="submit" class="bg-blue-600 text-white py-2 px-6 rounded-md hover:bg-blue-700 transition-all duration-200 font-semibold">
                                Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Change Password Section -->
            <div class="mt-8 bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b">
                    <h3 class="text-lg font-bold">Change Password</h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('customer.password.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Current Password -->
                        <div class="mb-6">
                            <label for="current_password" class="block text-gray-700 font-medium mb-2">Current Password</label>
                            <input type="password" name="current_password" id="current_password" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 @error('current_password') border-red-500 @enderror" required>
                            
                            @error('current_password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- New Password -->
                        <div class="mb-6">
                            <label for="password" class="block text-gray-700 font-medium mb-2">New Password</label>
                            <input type="password" name="password" id="password" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 @error('password') border-red-500 @enderror" required>
                            <p class="text-gray-500 text-sm mt-1">Must be at least 8 characters</p>
                            
                            @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Confirm New Password -->
                        <div class="mb-6">
                            <label for="password_confirmation" class="block text-gray-700 font-medium mb-2">Confirm New Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" required>
                        </div>
                        
                        <div>
                            <button type="submit" class="bg-blue-600 text-white py-2 px-6 rounded-md hover:bg-blue-700 transition-all duration-200 font-semibold">
                                Change Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection