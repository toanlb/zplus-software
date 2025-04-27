<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Z Plus Admin</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 5px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        
        /* Modern menu styles */
        .modern-nav {
            transition: all 0.3s ease;
        }
        
        .modern-nav-item {
            position: relative;
            transition: all 0.2s ease;
            border-radius: 10px;
            margin: 5px 0;
        }
        
        .modern-nav-item.active {
            background: linear-gradient(90deg, rgba(59, 130, 246, 0.1) 0%, rgba(59, 130, 246, 0.0) 100%);
            border-left: 3px solid #3b82f6;
        }
        
        .modern-nav-item:hover {
            background-color: rgba(59, 130, 246, 0.08);
        }
        
        .modern-nav-item.active i {
            color: #3b82f6;
        }
        
        .menu-collapsed {
            width: 80px;
        }
        
        .menu-expanded {
            width: 256px;
        }
        
        .content-collapsed {
            margin-left: 80px;
        }
        
        .content-expanded {
            margin-left: 256px;
        }
        
        /* Dashboard card animations */
        .dashboard-card {
            transition: all 0.3s ease;
        }
        
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        @auth
            <div id="app" class="flex min-h-screen">
                <!-- Modern Navigation Menu -->
                <div id="modern-sidebar" class="modern-nav menu-expanded fixed z-10 top-0 left-0 h-full bg-white shadow-lg overflow-hidden">
                    <!-- Logo -->
                    <div class="flex items-center justify-between h-16 px-4 border-b border-gray-200">
                        <div class="flex items-center">
                            <img src="{{ asset('img/zplus.png') }}" alt="Z+ Admin" class="h-12">
                        </div>
                        <button id="toggle-menu" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                    </div>
                    
                    <!-- Navigation -->
                    <div class="p-4">
                        <ul class="space-y-2">
                            <li>
                                <a href="{{ route('admin.dashboard') }}" class="modern-nav-item flex items-center p-3 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                    <i class="fas fa-tachometer-alt text-xl text-gray-500 w-6"></i>
                                    <span id="menu-text-dashboard" class="ml-3 text-gray-700">Dashboard</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.products.index') }}" class="modern-nav-item flex items-center p-3 {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                                    <i class="fas fa-box text-xl text-gray-500 w-6"></i>
                                    <span id="menu-text-products" class="ml-3 text-gray-700">Sản phẩm</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.orders.index') }}" class="modern-nav-item flex items-center p-3 {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                                    <i class="fas fa-shopping-cart text-xl text-gray-500 w-6"></i>
                                    <span id="menu-text-orders" class="ml-3 text-gray-700">Đơn hàng</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.customers.index') }}" class="modern-nav-item flex items-center p-3 {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                                    <i class="fas fa-users text-xl text-gray-500 w-6"></i>
                                    <span id="menu-text-customers" class="ml-3 text-gray-700">Khách hàng</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.posts.index') }}" class="modern-nav-item flex items-center p-3 {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
                                    <i class="fas fa-file-alt text-xl text-gray-500 w-6"></i>
                                    <span id="menu-text-posts" class="ml-3 text-gray-700">Bài viết</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.downloads.index') }}" class="modern-nav-item flex items-center p-3 {{ request()->routeIs('admin.downloads.*') ? 'active' : '' }}">
                                    <i class="fas fa-download text-xl text-gray-500 w-6"></i>
                                    <span id="menu-text-downloads" class="ml-3 text-gray-700">Tải xuống</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.orders.dashboard') }}" class="modern-nav-item flex items-center p-3 {{ request()->routeIs('admin.orders.dashboard') ? 'active' : '' }}">
                                    <i class="fas fa-chart-bar text-xl text-gray-500 w-6"></i>
                                    <span id="menu-text-stats" class="ml-3 text-gray-700">Thống kê</span>
                                </a>
                            </li>
                        </ul>
                        
                        <div class="border-t border-gray-200 mt-6 pt-6">
                            <form action="{{ route('admin.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="modern-nav-item flex items-center p-3 w-full">
                                    <i class="fas fa-sign-out-alt text-xl text-red-500 w-6"></i>
                                    <span id="menu-text-logout" class="ml-3 text-red-500">Đăng xuất</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Main Content -->
                <div id="main-content" class="content-expanded flex-1 transition-all duration-300">
                    <!-- Top Header -->
                    <header class="sticky top-0 z-10 flex items-center justify-between px-4 py-2 bg-white shadow sm:px-6">
                        <div class="flex items-center">
                            <!-- Mobile menu button -->
                            <button id="mobile-toggle" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 md:hidden hover:text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700 focus:text-white">
                                <i class="fas fa-bars"></i>
                            </button>
                            
                            <h2 class="ml-2 md:ml-0 text-lg font-medium text-gray-900">@yield('header', 'Dashboard')</h2>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <!-- Search -->
                            <div class="hidden md:block">
                                <div class="relative">
                                    <input type="text" id="global-search" placeholder="Tìm kiếm..." 
                                        class="w-64 pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-search text-gray-400"></i>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Notifications -->
                            <div class="relative" id="notification-container">
                                <button id="notification-btn" class="relative p-1 text-gray-500 rounded-full hover:bg-gray-100 focus:outline-none focus:bg-gray-100">
                                    <i class="fas fa-bell"></i>
                                    <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                                </button>
                                <div id="notification-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg overflow-hidden z-20">
                                    <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
                                        <h3 class="text-sm font-medium text-gray-700">Thông báo</h3>
                                    </div>
                                    <div class="divide-y divide-gray-200 max-h-64 overflow-y-auto" id="notification-list">
                                        <div class="px-4 py-3 hover:bg-gray-50 cursor-pointer">
                                            <div class="flex items-start">
                                                <div class="flex-shrink-0">
                                                    <i class="fas fa-shopping-cart text-blue-500"></i>
                                                </div>
                                                <div class="ml-3 w-0 flex-1">
                                                    <p class="text-sm font-medium text-gray-900">Đơn hàng mới #1234</p>
                                                    <p class="text-xs text-gray-500">30 phút trước</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="px-4 py-3 hover:bg-gray-50 cursor-pointer">
                                            <div class="flex items-start">
                                                <div class="flex-shrink-0">
                                                    <i class="fas fa-user-plus text-green-500"></i>
                                                </div>
                                                <div class="ml-3 w-0 flex-1">
                                                    <p class="text-sm font-medium text-gray-900">Khách hàng mới đã đăng ký</p>
                                                    <p class="text-xs text-gray-500">2 giờ trước</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="px-4 py-2 bg-gray-50 text-center">
                                        <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-500">Xem tất cả</a>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- User Menu -->
                            <div class="relative" id="user-menu-container">
                                <button id="user-menu-btn" class="flex items-center text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150">
                                    <img class="h-8 w-8 rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&color=7F9CF5&background=EBF4FF" alt="{{ auth()->user()->name }}">
                                    <span class="ml-2 hidden md:inline-block">{{ auth()->user()->name }}</span>
                                    <i class="fas fa-chevron-down ml-1 text-xs text-gray-400"></i>
                                </button>
                                
                                <div id="user-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-20">
                                    <div class="py-1">
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-user mr-2"></i> Thông tin cá nhân
                                        </a>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-cog mr-2"></i> Cài đặt
                                        </a>
                                        <form action="{{ route('admin.logout') }}" method="POST" class="block">
                                            @csrf
                                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-gray-100">
                                                <i class="fas fa-sign-out-alt mr-2"></i> Đăng xuất
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </header>
                    
                    <!-- Main Content Area -->
                    <main class="p-4 sm:p-6">
                        <!-- Flash Messages -->
                        @if(session('success'))
                            <div id="success-alert" class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 text-green-700 animate__animated animate__fadeIn">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="font-medium">{{ session('success') }}</p>
                                    </div>
                                    <div class="ml-auto">
                                        <button class="close-alert text-green-500 hover:text-green-700">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if(session('error'))
                            <div id="error-alert" class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 text-red-700 animate__animated animate__fadeIn">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-exclamation-circle"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="font-medium">{{ session('error') }}</p>
                                    </div>
                                    <div class="ml-auto">
                                        <button class="close-alert text-red-500 hover:text-red-700">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Content -->
                        @yield('content')
                    </main>
                </div>
            </div>
        @else
            <main>
                @yield('content')
            </main>
        @endauth
    </div>

    <!-- jQuery JS -->
    <script>
        $(document).ready(function() {
            // Toggle sidebar
            $('#toggle-menu').click(function() {
                const sidebar = $('#modern-sidebar');
                const mainContent = $('#main-content');
                const logoText = $('#logo-text');
                const menuTexts = $('[id^="menu-text-"]');
                const toggleIcon = $(this).find('i');
                
                if (sidebar.hasClass('menu-expanded')) {
                    // Collapse sidebar
                    sidebar.removeClass('menu-expanded').addClass('menu-collapsed');
                    mainContent.removeClass('content-expanded').addClass('content-collapsed');
                    logoText.fadeOut(200);
                    menuTexts.fadeOut(200);
                    toggleIcon.removeClass('fa-chevron-left').addClass('fa-chevron-right');
                } else {
                    // Expand sidebar
                    sidebar.removeClass('menu-collapsed').addClass('menu-expanded');
                    mainContent.removeClass('content-collapsed').addClass('content-expanded');
                    setTimeout(() => {
                        logoText.fadeIn(200);
                        menuTexts.fadeIn(200);
                    }, 100);
                    toggleIcon.removeClass('fa-chevron-right').addClass('fa-chevron-left');
                }
            });
            
            // Mobile menu toggle
            $('#mobile-toggle').click(function() {
                const sidebar = $('#modern-sidebar');
                if (sidebar.hasClass('menu-expanded')) {
                    sidebar.css('transform', 'translateX(-100%)');
                    setTimeout(() => {
                        sidebar.css('transform', '');
                    }, 300);
                } else {
                    sidebar.addClass('menu-expanded').removeClass('menu-collapsed');
                    $('#logo-text').show();
                    $('[id^="menu-text-"]').show();
                }
            });
            
            // Add hover effect for menu items
            $('.modern-nav-item').hover(
                function() {
                    $(this).addClass('animate__animated animate__pulse');
                },
                function() {
                    $(this).removeClass('animate__animated animate__pulse');
                }
            );
            
            // Toggle dropdowns
            $('#notification-btn').click(function(e) {
                e.stopPropagation();
                $('#notification-dropdown').toggleClass('hidden');
                $('#user-dropdown').addClass('hidden');
            });
            
            $('#user-menu-btn').click(function(e) {
                e.stopPropagation();
                $('#user-dropdown').toggleClass('hidden');
                $('#notification-dropdown').addClass('hidden');
            });
            
            $(document).click(function() {
                $('#notification-dropdown, #user-dropdown').addClass('hidden');
            });
            
            // Prevent dropdown close when clicking inside
            $('#notification-dropdown, #user-dropdown').click(function(e) {
                e.stopPropagation();
            });
            
            // Close alerts
            $('.close-alert').click(function() {
                $(this).closest('div[id$="-alert"]').addClass('animate__fadeOut');
                setTimeout(() => {
                    $(this).closest('div[id$="-alert"]').remove();
                }, 500);
            });
            
            // Auto hide alerts after 5 seconds
            setTimeout(function() {
                $('div[id$="-alert"]').addClass('animate__fadeOut');
                setTimeout(() => {
                    $('div[id$="-alert"]').remove();
                }, 500);
            }, 5000);
            
            // Global search animation
            $('#global-search').focus(function() {
                $(this).animate({width: '320px'}, 300);
            }).blur(function() {
                $(this).animate({width: '256px'}, 300);
            });
            
            // Highlight current page in menu
            $('.modern-nav-item').each(function() {
                if ($(this).hasClass('active')) {
                    $(this).addClass('animate__animated animate__fadeIn');
                }
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>