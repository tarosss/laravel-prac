<?php

namespace App\Http\Middleware;

use App\Support\RequestCacheKey;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class CacheResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $cacheKey = 'response:' . RequestCacheKey::make($request);

        $cachedResponse = Cache::get($cacheKey);

        if (
            is_array($cachedResponse)
            && isset(
                $cachedResponse['status'],
                $cachedResponse['content'],
                $cachedResponse['headers']
            )
        ) {
            return response($cachedResponse['content'], $cachedResponse['status'])
                ->withHeaders($cachedResponse['headers']);;
        }

        $response = $next($request);

        if ($response->isSuccessful() || $response->isRedirection()) {
            $headers = $response->headers->all();
            unset($headers['date']);
            Cache::put($cacheKey, [
                'status' => $response->getStatusCode(),
                'content' => $response->getContent(),
                'headers' => $headers
            ], now()->addMinutes(5));
        }

        return $response;
    }
}
