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
  });

  $secondResponse = $middleware->handle($secondRequest, function () use (&$callCount) {
    $callCount++;

    return response()->json(['ok' => false], 200);
  });

  expect($callCount)->toBe(1)
    ->and($firstResponse->getStatusCode())->toBe(202)
    ->and($firstResponse->getContent())->toBe('{"ok":true}')
    ->and($secondResponse->getStatusCode())->toBe(202)
    ->and($secondResponse->getContent())->toBe('{"ok":true}');
});
