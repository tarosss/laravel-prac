<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::match(['get', 'post'], '/api', function () {
    return response()->json(['status' => Product::find(1)]);
});
