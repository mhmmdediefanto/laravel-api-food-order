<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/user', [UserController::class, 'index']);
    Route::post('/user', [UserController::class, 'store'])->middleware('able-create-user');

    Route::get('/items', [ItemController::class, 'index'])->middleware('able-create-item');
    Route::post('/items', [ItemController::class, 'store'])->middleware('able-create-item');
    Route::get('/items/{id}', [ItemController::class, 'show'])->middleware('able-create-item');
    Route::patch('/items/{item}',  [ItemController::class, 'update'])->middleware('able-create-item');
    Route::delete('/items/delete/{id}' , [ItemController::class, 'destroy'])->middleware('able-create-item');

    //order
    Route::post('/order/{id}/set-as-done', [OrderController::class, 'setAsDone'])->middleware('able-finish-order');
    Route::post('/order/{id}/set-as-paid', [OrderController::class, 'setAsPaid'])->middleware('able-pay-order');
    Route::get('/order', [OrderController::class, 'index'])->middleware('able-create-order');
    Route::get('/order/{id}', [OrderController::class, 'showDetail'])->middleware('able-create-order');
    Route::post('/order', [OrderController::class, 'store'])->middleware('able-create-order');
});
