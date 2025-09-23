<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Allow admin routes to bypass maintenance mode
        if ($request->is('nova/*') || $request->is('api/*')) {
            return $next($request);
        }

        // Allow authenticated admin users to bypass
        if (auth()->check()) {
            return $next($request);
        }

        if (nova_get_setting('alert_takeover')) {
            return response()->view('maintenance', [], 503);
        }

        return $next($request);
    }
}
