@extends('layouts.app')

@section('title', 'About Us')

@section('content')
    <!-- Hero Section -->
    <section class="bg-blue-600 text-white py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-6">About Z+ Software</h1>
                <p class="text-xl text-blue-100">Learn about our company history, our dedicated team, and the values that drive everything we do.</p>
            </div>
        </div>
    </section>
    
    <!-- Company Overview -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row items-center gap-12">
                <div class="lg:w-1/2">
                    <img src="img/office.jpg" alt="Company Office" class="rounded-lg shadow-lg w-full">
                </div>
                <div class="lg:w-1/2">
                    <h2 class="text-3xl font-bold mb-6">Our Story</h2>
                    <p class="text-gray-600 mb-6">Z+ Software was founded in 2010 with a vision to create innovative software solutions that empower businesses to achieve their full potential. What began as a small team of passionate developers has grown into a leading software company with clients across the globe.</p>
                    <p class="text-gray-600 mb-6">Over the years, we've evolved our offerings to meet the changing needs of businesses in an increasingly digital world. From custom software development to our suite of ready-to-use products, we've maintained our commitment to quality, innovation, and customer satisfaction.</p>
                    <p class="text-gray-600">Today, Z+ Software is trusted by businesses of all sizes, from startups to Fortune 500 companies, to deliver software solutions that drive growth and success.</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Mission and Vision -->
    <section class="py-16 bg-gray-100">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold mb-4">Our Mission & Vision</h2>
                    <p class="text-gray-600">The guiding principles that shape our work and drive our success.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Mission -->
                    <div class="bg-white p-8 rounded-lg shadow-md">
                        <div class="text-blue-600 mb-4">
                            <i class="fas fa-bullseye text-4xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-4">Our Mission</h3>
                        <p class="text-gray-600">To empower businesses with innovative software solutions that solve real-world problems, enhance productivity, and drive sustainable growth.</p>
                    </div>
                    
                    <!-- Vision -->
                    <div class="bg-white p-8 rounded-lg shadow-md">
                        <div class="text-blue-600 mb-4">
                            <i class="fas fa-eye text-4xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-4">Our Vision</h3>
                        <p class="text-gray-600">To be the global leader in software solutions, recognized for our innovation, quality, and commitment to helping businesses succeed in the digital era.</p>
                    </div>
                </div>
                
                <!-- Values -->
                <div class="mt-12">
                    <h3 class="text-2xl font-bold mb-6 text-center">Our Core Values</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="bg-white p-6 rounded-lg shadow-md text-center">
                            <div class="text-blue-600 mb-3">
                                <i class="fas fa-lightbulb text-3xl"></i>
                            </div>
                            <h4 class="text-lg font-bold mb-2">Innovation</h4>
                            <p class="text-gray-600">We continually push the boundaries of what's possible in software development.</p>
                        </div>
                        
                        <div class="bg-white p-6 rounded-lg shadow-md text-center">
                            <div class="text-blue-600 mb-3">
                                <i class="fas fa-award text-3xl"></i>
                            </div>
                            <h4 class="text-lg font-bold mb-2">Excellence</h4>
                            <p class="text-gray-600">We are committed to delivering the highest quality in every aspect of our work.</p>
                        </div>
                        
                        <div class="bg-white p-6 rounded-lg shadow-md text-center">
                            <div class="text-blue-600 mb-3">
                                <i class="fas fa-users text-3xl"></i>
                            </div>
                            <h4 class="text-lg font-bold mb-2">Collaboration</h4>
                            <p class="text-gray-600">We believe in the power of teamwork and partnerships to achieve exceptional results.</p>
                        </div>
                        
                        <div class="bg-white p-6 rounded-lg shadow-md text-center">
                            <div class="text-blue-600 mb-3">
                                <i class="fas fa-lock text-3xl"></i>
                            </div>
                            <h4 class="text-lg font-bold mb-2">Integrity</h4>
                            <p class="text-gray-600">We conduct our business with honesty, transparency, and strong ethical principles.</p>
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
                <h2 class="text-3xl font-bold mb-4">Meet Our Leadership Team</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Our experienced and passionate leadership team drives our innovation and success.</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Team Member 1 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="img/ceo.jpg" alt="CEO" class="w-full h-80 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-1">John Mitchell</h3>
                        <p class="text-blue-600 mb-3">CEO & Founder</p>
                        <p class="text-gray-600 mb-4">With over 20 years of experience in the software industry, John leads our company with vision and strategic direction.</p>
                        <div class="flex space-x-3">
                            <a href="#" class="text-gray-400 hover:text-blue-600"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" class="text-gray-400 hover:text-blue-600"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="text-gray-400 hover:text-blue-600"><i class="fas fa-envelope"></i></a>
                        </div>
                    </div>
                </div>
                
                <!-- Team Member 2 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="img/cto.jpg" alt="CTO" class="w-full h-80 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-1">Sarah Johnson</h3>
                        <p class="text-blue-600 mb-3">Chief Technology Officer</p>
                        <p class="text-gray-600 mb-4">Sarah oversees our technical strategy and ensures we stay at the forefront of software development innovations.</p>
                        <div class="flex space-x-3">
                            <a href="#" class="text-gray-400 hover:text-blue-600"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" class="text-gray-400 hover:text-blue-600"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="text-gray-400 hover:text-blue-600"><i class="fas fa-envelope"></i></a>
                        </div>
                    </div>
                </div>
                
                <!-- Team Member 3 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="img/coo.jpg" alt="COO" class="w-full h-80 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-1">Michael Lee</h3>
                        <p class="text-blue-600 mb-3">Chief Operating Officer</p>
                        <p class="text-gray-600 mb-4">Michael ensures our day-to-day operations run smoothly and efficiently, allowing us to deliver exceptional service.</p>
                        <div class="flex space-x-3">
                            <a href="#" class="text-gray-400 hover:text-blue-600"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" class="text-gray-400 hover:text-blue-600"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="text-gray-400 hover:text-blue-600"><i class="fas fa-envelope"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-12">
                <p class="text-gray-600 max-w-2xl mx-auto mb-8">Our team extends beyond our leadership to include talented developers, designers, project managers, and support staff who all contribute to our success and the success of our clients.</p>
                <a href="{{ route('contact') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 transition-all duration-200">
                    Join Our Team
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
                <h2 class="text-3xl font-bold mb-4">Our Achievements</h2>
                <p class="text-gray-300 max-w-2xl mx-auto">We're proud of what we've accomplished since our founding.</p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 max-w-4xl mx-auto">
                <div class="text-center">
                    <div class="text-4xl font-bold text-blue-400 mb-2">13+</div>
                    <p class="text-gray-300">Years in Business</p>
                </div>
                
                <div class="text-center">
                    <div class="text-4xl font-bold text-blue-400 mb-2">500+</div>
                    <p class="text-gray-300">Projects Completed</p>
                </div>
                
                <div class="text-center">
                    <div class="text-4xl font-bold text-blue-400 mb-2">200+</div>
                    <p class="text-gray-300">Happy Clients</p>
                </div>
                
                <div class="text-center">
                    <div class="text-4xl font-bold text-blue-400 mb-2">50+</div>
                    <p class="text-gray-300">Team Members</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Our Offices -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-4">Our Offices</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">With offices in key locations, we're well-positioned to serve clients around the world.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Office 1 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="https://via.placeholder.com/400x250?text=Headquarters" alt="Headquarters" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Headquarters</h3>
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
                    <img src="https://via.placeholder.com/400x250?text=Europe+Office" alt="Europe Office" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Europe Office</h3>
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
                    <img src="https://via.placeholder.com/400x250?text=Asia+Office" alt="Asia Office" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Asia Office</h3>
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
            <h2 class="text-3xl font-bold mb-6">Ready to Work With Us?</h2>
            <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">Whether you're looking for a software solution or interested in joining our team, we'd love to hear from you.</p>
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                <a href="{{ route('contact') }}" class="bg-white text-blue-600 hover:bg-gray-100 font-semibold rounded-md px-8 py-3 transition-all duration-200">Contact Us</a>
                <a href="#" class="bg-transparent border-2 border-white hover:bg-white hover:text-blue-600 text-white font-semibold rounded-md px-8 py-3 transition-all duration-200">View Our Work</a>
            </div>
        </div>
    </section>
@endsection