@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-8">
            <h1 class="text-2xl font-bold mb-6 text-center">Reset Password</h1>
            
            @if (session('status'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                
                <p class="text-gray-600 mb-6">Enter your email address and we'll send you a link to reset your password.</p>
                
                <!-- Email Address -->
                <div class="mb-6">
                    <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
                    <input type="email" name="email" id="email" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 @error('email') border-red-500 @enderror" value="{{ old('email') }}" required autofocus>
                    
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-6">
                    <button type="submit" class="w-full bg-blue-600 text-white py-2 px-6 rounded-md hover:bg-blue-700 transition-all duration-200 font-semibold">
                        Send Password Reset Link
                    </button>
                </div>
                
                <div class="text-center">
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                        <i class="fas fa-arrow-left mr-1"></i> Back to login
                    </a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
