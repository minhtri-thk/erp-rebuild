<?php

return [
    // guard_name = api
    'api' => [
        'ActivityLogController' => [
            'activity_log-list' => ['list'],
        ],
        'MenuController' => [],
        'DepartmentController' => [
            'department-list' => ['index'],
            'department-store' => ['store'],
            'department-show' => ['show'],
            'department-update' => ['update'],
            'department-delete' => ['destroy'],
        ],
        'PermissionController' => [
            'permission-list' => ['index'],
            'permission-store' => ['store'],
            'permission-show' => ['show'],
            'permission-update' => ['update'],
            'permission-delete' => ['destroy'],
        ],
        'RoleController' => [
            'role-list' => ['index'],
            'role-store' => ['store'],
            'role-show' => ['show'],
            'role-update' => ['update'],
            'role-delete' => ['destroy'],
        ],
        'UserController' => [
            'user-list' => ['index'],
            'user-store' => ['store'],
            'user-show' => ['show'],
            'user-update' => ['update'],
            'user-delete' => ['destroy'],
            'user-profile' => ['profile'],
        ],
    ],
    // guard_name = web
    'web' => [],
];
