@extends('layouts.app')

@section('title', __('contact.contact_title'))

@section('content')
    <!-- Contact Header Section -->
    <section class="bg-blue-600 py-16 text-white">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-4xl font-bold mb-4">{{ __('contact.contact_title') }}</h1>
                <p class="text-xl text-blue-100">{{ __('contact.contact_subtitle') }}</p>
            </div>
        </div>
    </section>
    
    <!-- Contact Content Section -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap -mx-4">
                <!-- Contact Form Column -->
                <div class="w-full lg:w-2/3 px-4 mb-8 lg:mb-0">
                    <div class="bg-white rounded-lg shadow-md p-8">
                        <h2 class="text-2xl font-bold mb-6">{{ __('contact.send_message') }}</h2>
                        
                        @if(session('success'))
                            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                                <span class="block sm:inline">{{ session('success') }}</span>
                            </div>
                        @endif
                        
                        <form action="{{ route('contact.submit') }}" method="POST">
                            @csrf
                            
                            <div class="mb-6">
                                <label for="name" class="block text-gray-700 font-medium mb-2">{{ __('contact.your_name') }} <span class="text-red-600">*</span></label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="mb-6">
                                <label for="email" class="block text-gray-700 font-medium mb-2">{{ __('contact.your_email') }} <span class="text-red-600">*</span></label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="mb-6">
                                <label for="phone" class="block text-gray-700 font-medium mb-2">{{ __('contact.your_phone') }}</label>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('phone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="mb-6">
                                <label for="subject" class="block text-gray-700 font-medium mb-2">{{ __('contact.subject') }} <span class="text-red-600">*</span></label>
                                <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('subject')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="mb-6">
                                <label for="message" class="block text-gray-700 font-medium mb-2">{{ __('contact.your_message') }} <span class="text-red-600">*</span></label>
                                <textarea id="message" name="message" rows="6" required class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('message') }}</textarea>
                                @error('message')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="mb-6">
                                <label class="flex items-center">
                                    <input type="checkbox" name="privacy_policy" value="1" required class="h-5 w-5 text-blue-600 rounded focus:ring-blue-500">
                                    <span class="ml-2 text-gray-700">
                                        {!! __('contact.privacy_policy_agreement', ['url' => route('privacy')]) !!}
                                    </span>
                                </label>
                                @error('privacy_policy')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <button type="submit" class="bg-blue-600 text-white font-medium py-3 px-6 rounded-md hover:bg-blue-700 transition-colors">
                                    {{ __('contact.send_message') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Contact Info Column -->
                <div class="w-full lg:w-1/3 px-4">
                    <!-- Contact Information -->
                    <div class="bg-white rounded-lg shadow-md p-8 mb-6">
                        <h3 class="text-xl font-bold mb-4">{{ __('contact.contact_information') }}</h3>
                        
                        <div class="space-y-4">
                            <div class="flex">
                                <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-medium text-gray-900">{{ __('contact.address') }}</h4>
                                    <p class="mt-1 text-gray-600">
                                        123 Business Street<br>
                                        New York, NY 10001<br>
                                        United States
                                    </p>
                                </div>
                            </div>
                            
                            <div class="flex">
                                <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-medium text-gray-900">{{ __('contact.phone') }}</h4>
                                    <p class="mt-1 text-gray-600">
                                        <a href="tel:+11234567890" class="hover:text-blue-600">+1 (123) 456-7890</a>
                                    </p>
                                </div>
                            </div>
                            
                            <div class="flex">
                                <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-medium text-gray-900">{{ __('contact.email') }}</h4>
                                    <p class="mt-1 text-gray-600">
                                        <a href="mailto:info@example.com" class="hover:text-blue-600">info@example.com</a>
                                    </p>
                                </div>
                            </div>
                            
                            <div class="flex">
                                <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-medium text-gray-900">{{ __('contact.business_hours') }}</h4>
                                    <p class="mt-1 text-gray-600">
                                        {{ __('contact.monday_friday') }}: 9:00 AM - 5:00 PM<br>
                                        {{ __('contact.saturday') }}: 10:00 AM - 2:00 PM<br>
                                        {{ __('contact.sunday') }}: {{ __('contact.closed') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Social Media Links -->
                    <div class="bg-white rounded-lg shadow-md p-8">
                        <h3 class="text-xl font-bold mb-4">{{ __('contact.connect_with_us') }}</h3>
                        
                        <div class="flex space-x-3">
                            <a href="#" class="bg-blue-600 text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-blue-700">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="bg-blue-400 text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-blue-500">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="bg-red-600 text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-red-700">
                                <i class="fab fa-youtube"></i>
                            </a>
                            <a href="#" class="bg-pink-600 text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-pink-700">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="bg-blue-800 text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-blue-900">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Google Map -->
            <div class="mt-12">
                <div class="bg-white rounded-lg shadow-md p-2">
                    <div class="h-96 w-full rounded-md overflow-hidden">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d193595.15830869428!2d-74.11976397304903!3d40.69766374874431!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c259a9b3117469%3A0xd134e199a405a163!2sEmpire%20State%20Building!5e0!3m2!1sen!2sus!4v1651582413533!5m2!1sen!2sus" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- FAQ Section -->
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-3xl font-bold text-center mb-8">{{ __('contact.frequently_asked_questions') }}</h2>
                
                <div class="space-y-4">
                    <div class="bg-white rounded-lg shadow-md p-6" x-data="{ open: false }">
                        <button @click="open = !open" class="flex justify-between items-center w-full text-left">
                            <h3 class="text-lg font-medium text-gray-900">{{ __('contact.faq_question_1') }}</h3>
                            <span x-show="!open" class="text-blue-600"><i class="fas fa-plus"></i></span>
                            <span x-show="open" class="text-blue-600"><i class="fas fa-minus"></i></span>
                        </button>
                        <div x-show="open" class="mt-4 text-gray-600">
                            <p>{{ __('contact.faq_answer_1') }}</p>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow-md p-6" x-data="{ open: false }">
                        <button @click="open = !open" class="flex justify-between items-center w-full text-left">
                            <h3 class="text-lg font-medium text-gray-900">{{ __('contact.faq_question_2') }}</h3>
                            <span x-show="!open" class="text-blue-600"><i class="fas fa-plus"></i></span>
                            <span x-show="open" class="text-blue-600"><i class="fas fa-minus"></i></span>
                        </button>
                        <div x-show="open" class="mt-4 text-gray-600">
                            <p>{{ __('contact.faq_answer_2') }}</p>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow-md p-6" x-data="{ open: false }">
                        <button @click="open = !open" class="flex justify-between items-center w-full text-left">
                            <h3 class="text-lg font-medium text-gray-900">{{ __('contact.faq_question_3') }}</h3>
                            <span x-show="!open" class="text-blue-600"><i class="fas fa-plus"></i></span>
                            <span x-show="open" class="text-blue-600"><i class="fas fa-minus"></i></span>
                        </button>
                        <div x-show="open" class="mt-4 text-gray-600">
                            <p>{{ __('contact.faq_answer_3') }}</p>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow-md p-6" x-data="{ open: false }">
                        <button @click="open = !open" class="flex justify-between items-center w-full text-left">
                            <h3 class="text-lg font-medium text-gray-900">{{ __('contact.faq_question_4') }}</h3>
                            <span x-show="!open" class="text-blue-600"><i class="fas fa-plus"></i></span>
                            <span x-show="open" class="text-blue-600"><i class="fas fa-minus"></i></span>
                        </button>
                        <div x-show="open" class="mt-4 text-gray-600">
                            <p>{{ __('contact.faq_answer_4') }}</p>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow-md p-6" x-data="{ open: false }">
                        <button @click="open = !open" class="flex justify-between items-center w-full text-left">
                            <h3 class="text-lg font-medium text-gray-900">{{ __('contact.faq_question_5') }}</h3>
                            <span x-show="!open" class="text-blue-600"><i class="fas fa-plus"></i></span>
                            <span x-show="open" class="text-blue-600"><i class="fas fa-minus"></i></span>
                        </button>
                        <div x-show="open" class="mt-4 text-gray-600">
                            <p>{{ __('contact.faq_answer_5') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection