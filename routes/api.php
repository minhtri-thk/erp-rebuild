<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ChangeLanguage;


Route::middleware(['auth:sanctum', ChangeLanguage::class])->prefix('v1')->group(function () {


});

