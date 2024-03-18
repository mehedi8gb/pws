<?php

use App\Http\Controllers\api\FileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::middleware('guest')->group(function () {
            Route::get('/', [FileController::class, 'index'])->name('file.index');
            Route::get('file/{fileId}', [FileController::class, 'show'])->name('file.show');
            Route::post('files/upload', [FileController::class, 'store'])->name('file.store');
            Route::delete('file/destroy/{fileId}', [FileController::class, 'destroy'])->name('file.destroy');
        });
