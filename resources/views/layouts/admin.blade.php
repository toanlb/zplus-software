<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <title>@yield('title', 'Admin Dashboard') - Z+ Admin Panel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600|poppins:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
        
        <!-- Tailwind CSS via CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Instrument Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        },
                    }
                }
            }
        </script>
        
        <!-- Custom styles -->
        <style>
            /* Add any custom styles here */
            .sidebar-link {
                @apply flex items-center px-4 py-2 text-gray-600 rounded hover:bg-gray-100 hover:text-blue-600 transition-all duration-200;
            }
            
            .sidebar-link.active {
                @apply bg-blue-50 text-blue-600 font-medium;
            }
            
            .sidebar-icon {
                @apply w-5 h-5 mr-3;
            }
            
            .btn {
                @apply px-4 py-2 rounded font-medium transition-all duration-200;
            }
            
            .btn-primary {
                @apply bg-blue-600 text-white hover:bg-blue-700;
            }
            
            .btn-secondary {
                @apply bg-gray-200 text-gray-800 hover:bg-gray-300;
            }
            
            .card {
                @apply bg-white rounded-lg shadow-md p-6;
            }
        </style>
        
        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        @stack('styles')
    </head>
    <body class="font-sans antialiased bg-gray-100 text-gray-900 min-h-screen">
        <div class="flex min-h-screen">
            <!-- Sidebar -->
            <aside class="w-64 bg-white shadow-md z-10 fixed h-full overflow-y-auto">
                <div class="p-6">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center mb-8">
                        <span class="text-2xl font-bold text-blue-600">Z+</span>
                        <span class="text-lg font-medium ml-1">Admin</span>
                    </a>
                    
                    <nav class="space-y-1">
                        <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-tachometer-alt sidebar-icon"></i>
                            <span>Dashboard</span>
                        </a>
                        
                        <a href="{{ route('admin.products.index') }}" class="sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                            <i class="fas fa-box sidebar-icon"></i>
                            <span>Products</span>
                        </a>
                        
                        <a href="{{ route('admin.orders.index') }}" class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                            <i class="fas fa-shopping-cart sidebar-icon"></i>
                            <span>Orders</span>
                        </a>
                        
                        <a href="{{ route('admin.licenses.index') }}" class="sidebar-link {{ request()->routeIs('admin.licenses.*') ? 'active' : '' }}">
                            <i class="fas fa-key sidebar-icon"></i>
                            <span>Licenses</span>
                        </a>
                        
                        <a href="{{ route('admin.customers.index') }}" class="sidebar-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                            <i class="fas fa-users sidebar-icon"></i>
                            <span>Customers</span>
                        </a>
                        
                        <a href="{{ route('admin.posts.index') }}" class="sidebar-link {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
                            <i class="fas fa-newspaper sidebar-icon"></i>
                            <span>Blog Posts</span>
                        </a>
                        
                        <a href="{{ route('admin.projects.index') }}" class="sidebar-link {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
                            <i class="fas fa-project-diagram sidebar-icon"></i>
                            <span>Projects</span>
                        </a>
                        
                        <a href="{{ route('admin.downloads.index') }}" class="sidebar-link {{ request()->routeIs('admin.downloads.*') ? 'active' : '' }}">
                            <i class="fas fa-download sidebar-icon"></i>
                            <span>Downloads</span>
                        </a>
                        
                        <div class="pt-4 mt-4 border-t border-gray-200">
                            <a href="{{ url('/') }}" class="sidebar-link">
                                <i class="fas fa-home sidebar-icon"></i>
                                <span>Visit Site</span>
                            </a>
                            
                            <form method="POST" action="{{ route('admin.logout') }}" class="mt-1">
                                @csrf
                                <button type="submit" class="sidebar-link w-full text-left">
                                    <i class="fas fa-sign-out-alt sidebar-icon"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </nav>
                </div>
            </aside>
            
            <!-- Main Content -->
            <div class="flex-1 ml-64">
                <!-- Top Header -->
                <header class="bg-white shadow-sm">
                    <div class="flex justify-between items-center px-6 py-3">
                        <h1 class="text-lg font-medium">@yield('title', 'Admin Dashboard')</h1>
                        
                        <div class="flex items-center">
                            <span class="mr-4 text-gray-700">{{ Auth::user()->name }}</span>
                            
                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center text-gray-600 hover:text-blue-600">
                                    <i class="fas fa-sign-out-alt mr-1"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </header>
                
                <!-- Page Content -->
                <main>
                    @yield('content')
                </main>
                
                <!-- Footer -->
                <footer class="border-t border-gray-200 bg-white py-6 px-6 text-center text-gray-500 text-sm">
                    <p>&copy; {{ date('Y') }} Z+ Software Company. All rights reserved.</p>
                </footer>
            </div>
        </div>
        
        @stack('scripts')
    </body>
</html>