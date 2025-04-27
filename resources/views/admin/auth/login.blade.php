<!DOCTYPE html>
<html lang="vi" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Z Plus Admin</title>
    <meta name="description" content="Trang đăng nhập quản trị Z Plus">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .bg-login-image {
            background: url('https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?ixlib=rb-4.0.3&auto=format&fit=crop&w=1950&q=80');
            background-size: cover;
            background-position: center;
        }
        
        .bg-login-overlay {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.9) 0%, rgba(30, 64, 175, 0.9) 100%);
        }
    </style>
</head>
<body class="h-full">
    <div class="flex h-screen w-full">
        <!-- Left Side: Background Image with Overlay -->
        <div class="hidden lg:flex lg:w-1/2 bg-login-image relative">
            <div class="bg-login-overlay absolute inset-0">
                <div class="flex flex-col justify-center h-full p-16">
                    <div class="mb-8">
                        <h1 class="text-4xl font-bold text-white mb-4">Z Plus Admin</h1>
                        <p class="text-lg text-white text-opacity-90">
                            Hệ thống quản trị website mạnh mẽ <br>và dễ sử dụng
                        </p>
                    </div>
                    
                    <div class="mt-12">
                        <div class="flex items-center space-x-4 mb-6">
                            <div class="bg-white bg-opacity-20 p-2 rounded-full">
                                <i class="fas fa-chart-line text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-white font-semibold text-lg">Quản lý hiệu quả</h3>
                                <p class="text-white text-opacity-80">Theo dõi và phân tích dữ liệu một cách trực quan</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4 mb-6">
                            <div class="bg-white bg-opacity-20 p-2 rounded-full">
                                <i class="fas fa-lock text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-white font-semibold text-lg">Bảo mật cao</h3>
                                <p class="text-white text-opacity-80">Hệ thống bảo mật đa lớp bảo vệ dữ liệu của bạn</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <div class="bg-white bg-opacity-20 p-2 rounded-full">
                                <i class="fas fa-cogs text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-white font-semibold text-lg">Tùy biến linh hoạt</h3>
                                <p class="text-white text-opacity-80">Dễ dàng tùy chỉnh theo nhu cầu của doanh nghiệp</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Side: Login Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center bg-white p-4 sm:p-6 lg:p-8">
            <div class="w-full max-w-md">
                <div class="text-center mb-10">
                    <h2 class="text-3xl font-bold text-gray-900">
                        <span class="text-blue-600">Z</span>Plus
                    </h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Đăng nhập để truy cập trang quản trị
                    </p>
                </div>
                
                @if(session('error'))
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 text-red-700">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif
                
                <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            Địa chỉ email
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="fa fa-envelope text-gray-400"></i>
                            </div>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                                   class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg
                                          focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 
                                          @error('email') border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                   placeholder="email@example.com">
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 flex justify-between">
                            <span>Mật khẩu</span>
                            <a href="#" class="text-sm text-blue-600 hover:text-blue-500">Quên mật khẩu?</a>
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="fa fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" id="password" name="password" required
                                   class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg
                                          focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 
                                          @error('password') border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                   placeholder="••••••••">
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" 
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-700">
                            Ghi nhớ đăng nhập
                        </label>
                    </div>
                    
                    <div>
                        <button type="submit" 
                                class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg
                                       shadow-sm text-base font-medium text-white bg-blue-600 hover:bg-blue-700 
                                       focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500
                                       transition duration-200">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Đăng nhập
                        </button>
                    </div>
                </form>
                
                <div class="mt-10 text-center text-sm text-gray-500">
                    <p>© {{ date('Y') }} Z Plus. Bản quyền thuộc về công ty cổ phần Z Plus.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>