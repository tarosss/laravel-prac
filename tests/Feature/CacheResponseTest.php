<?php

use App\Http\Middleware\CacheResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

it('caches responses using a recursively sorted request signature', function () {
  Cache::flush();
  $callCount = 0;
  $middleware = new CacheResponse();

  $firstRequest = Request::create('/api/test', 'POST', [
    'b' => ['z' => 2, 'a' => 1],
    'a' => 'alpha',
  ]);

  $secondRequest = Request::create('/api/test', 'POST', [
    'a' => 'alpha',
    'b' => ['a' => 1, 'z' => 2],
  ]);

  $firstResponse = $middleware->handle($firstRequest, function () use (&$callCount) {
    $callCount++;

    return response()->json(['ok' => true], 202);
  }, '2m');

  $secondResponse = $middleware->handle($secondRequest, function () use (&$callCount) {
    $callCount++;

    return response()->json(['ok' => false], 200);
  }, '2m');

  expect($callCount)->toBe(1)
    ->and($firstResponse->getStatusCode())->toBe(202)
    ->and($firstResponse->getContent())->toBe('{"ok":true}')
    ->and($secondResponse->getStatusCode())->toBe(202)
    ->and($secondResponse->getContent())->toBe('{"ok":true}');
});

it('accepts ttl from middleware parameters in seconds or minutes', function () {
  Cache::flush();
  $middleware = new CacheResponse();

  $request = Request::create('/api/ttl', 'GET');

  $response = $middleware->handle($request, function () {
    return response()->json(['ok' => true], 201);
  }, '30s');

  expect($response->getStatusCode())->toBe(201)
    ->and(Cache::get(
      'response:' .
        App\Support\RequestCacheKey::make($request)
    ))->toBeArray();

  $responseFromMinutes = $middleware->handle($request, function () {
    return response()->json(['ok' => false], 500);
  }, '2m');

  expect($responseFromMinutes->getStatusCode())->toBe(201)
    ->and($responseFromMinutes->getContent())->toBe('{"ok":true}');
});

it('accepts combined ttl values such as 1d1m', function () {
  $middleware = new CacheResponse();

  $request = Request::create('/api/combined-ttl', 'GET');

  $response = $middleware->handle($request, function () {
    return response()->json(['ok' => true], 200);
  }, '1d1m');

  $method = new ReflectionMethod(CacheResponse::class, 'resolveTtl');
  $method->setAccessible(true);

  expect($response->getStatusCode())->toBe(200)
    ->and($method->invoke($middleware, '1d1m'))->toBe(86460);
});
