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
    public function handle(Request $request, Closure $next, ?string $ttl = null): Response
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
                ->withHeaders($cachedResponse['headers']);
        }

        $response = $next($request);

        if ($response->isSuccessful() || $response->isRedirection()) {
            $headers = $response->headers->all();
            unset($headers['date']);

            Cache::put($cacheKey, [
                'status' => $response->getStatusCode(),
                'content' => $response->getContent(),
                'headers' => $headers,
            ], $this->resolveTtl($ttl));
        }

        return $response;
    }

    protected function resolveTtl(?string $ttl): int
    {
        if ($ttl === null || $ttl === '') {
            return 300;
        }

        $normalized = strtolower(trim($ttl));

        if ($normalized === '') {
            return 300;
        }

        preg_match_all('/(\d+)([smhd])/', $normalized, $matches, PREG_SET_ORDER);
        logger($normalized);
        logger($matches);
        if ($matches === []) {
            return 300;
        }

        $totalSeconds = 0;

        foreach ($matches as $match) {
            $value = (int) $match[1];
            $unit = $match[2];

            if ($unit === 's') {
                $totalSeconds += $value;
                continue;
            }

            if ($unit === 'm') {
                $totalSeconds += $value * 60;
                continue;
            }

            if ($unit === 'h') {
                $totalSeconds += $value * 3600;
                continue;
            }

            if ($unit === 'd') {
                $totalSeconds += $value * 86400;
            }
        }

        return $totalSeconds > 0 ? $totalSeconds : 300;
    }
}
