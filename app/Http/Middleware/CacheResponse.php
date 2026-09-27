<?php

namespace App\Http\Middleware;

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
        $cacheKey = 'response:' . $this->buildCacheKey($request);

        logger($cacheKey);
        if (Cache::has($cacheKey)) {
            $cachedResponse = Cache::get($cacheKey);

            if (is_string($cachedResponse)) {
                return response($cachedResponse, 200);
            }
        }

        $response = $next($request);

        if ($response->isSuccessful() || $response->isRedirection()) {
            Cache::put($cacheKey, $response->getContent(), now()->addMinutes(5));
        }

        return $response;
    }

    private function buildCacheKey(Request $request): string
    {
        $payload = [
            'method' => $request->method(),
            'path' => $request->path(),
            'query' => $request->query->all(),
            'input' => $request->all(),
        ];

        return $this->normalizeForCache($payload);
    }

    private function normalizeForCache(mixed $value, string $prefix = ''): string
    {
        if (is_array($value)) {
            ksort($value);

            $segments = [];
            foreach ($value as $key => $item) {
                $nextKey = $prefix === '' ? (string) $key : $prefix . '.' . $key;
                $segments[] = $this->normalizeForCache($item, $nextKey);
            }

            return implode('|', array_filter($segments, static fn($segment) => $segment !== ''));
        }

        if (is_object($value)) {
            return $this->normalizeForCache((array) $value, $prefix);
        }

        if ($prefix === '') {
            return '';
        }

        return $prefix . ':' . $this->convertScalar($value);
    }

    private function convertScalar(mixed $value): string
    {
        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        if ($value === null) {
            return 'null';
        }

        return (string) $value;
    }
}
