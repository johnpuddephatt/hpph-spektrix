<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ExceptionIfNoSpektrixSettings
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response|RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        \Cache::rememberForever('settings', function () {
            return nova_get_settings();
        });
        if (
            ! \Cache::get('settings') ||
            ! \Cache::get('settings')['spektrix_custom_domain'] ||
            ! \Cache::get('settings')['spektrix_client_name']
        ) {
            Log::critical('Spektrix configuration not found');
            abort(500);
        }

        return $next($request);
    }
}
