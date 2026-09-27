<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CacheNuxtResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $request->attributes->set('nuxt-cache', true);
        $request->attributes->set('cache-key-path-only', true);
        return $next($request);
    }
}
