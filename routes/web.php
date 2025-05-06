<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public routes
Route::get('/', function () {
    return view('pages.home');
})->name('home');

// About page route
Route::get('/about', function () {
    return view('pages.about');
})->name('about');

// Products routes
Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
Route::get('/products/category/{category:slug}', [App\Http\Controllers\ProductController::class, 'category'])->name('products.category');
Route::get('/products/{product:slug}', [App\Http\Controllers\ProductController::class, 'show'])->name('products.show');

// Projects routes
Route::get('/projects', [App\Http\Controllers\ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{project:slug}', [App\Http\Controllers\ProjectController::class, 'show'])->name('projects.show');

// Blog routes
Route::get('/blog', [App\Http\Controllers\BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/category/{category:slug}', [App\Http\Controllers\BlogController::class, 'category'])->name('blog.category');
Route::get('/blog/{post:slug}', [App\Http\Controllers\BlogController::class, 'show'])->name('blog.show');

// Contact page route
Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

// Contact form submission
Route::post('/contact', function (Illuminate\Http\Request $request) {
    // For now, we'll just flash a success message and redirect back
    // In a real application, you would process the form data (send email, store in DB, etc.)
    return redirect()->route('contact')->with('success', 'Thank you for your message. We will get back to you soon!');
})->name('contact');

// Language switcher route
Route::get('/language/{locale}', [App\Http\Controllers\LanguageController::class, 'switch'])->name('language.switch');

// User/Customer Authentication Routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// Registration Routes
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'register']);

// Password Reset Routes
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

// Customer Dashboard Routes - Protected by customer middleware
Route::middleware(['auth', 'customer'])->group(function () {
    Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('customer.dashboard');
    Route::get('/orders', [CustomerController::class, 'orders'])->name('customer.orders');
    Route::get('/downloads', [CustomerController::class, 'downloads'])->name('customer.downloads');
    Route::get('/profile', [CustomerController::class, 'profile'])->name('customer.profile');
    
    // Profile update routes
    Route::put('/profile/update', [CustomerController::class, 'updateProfile'])->name('customer.profile.update');
    Route::put('/profile/password', [CustomerController::class, 'updatePassword'])->name('customer.password.update');
    
    // Download route with token verification
    Route::get('/download/{item}', [CustomerController::class, 'download'])->name('customer.download');
});

// Shopping Cart Routes
Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::post('/cart', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/{id}', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{id}', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/mini', [App\Http\Controllers\CartController::class, 'miniCart'])->name('cart.mini');

// Checkout Routes
Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/process', [App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/complete/{order}', [App\Http\Controllers\CheckoutController::class, 'complete'])->name('checkout.complete');
Route::post('/checkout/confirm-payment/{order}', [App\Http\Controllers\CheckoutController::class, 'confirmPayment'])->name('checkout.confirm-payment');

// Admin Authentication Routes (accessible without admin authentication)
Route::prefix('admin')->group(function () {
    Route::get('/login', [App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [App\Http\Controllers\Admin\AuthController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('admin.logout');
    
    // Redirect admin root to dashboard if authenticated, otherwise to login
    Route::get('/', function () {
        if (auth()->check() && auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('admin.login');
    });
});

// Admin routes - Protected by admin middleware
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Products Management
    Route::get('/products', [App\Http\Controllers\Admin\ProductController::class, 'index'])->name('admin.products.index');
    Route::get('/products/create', [App\Http\Controllers\Admin\ProductController::class, 'create'])->name('admin.products.create');
    Route::post('/products', [App\Http\Controllers\Admin\ProductController::class, 'store'])->name('admin.products.store');
    Route::get('/products/{product}', [App\Http\Controllers\Admin\ProductController::class, 'show'])->name('admin.products.show');
    Route::get('/products/{product}/edit', [App\Http\Controllers\Admin\ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/products/{product}', [App\Http\Controllers\Admin\ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/{product}', [App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('admin.products.destroy');
    Route::get('/products/{product}/download', [App\Http\Controllers\Admin\ProductController::class, 'download'])->name('admin.products.download');
    
    // Categories Management
    Route::get('/categories', [App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('admin.categories.index');
    Route::get('/categories/create', [App\Http\Controllers\Admin\CategoryController::class, 'create'])->name('admin.categories.create');
    Route::post('/categories', [App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('admin.categories.store');
    Route::get('/categories/{category}/edit', [App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('admin.categories.edit');
    Route::put('/categories/{category}', [App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('/categories/{category}', [App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('admin.categories.destroy');
    
    // Orders Management
    Route::get('/orders', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('admin.orders.index');
    // Fix: Move dashboard route before the show route to prevent 'dashboard' being treated as an order ID
    Route::get('/orders/dashboard', [App\Http\Controllers\Admin\OrderController::class, 'dashboard'])->name('admin.orders.dashboard');
    Route::get('/orders/{order}', [App\Http\Controllers\Admin\OrderController::class, 'show'])->name('admin.orders.show');
    Route::put('/orders/{order}/status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('admin.orders.status.update');
    
    // Customers Management
    Route::get('/customers', [App\Http\Controllers\Admin\CustomerController::class, 'index'])->name('admin.customers.index');
    // Add missing create route for customers
    Route::get('/customers/create', [App\Http\Controllers\Admin\CustomerController::class, 'create'])->name('admin.customers.create');
    Route::post('/customers', [App\Http\Controllers\Admin\CustomerController::class, 'store'])->name('admin.customers.store');
    Route::get('/customers/{user}', [App\Http\Controllers\Admin\CustomerController::class, 'show'])->name('admin.customers.show');
    Route::get('/customers/{user}/edit', [App\Http\Controllers\Admin\CustomerController::class, 'edit'])->name('admin.customers.edit');
    Route::put('/customers/{user}', [App\Http\Controllers\Admin\CustomerController::class, 'update'])->name('admin.customers.update');
    Route::delete('/customers/{user}', [App\Http\Controllers\Admin\CustomerController::class, 'destroy'])->name('admin.customers.destroy');
    Route::get('/customers/{user}/orders', [App\Http\Controllers\Admin\CustomerController::class, 'orders'])->name('admin.customers.orders');
    Route::get('/customers/{user}/licenses', [App\Http\Controllers\Admin\CustomerController::class, 'licenses'])->name('admin.customers.licenses');
    
    // Posts/Blog Management
    Route::get('/posts', [App\Http\Controllers\Admin\PostController::class, 'index'])->name('admin.posts.index');
    Route::get('/posts/create', [App\Http\Controllers\Admin\PostController::class, 'create'])->name('admin.posts.create');
    Route::post('/posts', [App\Http\Controllers\Admin\PostController::class, 'store'])->name('admin.posts.store');
    Route::get('/posts/{post}/edit', [App\Http\Controllers\Admin\PostController::class, 'edit'])->name('admin.posts.edit');
    Route::put('/posts/{post}', [App\Http\Controllers\Admin\PostController::class, 'update'])->name('admin.posts.update');
    Route::delete('/posts/{post}', [App\Http\Controllers\Admin\PostController::class, 'destroy'])->name('admin.posts.destroy');
    
    // Projects Management
    Route::get('/projects', [App\Http\Controllers\Admin\ProjectController::class, 'index'])->name('admin.projects.index');
    Route::get('/projects/create', [App\Http\Controllers\Admin\ProjectController::class, 'create'])->name('admin.projects.create');
    Route::post('/projects', [App\Http\Controllers\Admin\ProjectController::class, 'store'])->name('admin.projects.store');
    Route::get('/projects/{project}/edit', [App\Http\Controllers\Admin\ProjectController::class, 'edit'])->name('admin.projects.edit');
    Route::put('/projects/{project}', [App\Http\Controllers\Admin\ProjectController::class, 'update'])->name('admin.projects.update');
    Route::delete('/projects/{project}', [App\Http\Controllers\Admin\ProjectController::class, 'destroy'])->name('admin.projects.destroy');
    
    // Downloads Management
    Route::get('/downloads', [App\Http\Controllers\Admin\DownloadController::class, 'index'])->name('admin.downloads.index');
    Route::get('/downloads/report', [App\Http\Controllers\Admin\DownloadController::class, 'report'])->name('admin.downloads.report');
    // Add missing statistics route
    Route::get('/downloads/statistics', [App\Http\Controllers\Admin\DownloadController::class, 'statistics'])->name('admin.downloads.statistics');
    
    // Licenses Management
    Route::get('/licenses', [App\Http\Controllers\Admin\LicenseController::class, 'index'])->name('admin.licenses.index');
    Route::get('/licenses/create', [App\Http\Controllers\Admin\LicenseController::class, 'create'])->name('admin.licenses.create');
    Route::post('/licenses', [App\Http\Controllers\Admin\LicenseController::class, 'store'])->name('admin.licenses.store');
    Route::get('/licenses/{license}/edit', [App\Http\Controllers\Admin\LicenseController::class, 'edit'])->name('admin.licenses.edit');
    Route::put('/licenses/{license}', [App\Http\Controllers\Admin\LicenseController::class, 'update'])->name('admin.licenses.update');
    Route::delete('/licenses/{license}', [App\Http\Controllers\Admin\LicenseController::class, 'destroy'])->name('admin.licenses.destroy');
});
