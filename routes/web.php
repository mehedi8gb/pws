<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;


Route::get('/', function () {
    abort(404, 'Page Not Found');
});
