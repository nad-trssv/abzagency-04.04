<?php

use App\Http\Controllers\TokenController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('users.index');
});

Route::prefix('users')->group(function() {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::post('/', [UserController::class, 'store'])->name('users.store')->middleware('api_key');
    Route::get('/create', [UserController::class, 'create'])->name('users.create');
    Route::get('/{id}', [UserController::class, 'show'])->name('users.show');
});

Route::get('/token', [TokenController::class, 'getToken']);