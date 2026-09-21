<?php

use App\Events\SampleEvent;
use App\Http\Controllers\SampleContoroller;
use App\Http\Middleware\Sample;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

Route::get('/', function () {
    Log::info('welcome');
    return view('welcome');
});

Route::get('/welcome-test', function () {
    Log::info('welcome-test', session()->all());
    return view('welcome-test');
});

Route::get('policy', [SampleContoroller::class, 'policy']);
Route::get('a', [SampleContoroller::class, 'a']);

Route::get('customers', [SampleContoroller::class, 'customers']);

Route::get('login', [SampleContoroller::class, 'login'])->name('login');
Route::get('logout', [SampleContoroller::class, 'logout']);


Route::get('check', [SampleContoroller::class, 'check'])->middleware(['auth']);
Route::get('test', [SampleContoroller::class, 'test'])->middleware(['auth']);
Route::get('can', [SampleContoroller::class, 'test'])->middleware(['auth', 'can:check,article']);
Route::get('session', [SampleContoroller::class, 'showSession']);
Route::get('cache', [SampleContoroller::class, 'cacheFlexible']);
Route::get('context', [SampleContoroller::class, 'context'])->middleware([Sample::class]);
Route::get('http', [SampleContoroller::class, 'http'])->middleware([Sample::class]);
Route::get('process', [SampleContoroller::class, 'process'])->middleware([Sample::class]);
Route::get('queue/{id}', [SampleContoroller::class, 'queue'])
    ->middleware([Sample::class])
    ->whereNumber('id');
Route::get('event', [SampleContoroller::class, 'event'])->middleware([Sample::class]);
Route::get('exception', [SampleContoroller::class, 'exception'])->middleware([Sample::class]);
Route::get('blade', [SampleContoroller::class, 'blade']);
Route::get('singleton', [SampleContoroller::class, 'singleton']);
Route::get('customer-login', [SampleContoroller::class, 'singleton']);
