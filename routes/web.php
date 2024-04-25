<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\App;

Route::get('/', function () {
    $phpVersion = phpversion();
    $laravelVersion = App::version();

    return "php: $phpVersion<br>software: $laravelVersion";
});

