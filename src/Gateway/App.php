<?php
namespace Gateway;

use Nexus\Logger;

class App {
    public static function discover(): string {
        if (isset($_GET['site']) && !empty($_GET['site'])) {
            return strtolower(preg_replace('/[^a-zA-Z0-9_-]/', '', $_GET['site']));
        }

        $host = strtolower(str_replace('www.', '', $_SERVER['HTTP_HOST']));
        
        // Adjusted path to look in the central config folder
        $map_path = __DIR__ . '/../../../config/map.php'; 
        
        if (file_exists($map_path)) {
            $map = require $map_path;
            return $map[$host] ?? 'hub_main';
        }

        return 'hub_main';
    }
}