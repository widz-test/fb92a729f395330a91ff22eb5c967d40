<?php

namespace App;

use Core\Foundation\Database\Database;

class Application {
    public function __construct() {
        // Load env
        $this->loadConfig();

        // Init database
        $this->initDatabase();
    }

    private function loadConfig() {
        $dotenv = \Dotenv\Dotenv::createImmutable(dirname(__FILE__, 2));
        $dotenv->load();
    }

    private function initDatabase() {
        $database = new Database(env('APP_ENV', 'development'), 0);
        $database->init();
    }
}