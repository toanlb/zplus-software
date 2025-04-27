@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl font-bold mb-4">Contact Us</h1>
            <p class="text-xl text-blue-100">Get in touch with our team for inquiries, support, or partnership opportunities</p>
        </div>
    </div>
</section>

<!-- Contact Information -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Form -->
            <div>
                <h2 class="text-2xl font-bold mb-6">Send us a message</h2>
                
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif
                
                <form action="{{ route('contact') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-gray-700 font-medium mb-2">Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent @error('name') border-red-500 @enderror" required>
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent @error('email') border-red-500 @enderror" required>
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="phone" class="block text-gray-700 font-medium mb-2">Phone Number (Optional)</label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent @error('phone') border-red-500 @enderror">
                            @error('phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="subject" class="block text-gray-700 font-medium mb-2">Subject</label>
                            <select id="subject" name="subject" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent @error('subject') border-red-500 @enderror" required>
                                <option value="">Select a subject</option>
                                <option value="General Inquiry" {{ old('subject') == 'General Inquiry' ? 'selected' : '' }}>General Inquiry</option>
                                <option value="Product Support" {{ old('subject') == 'Product Support' ? 'selected' : '' }}>Product Support</option>
                                <option value="Sales Question" {{ old('subject') == 'Sales Question' ? 'selected' : '' }}>Sales Question</option>
                                <option value="Partnership" {{ old('subject') == 'Partnership' ? 'selected' : '' }}>Partnership Opportunity</option>
                                <option value="Career" {{ old('subject') == 'Career' ? 'selected' : '' }}>Career Information</option>
                                <option value="Other" {{ old('subject') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('subject')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div>
                        <label for="message" class="block text-gray-700 font-medium mb-2">Message</label>
                        <textarea id="message" name="message" rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent @error('message') border-red-500 @enderror" required>{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-md font-semibold hover:bg-blue-700 transition-colors">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Send Message
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Contact Information -->
            <div>
                <h2 class="text-2xl font-bold mb-6">Get in touch</h2>
                <p class="text-gray-600 mb-8">Have questions about our products or services? Our team is here to help. Contact us using the information below or fill out the form and we'll get back to you as soon as possible.</p>
                
                <div class="space-y-6">
                    <!-- Headquarters -->
                    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-600">
                        <h3 class="text-lg font-semibold mb-4">Headquarters</h3>
                        <div class="flex items-start mb-3">
                            <div class="text-blue-600 mr-3">
                                <i class="fas fa-map-marker-alt mt-1"></i>
                            </div>
                            <div>
                                <p class="text-gray-800">123 Software Avenue, Tech District</p>
                                <p class="text-gray-600">City 10000, Country</p>
                            </div>
                        </div>
                        <div class="flex items-center mb-3">
                            <div class="text-blue-600 mr-3">
                                <i class="fas fa-phone"></i>
                            </div>
                            <p class="text-gray-600">+1 234 567 8900</p>
                        </div>
                        <div class="flex items-center">
                            <div class="text-blue-600 mr-3">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <p class="text-gray-600">info@zplussoftware.com</p>
                        </div>
                    </div>
                    
                    <!-- Business Hours -->
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-lg font-semibold mb-4">Business Hours</h3>
                        <ul class="space-y-2 text-gray-600">
                            <li class="flex justify-between">
                                <span>Monday - Friday</span>
                                <span>9:00 AM - 6:00 PM</span>
                            </li>
                            <li class="flex justify-between">
                                <span>Saturday</span>
                                <span>10:00 AM - 2:00 PM</span>
                            </li>
                            <li class="flex justify-between">
                                <span>Sunday</span>
                                <span>Closed</span>
                            </li>
                        </ul>
                        
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <p class="text-gray-600">
                                <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                                Technical support is available 24/7 for our enterprise clients.
                            </p>
                        </div>
                    </div>
                    
                    <!-- Connect with us -->
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-lg font-semibold mb-4">Connect with us</h3>
                        <div class="flex space-x-4">
                            <a href="#" class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center hover:bg-blue-700 transition-colors">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-full bg-blue-400 text-white flex items-center justify-center hover:bg-blue-500 transition-colors">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-full bg-blue-700 text-white flex items-center justify-center hover:bg-blue-800 transition-colors">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-full bg-red-600 text-white flex items-center justify-center hover:bg-red-700 transition-colors">
                                <i class="fab fa-youtube"></i>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-full bg-gray-800 text-white flex items-center justify-center hover:bg-black transition-colors">
                                <i class="fab fa-github"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Google Maps -->
<section class="py-10 bg-gray-50">
    <div class="container mx-auto px-4">
        <h2 class="text-2xl font-bold mb-8 text-center">Our Locations</h2>
        
        <div class="h-96 rounded-lg shadow-md overflow-hidden">
            <!-- Google Maps iframe - Replace YOUR_API_KEY with a valid Google Maps API Key -->
            <iframe
                width="100%"
                height="100%"
                frameborder="0"
                style="border:0"
                src="https://www.google.com/maps/embed/v1/place?key=YOUR_API_KEY&q=Space+Needle,Seattle+WA"
                allowfullscreen
            ></iframe>
        </div>
        
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Office 1 -->
            <div class="bg-white rounded-lg shadow-md p-6 transition-all hover:shadow-lg">
                <h3 class="text-lg font-bold mb-2">Headquarters</h3>
                <div class="flex items-start mb-2">
                    <i class="fas fa-map-marker-alt mt-1 mr-3 text-blue-600"></i>
                    <p class="text-gray-600">123 Software Avenue, Tech District, City 10000</p>
                </div>
                <div class="flex items-center mb-2">
                    <i class="fas fa-phone mr-3 text-blue-600"></i>
                    <p class="text-gray-600">+1 234 567 8900</p>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-envelope mr-3 text-blue-600"></i>
                    <p class="text-gray-600">info@zplussoftware.com</p>
                </div>
            </div>
            
            <!-- Office 2 -->
            <div class="bg-white rounded-lg shadow-md p-6 transition-all hover:shadow-lg">
                <h3 class="text-lg font-bold mb-2">Europe Office</h3>
                <div class="flex items-start mb-2">
                    <i class="fas fa-map-marker-alt mt-1 mr-3 text-blue-600"></i>
                    <p class="text-gray-600">45 Tech Boulevard, Innovation Quarter, London EC2A 4BX</p>
                </div>
                <div class="flex items-center mb-2">
                    <i class="fas fa-phone mr-3 text-blue-600"></i>
                    <p class="text-gray-600">+44 20 1234 5678</p>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-envelope mr-3 text-blue-600"></i>
                    <p class="text-gray-600">europe@zplussoftware.com</p>
                </div>
            </div>
            
            <!-- Office 3 -->
            <div class="bg-white rounded-lg shadow-md p-6 transition-all hover:shadow-lg">
                <h3 class="text-lg font-bold mb-2">Asia Office</h3>
                <div class="flex items-start mb-2">
                    <i class="fas fa-map-marker-alt mt-1 mr-3 text-blue-600"></i>
                    <p class="text-gray-600">88 Digital Plaza, Technology Park, Singapore 569822</p>
                </div>
                <div class="flex items-center mb-2">
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
</section>

<!-- FAQ Section -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-4">Frequently Asked Questions</h2>
                <p class="text-gray-600">Find quick answers to common questions about our services and how to work with us</p>
            </div>
            
            <div class="space-y-6">
                <!-- FAQ Item 1 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <button class="faq-toggle flex justify-between items-center w-full px-6 py-4 text-left" data-target="faq-1">
                        <h3 class="text-lg font-semibold">How can I request a product demo?</h3>
                        <i class="fas fa-chevron-down text-blue-600 transition-transform duration-300"></i>
                    </button>
                    <div id="faq-1" class="faq-content px-6 pb-4 hidden">
                        <p class="text-gray-600">You can request a product demo by filling out our contact form above, selecting "Product Demo" as the subject, or by calling our sales team directly. We'll schedule a convenient time for a personalized demonstration.</p>
                    </div>
                </div>
                
                <!-- FAQ Item 2 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <button class="faq-toggle flex justify-between items-center w-full px-6 py-4 text-left" data-target="faq-2">
                        <h3 class="text-lg font-semibold">What types of support do you offer for your products?</h3>
                        <i class="fas fa-chevron-down text-blue-600 transition-transform duration-300"></i>
                    </button>
                    <div id="faq-2" class="faq-content px-6 pb-4 hidden">
                        <p class="text-gray-600">We offer multiple support tiers including standard email support, premium phone support, and enterprise-level dedicated support. Each product purchase includes at least 12 months of standard support and updates. Extended support packages are available for purchase.</p>
                    </div>
                </div>
                
                <!-- FAQ Item 3 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <button class="faq-toggle flex justify-between items-center w-full px-6 py-4 text-left" data-target="faq-3">
                        <h3 class="text-lg font-semibold">How do I apply for a job at Z+ Software?</h3>
                        <i class="fas fa-chevron-down text-blue-600 transition-transform duration-300"></i>
                    </button>
                    <div id="faq-3" class="faq-content px-6 pb-4 hidden">
                        <p class="text-gray-600">You can view our current job openings on our Careers page. To apply, submit your resume and cover letter through our online application system. We review all applications and will contact qualified candidates for interviews.</p>
                    </div>
                </div>
                
                <!-- FAQ Item 4 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <button class="faq-toggle flex justify-between items-center w-full px-6 py-4 text-left" data-target="faq-4">
                        <h3 class="text-lg font-semibold">Do you offer customization for your software products?</h3>
                        <i class="fas fa-chevron-down text-blue-600 transition-transform duration-300"></i>
                    </button>
                    <div id="faq-4" class="faq-content px-6 pb-4 hidden">
                        <p class="text-gray-600">Yes, we offer customization services for our enterprise clients. Our development team can modify our products to meet your specific business requirements, integrate with your existing systems, or develop completely custom solutions. Contact our sales team to discuss your needs.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="bg-blue-700 text-white py-16">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4">Ready to Get Started?</h2>
        <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">Our team is ready to help you find the perfect solution for your business needs</p>
        <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
            <a href="#" class="bg-white text-blue-700 hover:bg-blue-50 font-semibold rounded-md px-8 py-3 transition-all duration-200">View Our Products</a>
            <a href="{{ route('about') }}" class="bg-transparent border-2 border-white hover:bg-white hover:text-blue-700 text-white font-semibold rounded-md px-8 py-3 transition-all duration-200">Learn About Us</a>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // FAQ Accordions
        const faqToggles = document.querySelectorAll('.faq-toggle');
        
        faqToggles.forEach(toggle => {
            toggle.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const content = document.getElementById(targetId);
                const icon = this.querySelector('i');
                
                // Toggle content
                content.classList.toggle('hidden');
                
                // Rotate icon
                if (content.classList.contains('hidden')) {
                    icon.style.transform = 'rotate(0deg)';
                } else {
                    icon.style.transform = 'rotate(-180deg)';
                }
            });
        });
    });
</script>
@endpush