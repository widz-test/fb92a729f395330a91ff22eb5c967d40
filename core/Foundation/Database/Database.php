<?php

namespace Core\Foundation\Database;

use Core\Foundation\Config\Config;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Builder;
use Phinx\Migration\AbstractMigration;

class Database extends AbstractMigration {
    protected Capsule $capsule;
    protected Builder $schema;

    public function init() {
        $this->capsule = new Capsule;
        $config = Config::get('database.connections.pgsql');
        try {
            $this->capsule->addConnection(
                $this->pgsqlConfig($config)
            );
            $this->capsule->setAsGlobal();
            $this->capsule->bootEloquent();
            $this->schema = $this->capsule->schema();
        } catch(\Exception $e) {
            error_log('Connection database failed: '.$e->getMessage());
        }
    }

    protected function pgsqlConfig(array $config = []): array {
        return [
            'driver' => data_get($config, 'driver'),
            'host' => data_get($config, 'host'),
            'database' => data_get($config, 'database'),
            'username' => data_get($config, 'username'),
            'password' => data_get($config, 'password'),
        ];
    }
}