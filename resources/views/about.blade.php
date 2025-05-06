@extends('layouts.app')

@section('title', __('about.about_title'))

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6">{{ __('about.about_title') }}</h1>
        
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">{{ __('about.our_story') }}</h2>
            <p class="text-gray-600 mb-4">
                Z Plus was founded with a simple mission: to provide high-quality digital products to help businesses and individuals succeed in the digital world. Our team of experts is dedicated to creating innovative solutions that meet the needs of our diverse customer base.
            </p>
            <p class="text-gray-600 mb-4">
                Since our inception, we've been committed to excellence, customer satisfaction, and continuous improvement. We believe in building long-term relationships with our customers and providing them with the support they need to get the most out of our products.
            </p>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">{{ __('about.our_values') }}</h2>
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-xl font-medium text-blue-600 mb-2">Quality</h3>
                    <p class="text-gray-600">
                        We are committed to delivering products of the highest quality, thoroughly tested and continuously improved.
                    </p>
                </div>
                <div>
                    <h3 class="text-xl font-medium text-blue-600 mb-2">Innovation</h3>
                    <p class="text-gray-600">
                        We constantly explore new technologies and approaches to create better solutions for our customers.
                    </p>
                </div>
                <div>
                    <h3 class="text-xl font-medium text-blue-600 mb-2">{{ __('about.our_mission') }}</h3>
                    <p class="text-gray-600">
                        We listen to our customers and design our products to meet their specific needs.
                    </p>
                </div>
                <div>
                    <h3 class="text-xl font-medium text-blue-600 mb-2">Support</h3>
                    <p class="text-gray-600">
                        We provide outstanding support to ensure our customers can fully utilize our products.
                    </p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">{{ __('about.our_team') }}</h2>
            <p class="text-gray-600 mb-6">
                {{ __('about.team_description') }}
            </p>
            
            <div class="grid md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="w-24 h-24 mx-auto rounded-full bg-gray-200 flex items-center justify-center mb-3">
                        <span class="text-gray-500 text-2xl">JD</span>
                    </div>
                    <h3 class="font-medium text-gray-800">John Doe</h3>
                    <p class="text-sm text-gray-500">{{ __('about.founder') }} & {{ __('about.ceo') }}</p>
                </div>
                <div class="text-center">
                    <div class="w-24 h-24 mx-auto rounded-full bg-gray-200 flex items-center justify-center mb-3">
                        <span class="text-gray-500 text-2xl">JS</span>
                    </div>
                    <h3 class="font-medium text-gray-800">Jane Smith</h3>
                    <p class="text-sm text-gray-500">Lead Developer</p>
                </div>
                <div class="text-center">
                    <div class="w-24 h-24 mx-auto rounded-full bg-gray-200 flex items-center justify-center mb-3">
                        <span class="text-gray-500 text-2xl">RJ</span>
                    </div>
                    <h3 class="font-medium text-gray-800">Robert Johnson</h3>
                    <p class="text-sm text-gray-500">Customer Success</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection