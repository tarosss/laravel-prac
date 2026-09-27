<?php

use App\Http\Middleware\CacheResponse;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::match(['get', 'post'], '/api', function () {
    return response()->json(['status' => Product::find(1)]);
})->middleware(CacheResponse::class . ':1d1h');
