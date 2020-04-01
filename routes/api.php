<?php

use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SupportController;


Route::post('/login', [AuthController::class, 'auth']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');


Route::middleware(['auth:sanctum'])->group(function (){
    Route::apiResource('/supports', SupportController::class);
});
//Route::apiResource('/supports', SupportController::class)->middleware();
