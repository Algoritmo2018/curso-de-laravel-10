<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SupportController;

Route::apiResource('/supports', SupportController::class);
