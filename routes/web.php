<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;


Route::get('/', function () {
    return abort(404, 'Page Not Found');
});
