<?php

return [
    'backup_path' => storage_path('backups'),
    'backup_storage_folder' => false, // true or false
    'keep_days' => 5,
    'database' => [
        'connection' => env('DB_CONNECTION', 'mysql'),
    ],
    'check_access' => false, // true or false
    'allowed_roles' => [], // Role Names Example: ['Admin', 'Super-Admin','Developer', 'Manager']
];
