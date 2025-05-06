@extends('layouts.app')

@section('title', __('projects.projects_title'))

@section('content')
    <!-- Projects Header Section -->
    <section class="bg-blue-600 py-16 text-white">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-4xl font-bold mb-4">{{ __('projects.projects_title') }}</h1>
                <p class="text-xl text-blue-100">{{ __('projects.projects_subtitle') }}</p>
            </div>
        </div>
    </section>
    
    <!-- Projects Listing Section -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <!-- Filter by category (if applicable) -->
            @if(isset($categories) && count($categories) > 0)
                <div class="mb-8 flex justify-center">
                    <div class="inline-flex flex-wrap justify-center gap-2">
                        <a href="{{ route('projects.index') }}" class="px-4 py-2 rounded-md {{ !isset($currentCategory) ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                            {{ __('projects.all_projects') }}
                        </a>
                        
                        @foreach($categories as $category)
                            <a href="{{ route('projects.category', $category->slug) }}" class="px-4 py-2 rounded-md {{ isset($currentCategory) && $currentCategory->id === $category->id ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
            
            <!-- Projects grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($projects as $project)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden transition duration-300 hover:shadow-lg h-full flex flex-col">
                        <a href="{{ route('projects.show', $project->slug) }}" class="block flex-shrink-0">
                            <div class="h-56 bg-gray-200 relative">
                                @if($project->featured_image)
                                    <img src="{{ asset($project->featured_image) }}" alt="{{ $project->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-500 bg-gray-300">
                                        <i class="fas fa-project-diagram fa-3x"></i>
                                    </div>
                                @endif
                                
                                @if($project->category)
                                    <span class="absolute top-4 right-4 bg-blue-600 text-white text-xs uppercase py-1 px-2 rounded-md">
                                        {{ $project->category->name }}
                                    </span>
                                @endif
                            </div>
                        </a>
                        
                        <div class="p-6 flex-grow flex flex-col">
                            <h3 class="text-xl font-bold mb-3">
                                <a href="{{ route('projects.show', $project->slug) }}" class="text-gray-800 hover:text-blue-600">
                                    {{ $project->title }}
                                </a>
                            </h3>
                            
                            <div class="mb-4 text-sm text-gray-500">
                                @if($project->client)
                                    <span class="mr-4">
                                        <i class="fas fa-building mr-1"></i> {{ $project->client }}
                                    </span>
                                @endif
                                
                                @if($project->completion_date)
                                    <span>
                                        <i class="far fa-calendar-check mr-1"></i> {{ \Carbon\Carbon::parse($project->completion_date)->format('M Y') }}
                                    </span>
                                @endif
                            </div>
                            
                            <p class="text-gray-600 mb-5 flex-grow">{{ Str::limit($project->excerpt, 150) }}</p>
                            
                            <div class="mt-auto">
                                <a href="{{ route('projects.show', $project->slug) }}" class="inline-block text-blue-600 font-medium hover:text-blue-800">
                                    {{ __('projects.view_project') }} <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white rounded-lg shadow-md p-8 text-center">
                        <div class="text-gray-500 text-lg mb-4">{{ __('projects.no_projects_found') }}</div>
                    </div>
                @endforelse
            </div>
            
            <!-- Pagination -->
            @if($projects->hasPages())
                <div class="mt-12">
                    {{ $projects->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection