@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-20">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row items-center">
                <div class="lg:w-1/2 mb-10 lg:mb-0">
                    <h1 class="text-4xl md:text-5xl font-bold mb-6 leading-tight">Innovative Software Solutions for Your Business</h1>
                    <p class="text-xl mb-8 text-blue-100">We create powerful software that helps businesses streamline operations, improve productivity, and achieve their goals.</p>
                    <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                        <a href="{{ route('products.index') }}" class="bg-white text-blue-600 hover:bg-gray-100 font-semibold rounded-md px-6 py-3 text-center transition-all duration-200">Explore Products</a>
                        <a href="{{ route('contact') }}" class="bg-transparent border-2 border-white hover:bg-white hover:text-blue-600 text-white font-semibold rounded-md px-6 py-3 text-center transition-all duration-200">Contact Us</a>
                    </div>
                </div>
                <div class="lg:w-1/2 lg:pl-10">
                    <img src="img/solution.png" alt="Software Solution" class="rounded-lg shadow-xl w-full">
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-4">Our Featured Products</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Discover our range of powerful software solutions designed to meet your business needs and drive growth.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Product 1 -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden transition-transform duration-300 hover:transform hover:scale-105">
                    <div class="h-48 bg-blue-600 flex items-center justify-center text-white">
                        <i class="fas fa-chart-line text-5xl"></i>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Z+ Analytics Suite</h3>
                        <p class="text-gray-600 mb-4">Powerful analytics tools to help you understand your data and make informed business decisions.</p>
                        <a href="#" class="text-blue-600 hover:text-blue-800 font-medium inline-flex items-center">
                            Learn more
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <!-- Product 2 -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden transition-transform duration-300 hover:transform hover:scale-105">
                    <div class="h-48 bg-green-600 flex items-center justify-center text-white">
                        <i class="fas fa-users text-5xl"></i>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Z+ CRM Solution</h3>
                        <p class="text-gray-600 mb-4">Comprehensive customer relationship management system to streamline interactions and boost sales.</p>
                        <a href="#" class="text-blue-600 hover:text-blue-800 font-medium inline-flex items-center">
                            Learn more
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <!-- Product 3 -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden transition-transform duration-300 hover:transform hover:scale-105">
                    <div class="h-48 bg-purple-600 flex items-center justify-center text-white">
                        <i class="fas fa-tasks text-5xl"></i>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Z+ Project Manager</h3>
                        <p class="text-gray-600 mb-4">Advanced project management tools to keep your teams organized and projects on track.</p>
                        <a href="#" class="text-blue-600 hover:text-blue-800 font-medium inline-flex items-center">
                            Learn more
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-12">
                <a href="{{ route('products.index') }}" class="inline-flex items-center px-6 py-3 border border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white font-medium rounded-md transition-all duration-200">
                    View All Products
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>
    
    <!-- Why Choose Us -->
    <section class="bg-gray-100 py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-4">Why Choose Z+ Software?</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">We're dedicated to providing high-quality software solutions with exceptional customer service.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <div class="text-blue-600 mb-4">
                        <i class="fas fa-code text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Cutting-Edge Technology</h3>
                    <p class="text-gray-600">We use the latest technologies and best practices to ensure our software is fast, secure, and scalable.</p>
                </div>
                
                <!-- Feature 2 -->
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <div class="text-blue-600 mb-4">
                        <i class="fas fa-user-shield text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Security Focused</h3>
                    <p class="text-gray-600">Your data security is our priority. All our solutions are built with the highest security standards.</p>
                </div>
                
                <!-- Feature 3 -->
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <div class="text-blue-600 mb-4">
                        <i class="fas fa-headset text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">24/7 Support</h3>
                    <p class="text-gray-600">Our dedicated support team is available round the clock to address any issues or questions you may have.</p>
                </div>
                
                <!-- Feature 4 -->
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <div class="text-blue-600 mb-4">
                        <i class="fas fa-sync text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Regular Updates</h3>
                    <p class="text-gray-600">We continuously improve our software with regular updates, new features, and security patches.</p>
                </div>
                
                <!-- Feature 5 -->
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <div class="text-blue-600 mb-4">
                        <i class="fas fa-coins text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Cost-Effective Solutions</h3>
                    <p class="text-gray-600">Our products offer excellent value for your investment, with competitive pricing and flexible options.</p>
                </div>
                
                <!-- Feature 6 -->
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <div class="text-blue-600 mb-4">
                        <i class="fas fa-hands-helping text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Customer-Centric Approach</h3>
                    <p class="text-gray-600">We listen to our customers and develop solutions that address their specific needs and challenges.</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Featured Projects -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-4">Our Featured Projects</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Take a look at some of the successful projects we've delivered for our clients across various industries.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Project 1 -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <img src="img/e-commerce.png" alt="E-commerce Platform" class="w-full h-64 object-cover">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-xl font-bold">E-commerce Platform</h3>
                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">Web Development</span>
                        </div>
                        <p class="text-gray-600 mb-4">Custom e-commerce solution for a leading retail brand with integrated inventory management and CRM.</p>
                        <a href="#" class="text-blue-600 hover:text-blue-800 font-medium inline-flex items-center">
                            View Case Study
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <!-- Project 2 -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <img src="img/app.png" alt="Finance Management App" class="w-full h-64 object-cover">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-xl font-bold">Finance Management App</h3>
                            <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">Mobile App</span>
                        </div>
                        <p class="text-gray-600 mb-4">Comprehensive mobile banking solution with advanced security features and intuitive user experience.</p>
                        <a href="#" class="text-blue-600 hover:text-blue-800 font-medium inline-flex items-center">
                            View Case Study
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-12">
                <a href="{{ route('projects.index') }}" class="inline-flex items-center px-6 py-3 border border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white font-medium rounded-md transition-all duration-200">
                    View All Projects
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>
    
    <!-- Testimonials -->
    <section class="bg-blue-600 py-16 text-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-4">What Our Clients Say</h2>
                <p class="text-blue-100 max-w-2xl mx-auto">Hear from businesses that have experienced the impact of our software solutions.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-white rounded-lg shadow-lg p-6 text-gray-800">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-500 flex">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <p class="italic mb-4">"Z+ Software transformed our business operations with their CRM solution. The implementation was smooth, and the support has been excellent."</p>
                    <div class="flex items-center">
                        <img src="img/client.png" alt="Client" class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <p class="font-bold">John Doe</p>
                            <p class="text-sm text-gray-600">CEO, TechCorp Inc.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial 2 -->
                <div class="bg-white rounded-lg shadow-lg p-6 text-gray-800">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-500 flex">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <p class="italic mb-4">"The analytics suite provided by Z+ Software has given us insights that were previously inaccessible. It's been a game-changer for our strategic planning."</p>
                    <div class="flex items-center">
                        <img src="img/client.png" alt="Client" class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <p class="font-bold">Jane Smith</p>
                            <p class="text-sm text-gray-600">CTO, GlobalData Systems</p>
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial 3 -->
                <div class="bg-white rounded-lg shadow-lg p-6 text-gray-800">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-500 flex">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                    <p class="italic mb-4">"The project management software from Z+ has significantly improved our team's productivity and collaboration. Highly recommended!"</p>
                    <div class="flex items-center">
                        <img src="img/client.png" alt="Client" class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <p class="font-bold">Robert Johnson</p>
                            <p class="text-sm text-gray-600">Project Manager, InnovateTech</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Call to Action -->
    <section class="py-20">
        <div class="container mx-auto px-4">
            <div class="bg-gray-900 rounded-xl text-white text-center p-12">
                <h2 class="text-3xl font-bold mb-4">Ready to Transform Your Business?</h2>
                <p class="text-gray-300 max-w-2xl mx-auto mb-8">Get in touch today to discover how our software solutions can help you achieve your business goals.</p>
                <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('products.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md px-8 py-3 transition-all duration-200">Explore Products</a>
                    <a href="{{ route('contact') }}" class="bg-white text-blue-600 hover:bg-gray-100 font-semibold rounded-md px-8 py-3 transition-all duration-200">Contact Us</a>
                </div>
            </div>
        </div>
    </section>
@endsection