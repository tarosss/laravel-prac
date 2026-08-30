<?php

use App\Events\SampleEvent;
use App\Http\Controllers\SampleContoroller;
use App\Http\Middleware\Sample;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Event;

Route::get('/', function () {
    return view('welcome');
});


Route::get('policy', [SampleContoroller::class, 'policy']);

Route::get('customers', [SampleContoroller::class, 'customers']);

Route::get('login', [SampleContoroller::class, 'login']);
Route::get('logout', [SampleContoroller::class, 'logout']);


Route::get('check', [SampleContoroller::class, 'check']);
Route::get('test', [SampleContoroller::class, 'test'])->middleware(['auth']);
Route::get('can', [SampleContoroller::class, 'test'])->middleware(['auth', 'can:check,article']);
Route::get('session', [SampleContoroller::class, 'showSession']);
Route::get('cache', [SampleContoroller::class, 'cacheFlexible']);
Route::get('context', [SampleContoroller::class, 'context'])->middleware([Sample::class]);
Route::get('http', [SampleContoroller::class, 'http'])->middleware([Sample::class]);
