<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Log;
use Symfony\Component\HttpFoundation\Response;

class LanguageSwitch
{
    public function handle(Request $request, Closure $next): Response
    {
        // Get locale from session, fallback to default app locale
        $locale = Session::get('locale', config('app.locale'));
        
        // Validate locale against available locales
        $availableLocales = ['en', 'ar', 'fr', 'es','ger']; // Add your supported languages

        if (in_array($locale, $availableLocales)) {
            App::setLocale($locale);
        } else {
            // Fallback to default locale if invalid
            App::setLocale(config('app.locale'));
        }
        
        return $next($request);
    }
}
