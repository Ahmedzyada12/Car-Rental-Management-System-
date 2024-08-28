<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Customer
{
    /**
     * Handle an incoming request.
     *
     * Check if the authenticated user's role is 0.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated and has a role of 0
        if (Auth::check() && Auth::user()->role == 3) {
            return $next($request);
        }

        // Optionally, you could redirect to a specific route or show an error
        return back()->with('error', 'You do not have access to this page.');
    }
}