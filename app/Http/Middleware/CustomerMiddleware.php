<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the authenticated user has the role 'customer'
        if ($request->user() && $request->user()->role === 'customer') {
            return $next($request);
        }
        
        // Redirect to home if not a customer
        return redirect()->route('home')->with('error', 'You do not have access to this area.');
    }
}