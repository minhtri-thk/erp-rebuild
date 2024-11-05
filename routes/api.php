<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ChangeLanguage;
use App\Http\Controllers\Api\V1\Auth\AuthController;

Route::middleware(ChangeLanguage::class)->group(function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('register', [AuthController::class, 'register']);
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);

        include_once ('v1/index.php');
        include_once ('utils/index.php');
    });
});
