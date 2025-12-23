<?php
/**
 * REVOLVING ENGINE - Multi-Tenant Bootstrap
 */
define('CORE', true);
require __DIR__ . '/vendor/autoload.php';

// 1. Directory & Pathing
define('DS', DIRECTORY_SEPARATOR);
define('ROOT_PATH', __DIR__ . DS);
define('CONFIG_PATH', ROOT_PATH . 'config' . DS);
define('TEMPLATE_PATH', ROOT_PATH . 'templates' . DS);

// Determine BASE_URL for assets
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
define('BASE_URL', $protocol . $_SERVER['HTTP_HOST'] . '/revolutionofbliss-php/');

// 2. Load Global Data & Mapping
$site_map = require_once CONFIG_PATH . 'map.php';
$global_data = require_once CONFIG_PATH . 'global.php';

// 3. Identification Logic (Mapping vs Override)
$site_keyword = '';

// Mandatory Feature: Query Parameter Override
if (isset($_GET['site']) && !empty($_GET['site'])) {
    $site_keyword = preg_replace('/[^a-zA-Z0-9_-]/', '', $_GET['site']);
} else {
    $host = $_SERVER['HTTP_HOST'];
    $site_keyword = $site_map[$host] ?? 'default'; 
}

// 4. Load Site-Specific Config
$config_file = CONFIG_PATH . $site_keyword . '.php';

if (file_exists($config_file)) {
    $site_data = require_once $config_file;
} else {
    // Fallback if site config is missing
    $site_data = ['title' => 'Error', 'content' => 'Site configuration not found.'];
}

// 5. Merge Data & Presentation
// Combine global data and site data (site data takes precedence)
$final_data = array_merge($global_data, $site_data);

// Inject variables into the local scope for the template
extract($final_data);

// Load the master template (or route to specific views based on URI)
include TEMPLATE_PATH . 'main.php';