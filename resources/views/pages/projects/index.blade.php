@extends('layouts.app')

@section('title', 'Our Projects')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl font-bold mb-4">Our Projects</h1>
            <p class="text-xl text-blue-100">Explore our successful software implementations across various industries</p>
        </div>
    </div>
</section>

<!-- Project Categories -->
<section class="py-10 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="flex flex-wrap justify-center items-center gap-4">
            <button class="project-filter px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors active" data-filter="all">All Projects</button>
            <button class="project-filter px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-md hover:bg-gray-100 transition-colors" data-filter="web-development">Web Development</button>
            <button class="project-filter px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-md hover:bg-gray-100 transition-colors" data-filter="mobile-apps">Mobile Apps</button>
            <button class="project-filter px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-md hover:bg-gray-100 transition-colors" data-filter="enterprise">Enterprise Solutions</button>
            <button class="project-filter px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-md hover:bg-gray-100 transition-colors" data-filter="ai-ml">AI & Machine Learning</button>
        </div>
    </div>
</section>

<!-- Projects Grid -->
<section class="py-12">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($projects as $project)
                <div class="project-card bg-white rounded-lg shadow-md overflow-hidden transition-transform hover:transform hover:scale-105 hover:shadow-lg" data-category="{{ $project->category_slug ?? 'general' }}">
                    <div class="h-64 bg-gray-200 relative overflow-hidden">
                        @if($project->featured_image)
                            <img src="{{ asset('storage/' . $project->featured_image) }}" alt="{{ $project->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="flex items-center justify-center h-full bg-blue-600 text-white">
                                <i class="fas fa-project-diagram text-6xl"></i>
                            </div>
                        @endif
                        
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end">
                            <div class="p-6 w-full">
                                <span class="text-xs font-medium px-2 py-1 bg-blue-500/80 text-white rounded-md">{{ $project->category_name ?? 'Project' }}</span>
                                <h3 class="text-xl font-bold mt-2 text-white">{{ $project->name }}</h3>
                                <p class="text-gray-200 line-clamp-2 text-sm mt-1">{{ $project->excerpt ?? $project->short_description ?? Str::limit($project->description, 120) }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <i class="fas fa-calendar-alt text-blue-600 mr-2"></i>
                                <span class="text-gray-600 text-sm">{{ $project->completion_date ? \Carbon\Carbon::parse($project->completion_date)->format('M Y') : 'Ongoing' }}</span>
                            </div>
                            
                            @if($project->client_name)
                                <div class="flex items-center">
                                    <i class="fas fa-building text-blue-600 mr-2"></i>
                                    <span class="text-gray-600 text-sm">{{ $project->client_name }}</span>
                                </div>
                            @endif
                        </div>
                        
                        <a href="{{ route('projects.show', $project->slug) }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                            View Project Details
                            <i class="fas fa-arrow-right ml-2 text-sm"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-20">
                    <div class="text-5xl text-gray-300 mb-4">
                        <i class="fas fa-project-diagram"></i>
                    </div>
                    <h3 class="text-xl font-medium text-gray-600 mb-1">No Projects Found</h3>
                    <p class="text-gray-500">We're currently updating our portfolio.</p>
                </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        <div class="mt-12">
            {{ $projects->links() }}
        </div>
    </div>
</section>

<!-- Our Process -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold mb-4">Our Development Process</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">We follow a structured approach to deliver high-quality software solutions that meet our clients' business objectives</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Step 1 -->
            <div class="bg-white rounded-lg shadow-md p-8 relative">
                <div class="text-4xl font-bold text-blue-100 absolute top-4 right-4">01</div>
                <div class="text-blue-600 mb-4">
                    <i class="fas fa-lightbulb text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-3">Discovery</h3>
                <p class="text-gray-600">We begin with understanding your business goals, requirements, and vision for the project.</p>
            </div>
            
            <!-- Step 2 -->
            <div class="bg-white rounded-lg shadow-md p-8 relative">
                <div class="text-4xl font-bold text-blue-100 absolute top-4 right-4">02</div>
                <div class="text-blue-600 mb-4">
                    <i class="fas fa-pencil-ruler text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-3">Planning & Design</h3>
                <p class="text-gray-600">Our team creates detailed specifications, wireframes, and project roadmaps to guide development.</p>
            </div>
            
            <!-- Step 3 -->
            <div class="bg-white rounded-lg shadow-md p-8 relative">
                <div class="text-4xl font-bold text-blue-100 absolute top-4 right-4">03</div>
                <div class="text-blue-600 mb-4">
                    <i class="fas fa-code text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-3">Development</h3>
                <p class="text-gray-600">Our skilled developers build your solution using the latest technologies and best practices.</p>
            </div>
            
            <!-- Step 4 -->
            <div class="bg-white rounded-lg shadow-md p-8 relative">
                <div class="text-4xl font-bold text-blue-100 absolute top-4 right-4">04</div>
                <div class="text-blue-600 mb-4">
                    <i class="fas fa-rocket text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-3">Deployment & Support</h3>
                <p class="text-gray-600">We launch your solution and provide ongoing maintenance and support to ensure success.</p>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="py-16 bg-blue-700 text-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold mb-4">Client Testimonials</h2>
            <p class="text-blue-100 max-w-2xl mx-auto">Don't just take our word for it - here's what our clients have to say about our work</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Testimonial 1 -->
            <div class="bg-white rounded-lg shadow-md p-8 text-gray-800">
                <div class="flex text-yellow-400 mb-4">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="text-gray-600 mb-6">"Z+ Software delivered our enterprise resource planning system on time and within budget. Their team's expertise and professionalism exceeded our expectations."</p>
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center mr-4">
                        <span class="font-bold text-blue-600">JM</span>
                    </div>
                    <div>
                        <h4 class="font-bold">James Morrison</h4>
                        <p class="text-gray-500 text-sm">CTO, Global Manufacturing Inc.</p>
                    </div>
                </div>
            </div>
            
            <!-- Testimonial 2 -->
            <div class="bg-white rounded-lg shadow-md p-8 text-gray-800">
                <div class="flex text-yellow-400 mb-4">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="text-gray-600 mb-6">"We partnered with Z+ Software to create our customer-facing mobile app, and the results have been transformative. User engagement has increased by 300% since launch."</p>
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center mr-4">
                        <span class="font-bold text-green-600">AL</span>
                    </div>
                    <div>
                        <h4 class="font-bold">Amanda Liu</h4>
                        <p class="text-gray-500 text-sm">Marketing Director, Retail Chain Co.</p>
                    </div>
                </div>
            </div>
            
            <!-- Testimonial 3 -->
            <div class="bg-white rounded-lg shadow-md p-8 text-gray-800">
                <div class="flex text-yellow-400 mb-4">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <p class="text-gray-600 mb-6">"The data analytics solution provided by Z+ Software has helped us make better business decisions with real-time insights. Their ongoing support has been invaluable."</p>
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center mr-4">
                        <span class="font-bold text-purple-600">RB</span>
                    </div>
                    <div>
                        <h4 class="font-bold">Robert Brown</h4>
                        <p class="text-gray-500 text-sm">Operations Manager, Healthcare Provider</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4">Ready to Start Your Project?</h2>
        <p class="text-gray-600 mb-8 max-w-2xl mx-auto">Whether you need a custom software solution, a mobile app, or enterprise integration, our team is ready to help you succeed</p>
        <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
            <a href="{{ route('contact') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md px-8 py-3 transition-all duration-200">Contact Our Team</a>
            <a href="{{ route('about') }}" class="bg-white border-2 border-blue-600 text-blue-600 hover:bg-blue-50 font-semibold rounded-md px-8 py-3 transition-all duration-200">Learn About Us</a>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Project filtering
        const filterButtons = document.querySelectorAll('.project-filter');
        const projects = document.querySelectorAll('.project-card');
        
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Update active filter button
                filterButtons.forEach(btn => btn.classList.remove('active', 'bg-blue-600', 'text-white'));
                filterButtons.forEach(btn => btn.classList.add('bg-white', 'text-gray-700'));
                this.classList.remove('bg-white', 'text-gray-700');
                this.classList.add('active', 'bg-blue-600', 'text-white');
                
                const filter = this.getAttribute('data-filter');
                
                // Show/hide projects based on filter
                projects.forEach(project => {
                    if (filter === 'all' || project.getAttribute('data-category') === filter) {
                        project.style.display = 'block';
                    } else {
                        project.style.display = 'none';
                    }
                });
            });
        });
    });
</script>
@endpush