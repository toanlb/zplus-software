<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Debug log để kiểm tra hoạt động của middleware
        \Log::info('Localization middleware executing');
        \Log::info('Session ID: ' . Session::getId());
        \Log::info('Session has locale: ' . (Session::has('locale') ? 'Yes' : 'No'));
        
        // Kiểm tra session language
        if (Session::has('locale')) {
            // Nếu đã có session, sử dụng giá trị trong session
            $locale = Session::get('locale');
            App::setLocale($locale);
            \Log::info('Setting app locale from session to: ' . $locale);
        } else {
            \Log::info('No locale in session, using default: ' . App::getLocale());
        }
        
        return $next($request);
    }
}