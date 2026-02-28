<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (auth()->check()) {
            // Set locale from user preference
            $locale = auth()->user()->locale ?? config('app.locale');
        } else {
            // Set locale from session or default
            $locale = session('locale', config('app.locale'));
        }

        // Validate locale (only allow supported languages)
        $supportedLocales = ['id', 'en', 'es', 'tr'];
        if (!in_array($locale, $supportedLocales)) {
            $locale = config('app.locale');
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
