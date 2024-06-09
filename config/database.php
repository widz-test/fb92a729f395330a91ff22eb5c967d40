<?php

return [
    'connections' => [
        'pgsql' => [
            'driver' => env('DB_CONNECTION', 'pgsql'),
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', '')
        ],
    ],
];