<?php

use App\Http\Controllers\Api\TokenController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('users')->group(function(){
    Route::get('/', [UserController::class, 'index']);
    Route::post('/', [UserController::class, 'store'])->name('users.store')->middleware('api_key');
    Route::get('/{id}', [UserController::class, 'show'])->name('users.show');
});

Route::get('/token', [TokenController::class, 'getToken']);