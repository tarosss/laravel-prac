<?php

namespace App\Contracts;

use Illuminate\Http\Request;

interface CacheKeyGenerator
{
  public function generate(Request $request): string;
}
