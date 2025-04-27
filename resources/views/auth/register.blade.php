@extends('layouts.app')

@section('title', 'Register')

@section('content')
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-8">
            <h1 class="text-2xl font-bold mb-6 text-center">Create Customer Account</h1>
            
            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <!-- Name -->
                <div class="mb-6">
                    <label for="name" class="block text-gray-700 font-medium mb-2">Full Name</label>
                    <input type="text" name="name" id="name" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 @error('name') border-red-500 @enderror" value="{{ old('name') }}" required autofocus>
                    
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Email Address -->
                <div class="mb-6">
                    <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
                    <input type="email" name="email" id="email" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 @error('email') border-red-500 @enderror" value="{{ old('email') }}" required>
                    
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                    <input type="password" name="password" id="password" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 @error('password') border-red-500 @enderror" required>
                    <p class="text-gray-500 text-sm mt-1">Must be at least 8 characters long</p>
                    
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Confirm Password -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-gray-700 font-medium mb-2">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" required>
                </div>
                
                <div class="mb-6">
                    <button type="submit" class="w-full bg-blue-600 text-white py-2 px-6 rounded-md hover:bg-blue-700 transition-all duration-200 font-semibold">
                        Register
                    </button>
                </div>
                
                <div class="text-center">
                    <p class="text-gray-600 text-sm">Already have an account? <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800">Log in</a></p>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
