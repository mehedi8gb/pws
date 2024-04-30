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

