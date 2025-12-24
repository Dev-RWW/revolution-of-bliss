<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 * REVOLVING ENGINE - Multi-Tenant Bootstrap
 */
define('CORE', true);

// 1. Directory & Pathing
define('DS', DIRECTORY_SEPARATOR);
define('ROOT_PATH', __DIR__ . DS);
define('CONFIG_PATH', ROOT_PATH . 'config' . DS);
define('TEMPLATE_PATH', ROOT_PATH . 'templates' . DS);

// 2. Load Autoloader & Dependencies
require ROOT_PATH . 'vendor/autoload.php';

// Determine BASE_URL for assets
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
define('BASE_URL', $protocol . $_SERVER['HTTP_HOST'] . '/revolutionofbliss-php/');

// 3. Load Mapping & Global Data
// We use require (not require_once) to ensure the array is returned to the variable
$site_map = require CONFIG_PATH . 'map.php';
$global_data = require CONFIG_PATH . 'global.php';

// 4. Identification Logic
$site_keyword = '';
if (isset($_GET['site']) && !empty($_GET['site'])) {
    $site_keyword = preg_replace('/[^a-zA-Z0-9_-]/', '', $_GET['site']);
} else {
    $host = $_SERVER['HTTP_HOST'];
    $site_keyword = $site_map[$host] ?? 'hub_main'; 
}

// 5. Load Site-Specific Config
$config_file = CONFIG_PATH . $site_keyword . '.php';
if (file_exists($config_file)) {
    $site_data = require $config_file;
} else {
    $site_data = ['title' => 'Error', 'content' => 'Site configuration not found.'];
}

// 6. Data Assembly
// Force them to be arrays to prevent the array_merge crash
$global_data = is_array($global_data) ? $global_data : [];
$site_data = is_array($site_data) ? $site_data : [];

$final_data = array_merge($global_data, $site_data);

// 7. Inject Variables & Render
// This turns ['title' => '...'] into $title for the template
extract($final_data);
$current_year = date('Y');

// FINAL STEP: Load the template only after all variables exist
include TEMPLATE_PATH . 'main.php';