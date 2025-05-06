@extends('layouts.app')

@section('title', __('user.login_title'))

@section('content')
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-8">
            <h1 class="text-2xl font-bold mb-6 text-center">{{ __('user.login_title') }}</h1>
            
            @if (session('status'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <!-- Email Address -->
                <div class="mb-6">
                    <label for="email" class="block text-gray-700 font-medium mb-2">{{ __('user.email') }}</label>
                    <input type="email" name="email" id="email" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 @error('email') border-red-500 @enderror" value="{{ old('email') }}" required autofocus>
                    
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-gray-700 font-medium mb-2">{{ __('user.password') }}</label>
                    <input type="password" name="password" id="password" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 @error('password') border-red-500 @enderror" required>
                    
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Remember Me -->
                <div class="mb-6">
                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember" class="mr-2" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember" class="text-gray-700">{{ __('user.remember_me') }}</label>
                    </div>
                </div>
                
                <div class="flex items-center justify-between mb-6">
                    <button type="submit" class="bg-blue-600 text-white py-2 px-6 rounded-md hover:bg-blue-700 transition-all duration-200 font-semibold">
                        {{ __('general.login') }}
                    </button>
                    
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                            {{ __('user.forgot_password') }}
                        </a>
                    @endif
                </div>
                
                <div class="text-center">
                    <p class="text-gray-600 text-sm">{{ __('user.no_account') }} <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800">{{ __('user.create_account') }}</a></p>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
