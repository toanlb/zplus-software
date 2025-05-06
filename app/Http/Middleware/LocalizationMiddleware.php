<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class LocalizationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Trước tiên, kiểm tra xem có locale trong session hay không
        if (Session::has('locale')) {
            // Đặt locale từ session
            $locale = Session::get('locale');
            App::setLocale($locale);
        } else {
            // Sử dụng locale mặc định từ config
            $locale = config('app.locale');
            App::setLocale($locale);
            Session::put('locale', $locale);
        }
        
        // Log for debugging
        \Log::info('Current locale: ' . App::getLocale());
        \Log::info('Session locale: ' . Session::get('locale'));
        
        return $next($request);
    }
}