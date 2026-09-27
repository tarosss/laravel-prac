<?php

namespace App\Support;

use App\Contracts\CacheKeyGenerator;
use Illuminate\Http\Request;

class RequestCacheKey implements CacheKeyGenerator
{
  public function generate(Request $request): string
  {
    $payload = [
      'method' => $request->method(),
      'path' => $request->path(),
      'query' => $request->query->all(),
      'input' => $request->all(),
    ];

    return self::normalize($payload);
  }

  private function normalize($value, string $prefix = ''): string
  {
    if (is_array($value)) {
      ksort($value);

      $segments = [];
      foreach ($value as $key => $item) {
        $nextKey = $prefix === '' ? (string) $key : $prefix . '.' . $key;
        $segments[] = self::normalize($item, $nextKey);
      }

      return implode('|', array_filter($segments, static fn($segment) => $segment !== ''));
    }

    if (is_object($value)) {
      return self::normalize((array)$value, $prefix);
    }

    if ($prefix === '') {
      return '';
    }

    return $prefix . ':' . self::convertScalar($value);
  }

  private function convertScalar(mixed $value): string
  {
    if (is_bool($value)) {
      return $value ? 'true' : 'false';
    }

    if ($value === null) {
      return 'null';
    }

    return (string)$value;
  }
}
