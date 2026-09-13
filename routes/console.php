<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schedule;

Schedule::call(function () {
    logger('laravel schedule');
})->everyTwoMinutes();
