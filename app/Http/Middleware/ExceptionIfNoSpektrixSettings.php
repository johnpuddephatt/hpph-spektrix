<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ExceptionIfNoSpektrixSettings
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        \Cache::rememberForever("settings", function () {
            return nova_get_settings();
        });
        if (
            !\Cache::get("settings") ||
            !\Cache::get("settings")["spektrix_custom_domain"] ||
            !\Cache::get("settings")["spektrix_client_name"]
        ) {
            Log::critical("Spektrix configuration not found");
            abort(500);
        }

        return $next($request);
    }
}
