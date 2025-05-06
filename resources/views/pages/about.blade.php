@extends('layouts.app')

@section('title', __('about.about_title'))

@section('content')
    <!-- Hero Section -->
    <section class="bg-blue-600 text-white py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-6">{{ __('about.about_company') }}</h1>
                <p class="text-xl text-blue-100">{{ __('about.about_subtitle') }}</p>
            </div>
        </div>
    </section>
    
    <!-- Company Overview -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row items-center gap-12">
                <div class="lg:w-1/2">
                    <img src="img/office.jpg" alt="{{ __('about.company_office') }}" class="rounded-lg shadow-lg w-full">
                </div>
                <div class="lg:w-1/2">
                    <h2 class="text-3xl font-bold mb-6">{{ __('about.our_story') }}</h2>
                    <p class="text-gray-600 mb-6">{{ __('about.story_part1') }}</p>
                    <p class="text-gray-600 mb-6">{{ __('about.story_part2') }}</p>
                    <p class="text-gray-600">{{ __('about.story_part3') }}</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Mission and Vision -->
    <section class="py-16 bg-gray-100">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold mb-4">{{ __('about.mission_vision') }}</h2>
                    <p class="text-gray-600">{{ __('about.mission_vision_subtitle') }}</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Mission -->
                    <div class="bg-white p-8 rounded-lg shadow-md">
                        <div class="text-blue-600 mb-4">
                            <i class="fas fa-bullseye text-4xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-4">{{ __('about.our_mission') }}</h3>
                        <p class="text-gray-600">{{ __('about.mission_description') }}</p>
                    </div>
                    
                    <!-- Vision -->
                    <div class="bg-white p-8 rounded-lg shadow-md">
                        <div class="text-blue-600 mb-4">
                            <i class="fas fa-eye text-4xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-4">{{ __('about.our_vision') }}</h3>
                        <p class="text-gray-600">{{ __('about.vision_description') }}</p>
                    </div>
                </div>
                
                <!-- Values -->
                <div class="mt-12">
                    <h3 class="text-2xl font-bold mb-6 text-center">{{ __('about.core_values') }}</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="bg-white p-6 rounded-lg shadow-md text-center">
                            <div class="text-blue-600 mb-3">
                                <i class="fas fa-lightbulb text-3xl"></i>
                            </div>
                            <h4 class="text-lg font-bold mb-2">{{ __('about.value_innovation') }}</h4>
                            <p class="text-gray-600">{{ __('about.value_innovation_description') }}</p>
                        </div>
                        
                        <div class="bg-white p-6 rounded-lg shadow-md text-center">
                            <div class="text-blue-600 mb-3">
                                <i class="fas fa-award text-3xl"></i>
                            </div>
                            <h4 class="text-lg font-bold mb-2">{{ __('about.value_excellence') }}</h4>
                            <p class="text-gray-600">{{ __('about.value_excellence_description') }}</p>
                        </div>
                        
                        <div class="bg-white p-6 rounded-lg shadow-md text-center">
                            <div class="text-blue-600 mb-3">
                                <i class="fas fa-users text-3xl"></i>
                            </div>
                            <h4 class="text-lg font-bold mb-2">{{ __('about.value_collaboration') }}</h4>
                            <p class="text-gray-600">{{ __('about.value_collaboration_description') }}</p>
                        </div>
                        
                        <div class="bg-white p-6 rounded-lg shadow-md text-center">
                            <div class="text-blue-600 mb-3">
                                <i class="fas fa-lock text-3xl"></i>
                            </div>
                            <h4 class="text-lg font-bold mb-2">{{ __('about.value_integrity') }}</h4>
                            <p class="text-gray-600">{{ __('about.value_integrity_description') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Our Team -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-4">{{ __('about.leadership_team') }}</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">{{ __('about.leadership_team_subtitle') }}</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Team Member 1 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="img/ceo.jpg" alt="{{ __('about.ceo') }}" class="w-full h-80 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-1">John Mitchell</h3>
                        <p class="text-blue-600 mb-3">{{ __('about.ceo_founder') }}</p>
                        <p class="text-gray-600 mb-4">{{ __('about.ceo_description') }}</p>
                        <div class="flex space-x-3">
                            <a href="#" class="text-gray-400 hover:text-blue-600"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" class="text-gray-400 hover:text-blue-600"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="text-gray-400 hover:text-blue-600"><i class="fas fa-envelope"></i></a>
                        </div>
                    </div>
                </div>
                
                <!-- Team Member 2 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="img/cto.jpg" alt="{{ __('about.cto') }}" class="w-full h-80 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-1">Sarah Johnson</h3>
                        <p class="text-blue-600 mb-3">{{ __('about.cto_title') }}</p>
                        <p class="text-gray-600 mb-4">{{ __('about.cto_description') }}</p>
                        <div class="flex space-x-3">
                            <a href="#" class="text-gray-400 hover:text-blue-600"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" class="text-gray-400 hover:text-blue-600"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="text-gray-400 hover:text-blue-600"><i class="fas fa-envelope"></i></a>
                        </div>
                    </div>
                </div>
                
                <!-- Team Member 3 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="img/coo.jpg" alt="{{ __('about.coo') }}" class="w-full h-80 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-1">Michael Lee</h3>
                        <p class="text-blue-600 mb-3">{{ __('about.coo_title') }}</p>
                        <p class="text-gray-600 mb-4">{{ __('about.coo_description') }}</p>
                        <div class="flex space-x-3">
                            <a href="#" class="text-gray-400 hover:text-blue-600"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" class="text-gray-400 hover:text-blue-600"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="text-gray-400 hover:text-blue-600"><i class="fas fa-envelope"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-12">
                <p class="text-gray-600 max-w-2xl mx-auto mb-8">{{ __('about.team_extended_description') }}</p>
                <a href="{{ route('contact') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 transition-all duration-200">
                    {{ __('about.join_team') }}
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>
    
    <!-- Company Stats -->
    <section class="py-16 bg-gray-900 text-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-4">{{ __('about.achievements') }}</h2>
                <p class="text-gray-300 max-w-2xl mx-auto">{{ __('about.achievements_subtitle') }}</p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 max-w-4xl mx-auto">
                <div class="text-center">
                    <div class="text-4xl font-bold text-blue-400 mb-2">13+</div>
                    <p class="text-gray-300">{{ __('about.years_business') }}</p>
                </div>
                
                <div class="text-center">
                    <div class="text-4xl font-bold text-blue-400 mb-2">500+</div>
                    <p class="text-gray-300">{{ __('about.projects_completed') }}</p>
                </div>
                
                <div class="text-center">
                    <div class="text-4xl font-bold text-blue-400 mb-2">200+</div>
                    <p class="text-gray-300">{{ __('about.happy_clients') }}</p>
                </div>
                
                <div class="text-center">
                    <div class="text-4xl font-bold text-blue-400 mb-2">50+</div>
                    <p class="text-gray-300">{{ __('about.team_members') }}</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Our Offices -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-4">{{ __('about.our_offices') }}</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">{{ __('about.offices_subtitle') }}</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Office 1 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="https://via.placeholder.com/400x250?text=Headquarters" alt="{{ __('about.headquarters') }}" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">{{ __('about.headquarters') }}</h3>
                        <div class="flex items-start mb-4">
                            <i class="fas fa-map-marker-alt mt-1 mr-3 text-blue-600"></i>
                            <p class="text-gray-600">123 Software Avenue, Tech District, City 10000</p>
                        </div>
                        <div class="flex items-center mb-4">
                            <i class="fas fa-phone mr-3 text-blue-600"></i>
                            <p class="text-gray-600">+1 234 567 8900</p>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-envelope mr-3 text-blue-600"></i>
                            <p class="text-gray-600">info@zplussoftware.com</p>
                        </div>
                    </div>
                </div>
                
                <!-- Office 2 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="https://via.placeholder.com/400x250?text=Europe+Office" alt="{{ __('about.europe_office') }}" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">{{ __('about.europe_office') }}</h3>
                        <div class="flex items-start mb-4">
                            <i class="fas fa-map-marker-alt mt-1 mr-3 text-blue-600"></i>
                            <p class="text-gray-600">45 Tech Boulevard, Innovation Quarter, London EC2A 4BX</p>
                        </div>
                        <div class="flex items-center mb-4">
                            <i class="fas fa-phone mr-3 text-blue-600"></i>
                            <p class="text-gray-600">+44 20 1234 5678</p>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-envelope mr-3 text-blue-600"></i>
                            <p class="text-gray-600">europe@zplussoftware.com</p>
                        </div>
                    </div>
                </div>
                
                <!-- Office 3 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="https://via.placeholder.com/400x250?text=Asia+Office" alt="{{ __('about.asia_office') }}" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">{{ __('about.asia_office') }}</h3>
                        <div class="flex items-start mb-4">
                            <i class="fas fa-map-marker-alt mt-1 mr-3 text-blue-600"></i>
                            <p class="text-gray-600">888 Digital Tower, Technology Park, Singapore 138634</p>
                        </div>
                        <div class="flex items-center mb-4">
                            <i class="fas fa-phone mr-3 text-blue-600"></i>
                            <p class="text-gray-600">+65 6123 4567</p>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-envelope mr-3 text-blue-600"></i>
                            <p class="text-gray-600">asia@zplussoftware.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Call to Action -->
    <section class="bg-blue-600 py-16 text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-6">{{ __('about.ready_to_work') }}</h2>
            <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">{{ __('about.ready_to_work_subtitle') }}</p>
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                <a href="{{ route('contact') }}" class="bg-white text-blue-600 hover:bg-gray-100 font-semibold rounded-md px-8 py-3 transition-all duration-200">{{ __('about.contact_us') }}</a>
                <a href="#" class="bg-transparent border-2 border-white hover:bg-white hover:text-blue-600 text-white font-semibold rounded-md px-8 py-3 transition-all duration-200">{{ __('about.view_work') }}</a>
            </div>
        </div>
    </section>
@endsection