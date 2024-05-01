<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\App;

Route::get('/', function () {
    return view('welcome');
});

//   temporary route for testing
Route::get('/phpinfo', function (){
    return phpinfo();

});

// sentry test route
Route::get('/debug-sentry', function () {
    throw new Exception('My first Sentry error!');
});