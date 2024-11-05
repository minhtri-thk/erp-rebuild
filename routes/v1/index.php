<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Permissions\PermissionController;
use App\Http\Controllers\Api\V1\Roles\RoleController;
use App\Http\Controllers\Api\V1\Users\UserController;
use App\Http\Controllers\Api\V1\Departments\DepartmentController;

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    // User
    Route::get('users/profile', [UserController::class, 'profile']);    
    Route::apiResource('users', UserController::class)->names('users');

    // Roles and Permission
    Route::apiResource('permissions', PermissionController::class)->names('permissions');
    Route::apiResource('roles', RoleController::class)->names('roles');

    // Department
    Route::apiResource('departments', DepartmentController::class);
});