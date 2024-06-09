<?php 

namespace Core\Foundation\Config;

class Config {
    private static $filePath;
    private static $keys = [];
    private static $config = [];

    static public function get(string $key, $default = null) {
        // Get config by load file
        self::load($key);
        // Get config value by key
        $value = self::$config;
        foreach (self::$keys as $key) {
            if (is_array($value) && array_key_exists($key, $value)) {
                $value = $value[$key];
            } else {
                return $default;
            }
        }
        return $value;
    }

    static private function load($key) {
        if ($key) {
            $exploded = explode('.', $key);
            if (count($exploded) >= 1) {
                self::$filePath = './config/'.$exploded[0].'.php';
                array_shift($exploded);
                self::$keys = $exploded;
            }
        }
        if (self::$filePath && file_exists(self::$filePath)) {
            self::$config = require(self::$filePath);
        }
    }
}