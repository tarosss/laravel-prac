<?php

namespace App\Support;

use App\Contracts\CacheKeyGenerator;
use Illuminate\Http\Request;

class PathCacheKey implements CacheKeyGenerator
{
  public function generate(Request $request): string
  {
    return $request->path();
  }
}
