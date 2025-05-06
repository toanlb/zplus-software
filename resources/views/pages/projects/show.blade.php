@extends('layouts.app')

@section('title', $project->title)

@section('content')
    <!-- Project Detail -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <!-- Breadcrumb -->
            <div class="mb-8">
                <div class="flex items-center text-sm">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-blue-600">{{ __('general.home') }}</a>
                    <span class="mx-2 text-gray-400">/</span>
                    <a href="{{ route('projects.index') }}" class="text-gray-600 hover:text-blue-600">{{ __('projects.projects_title') }}</a>
                    @if($project->category)
                        <span class="mx-2 text-gray-400">/</span>
                        <span class="text-gray-600">{{ $project->category->name }}</span>
                    @endif
                    <span class="mx-2 text-gray-400">/</span>
                    <span class="text-gray-800 font-medium">{{ $project->title }}</span>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <!-- Project Header -->
                <div class="relative">
                    <div class="h-96 bg-gray-200">
                        @if($project->featured_image)
                            <img src="{{ asset($project->featured_image) }}" alt="{{ $project->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-500 bg-gray-300">
                                <i class="fas fa-project-diagram fa-5x"></i>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Overlay details on image (optional) -->
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-6 text-white">
                        <div class="container mx-auto">
                            <h1 class="text-3xl md:text-4xl font-bold mb-2">{{ $project->title }}</h1>
                            
                            <div class="flex flex-wrap text-sm text-gray-200">
                                @if($project->client)
                                    <span class="mr-6">
                                        <span class="font-semibold">{{ __('projects.client') }}:</span> {{ $project->client }}
                                    </span>
                                @endif
                                
                                @if($project->completion_date)
                                    <span class="mr-6">
                                        <span class="font-semibold">{{ __('projects.completed') }}:</span> {{ \Carbon\Carbon::parse($project->completion_date)->format('M Y') }}
                                    </span>
                                @endif
                                
                                @if($project->category)
                                    <span>
                                        <span class="font-semibold">{{ __('projects.category') }}:</span> {{ $project->category->name }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="p-6 lg:p-8">
                    <div class="flex flex-wrap -mx-4">
                        <!-- Project content -->
                        <div class="w-full lg:w-2/3 px-4">
                            <!-- Project overview -->
                            <div class="mb-8">
                                <h2 class="text-2xl font-bold mb-4">{{ __('projects.project_overview') }}</h2>
                                <div class="prose prose-lg max-w-none">
                                    {!! $project->description !!}
                                </div>
                            </div>
                            
                            <!-- Project Gallery (if available) -->
                            @if(isset($project->gallery) && !empty($project->gallery))
                                <div class="mb-8">
                                    <h2 class="text-2xl font-bold mb-4">{{ __('projects.project_gallery') }}</h2>
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                        @foreach(json_decode($project->gallery) as $image)
                                            <div class="bg-gray-100 rounded-lg overflow-hidden">
                                                <a href="{{ asset($image) }}" class="block" data-fslightbox="gallery">
                                                    <img src="{{ asset($image) }}" alt="{{ $project->title }}" class="w-full h-48 object-cover hover:opacity-90 transition">
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Challenge and Solution (if available) -->
                            @if($project->challenge || $project->solution)
                                <div class="mb-8">
                                    @if($project->challenge)
                                        <div class="mb-6">
                                            <h2 class="text-2xl font-bold mb-4">{{ __('projects.challenge') }}</h2>
                                            <div class="prose prose-lg max-w-none">
                                                {!! $project->challenge !!}
                                            </div>
                                        </div>
                                    @endif
                                    
                                    @if($project->solution)
                                        <div>
                                            <h2 class="text-2xl font-bold mb-4">{{ __('projects.solution') }}</h2>
                                            <div class="prose prose-lg max-w-none">
                                                {!! $project->solution !!}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                            
                            <!-- Results and Outcomes (if available) -->
                            @if($project->results)
                                <div class="mb-8">
                                    <h2 class="text-2xl font-bold mb-4">{{ __('projects.results') }}</h2>
                                    <div class="prose prose-lg max-w-none">
                                        {!! $project->results !!}
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Technology Stack (if available) -->
                            @if($project->technologies)
                                <div class="mb-8">
                                    <h2 class="text-2xl font-bold mb-4">{{ __('projects.technologies_used') }}</h2>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach(explode(',', $project->technologies) as $tech)
                                            <span class="inline-block bg-gray-100 text-gray-800 px-3 py-1 rounded-md text-sm">
                                                {{ trim($tech) }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Testimonial (if available) -->
                            @if($project->testimonial)
                                <div class="mb-8 bg-blue-50 p-6 rounded-lg border-l-4 border-blue-500">
                                    <blockquote class="text-lg italic text-gray-700 mb-4">
                                        "{{ $project->testimonial }}"
                                    </blockquote>
                                    @if($project->testimonial_author)
                                        <div class="font-medium text-gray-900">
                                            — {{ $project->testimonial_author }}
                                            @if($project->testimonial_position)
                                                <span class="text-gray-600">, {{ $project->testimonial_position }}</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                        
                        <!-- Sidebar -->
                        <div class="w-full lg:w-1/3 px-4">
                            <!-- Project Details -->
                            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                                <h3 class="text-lg font-bold mb-4">{{ __('projects.project_details') }}</h3>
                                <ul class="space-y-3">
                                    @if($project->client)
                                        <li class="flex justify-between">
                                            <span class="text-gray-600">{{ __('projects.client') }}:</span>
                                            <span class="font-medium">{{ $project->client }}</span>
                                        </li>
                                    @endif
                                    
                                    @if($project->category)
                                        <li class="flex justify-between">
                                            <span class="text-gray-600">{{ __('projects.category') }}:</span>
                                            <span class="font-medium">{{ $project->category->name }}</span>
                                        </li>
                                    @endif
                                    
                                    @if($project->location)
                                        <li class="flex justify-between">
                                            <span class="text-gray-600">{{ __('projects.location') }}:</span>
                                            <span class="font-medium">{{ $project->location }}</span>
                                        </li>
                                    @endif
                                    
                                    @if($project->start_date)
                                        <li class="flex justify-between">
                                            <span class="text-gray-600">{{ __('projects.start_date') }}:</span>
                                            <span class="font-medium">{{ \Carbon\Carbon::parse($project->start_date)->format('M Y') }}</span>
                                        </li>
                                    @endif
                                    
                                    @if($project->completion_date)
                                        <li class="flex justify-between">
                                            <span class="text-gray-600">{{ __('projects.completion_date') }}:</span>
                                            <span class="font-medium">{{ \Carbon\Carbon::parse($project->completion_date)->format('M Y') }}</span>
                                        </li>
                                    @endif
                                    
                                    @if($project->duration)
                                        <li class="flex justify-between">
                                            <span class="text-gray-600">{{ __('projects.duration') }}:</span>
                                            <span class="font-medium">{{ $project->duration }}</span>
                                        </li>
                                    @endif
                                    
                                    @if($project->budget)
                                        <li class="flex justify-between">
                                            <span class="text-gray-600">{{ __('projects.budget') }}:</span>
                                            <span class="font-medium">{{ $project->budget }}</span>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                            
                            <!-- Project links -->
                            @if($project->website_url || $project->github_url)
                                <div class="bg-gray-50 rounded-lg p-6 mb-6">
                                    <h3 class="text-lg font-bold mb-4">{{ __('projects.project_links') }}</h3>
                                    <div class="space-y-2">
                                        @if($project->website_url)
                                            <a href="{{ $project->website_url }}" target="_blank" class="block py-2 px-4 bg-blue-600 text-white rounded-md text-center hover:bg-blue-700 transition">
                                                <i class="fas fa-external-link-alt mr-2"></i> {{ __('projects.view_live_site') }}
                                            </a>
                                        @endif
                                        
                                        @if($project->github_url)
                                            <a href="{{ $project->github_url }}" target="_blank" class="block py-2 px-4 bg-gray-800 text-white rounded-md text-center hover:bg-gray-900 transition">
                                                <i class="fab fa-github mr-2"></i> {{ __('projects.view_source_code') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Share project -->
                            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                                <h3 class="text-lg font-bold mb-4">{{ __('projects.share_project') }}</h3>
                                <div class="flex space-x-3">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="bg-blue-600 text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-blue-700">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($project->title) }}" target="_blank" class="bg-blue-400 text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-blue-500">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" target="_blank" class="bg-blue-800 text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-blue-900">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                    <a href="mailto:?subject={{ urlencode($project->title) }}&body={{ urlencode(url()->current()) }}" class="bg-red-500 text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-red-600">
                                        <i class="fas fa-envelope"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Other Projects -->
            @if(isset($relatedProjects) && $relatedProjects->count() > 0)
                <div class="mt-12">
                    <h2 class="text-2xl font-bold mb-6">{{ __('projects.other_projects') }}</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($relatedProjects as $relatedProject)
                            <div class="bg-white rounded-lg shadow-md overflow-hidden transition duration-300 hover:shadow-lg">
                                <a href="{{ route('projects.show', $relatedProject->slug) }}" class="block">
                                    <div class="h-48 bg-gray-200 relative">
                                        @if($relatedProject->featured_image)
                                            <img src="{{ asset($relatedProject->featured_image) }}" alt="{{ $relatedProject->title }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-500 bg-gray-300">
                                                <i class="fas fa-project-diagram fa-2x"></i>
                                            </div>
                                        @endif
                                        
                                        @if($relatedProject->category)
                                            <span class="absolute top-2 right-2 bg-blue-600 text-white text-xs uppercase py-1 px-2 rounded">
                                                {{ $relatedProject->category->name }}
                                            </span>
                                        @endif
                                    </div>
                                </a>
                                
                                <div class="p-4">
                                    <h3 class="font-semibold text-lg mb-2">
                                        <a href="{{ route('projects.show', $relatedProject->slug) }}" class="text-gray-800 hover:text-blue-600">
                                            {{ $relatedProject->title }}
                                        </a>
                                    </h3>
                                    
                                    <p class="text-gray-600 text-sm mb-4">{{ Str::limit($relatedProject->excerpt, 80) }}</p>
                                    
                                    <a href="{{ route('projects.show', $relatedProject->slug) }}" class="text-blue-600 font-medium hover:text-blue-800 flex items-center">
                                        {{ __('projects.view_project') }}
                                        <i class="fas fa-arrow-right ml-1 text-sm"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            
            <!-- CTA Section -->
            <div class="bg-blue-600 rounded-lg p-8 mt-12 text-white text-center">
                <h2 class="text-2xl font-bold mb-4">{{ __('projects.interested_in_working') }}</h2>
                <p class="text-blue-100 mb-6 max-w-2xl mx-auto">{{ __('projects.contact_us_desc') }}</p>
                <a href="{{ route('contact') }}" class="inline-block py-3 px-6 bg-white text-blue-600 rounded-md font-medium hover:bg-gray-100 transition-colors">
                    {{ __('projects.contact_us') }}
                </a>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fslightbox@3.3.1/index.min.js"></script>
@endpush