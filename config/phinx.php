<?php

$dotenv = \Dotenv\Dotenv::createImmutable(dirname(__FILE__, 2));
$dotenv->load();
return [
  'paths' => [
    'migrations' => dirname(__FILE__, 2).'/database/migrations'
  ],
  'migration_base_class' => dirname(__FILE__, 2).'\core\Foundation\Database\Database',
  'environments' => [
    'default_migration_table' => 'migrations',
    'dev' => [
      'adapter' => env('DB_CONNECTION', 'pgsql'),
      'host' => env('DB_HOST', '127.0.0.1'),
      'name' => env('DB_DATABASE', 'forge'),
      'user' => env('DB_USERNAME', 'forge'),
      'pass' => env('DB_PASSWORD', ''),
      'port' => env('DB_PORT', '5432')
    ]
  ]
];