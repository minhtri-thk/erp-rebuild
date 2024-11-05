<?php

use App\Http\Controllers\Api\V1\ActivityLogs\ActivityLogController;
use App\Http\Controllers\Api\V1\MenuController;

// Activity Log
Route::get('activity-logs/list', [ActivityLogController::class, 'list']);

// Menu
Route::get('menus/list-translation', [MenuController::class, 'listTranslation'])->name('menus.list-translation');
