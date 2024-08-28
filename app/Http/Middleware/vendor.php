<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class vendor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
     // Check if the user is authenticated and has a role of 0
     if (Auth::check() && Auth::user()->role == 4) {
        return $next($request);
    }

    // Optionally, you could redirect to a specific route or show an error
    return back()->with('error', 'You do not have access to this page.');
}    }
