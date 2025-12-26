<?php
/**
 * REVOLUTION OF BLISS: The Sovereign Engine
 * The Baton (index.php) - Directing the Symphony
 */

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
// The Conductor takes the stage: uses the composer's work
require ROOT_PATH . 'vendor/autoload.php';

// Import the Logger
// Using "Aliasing" to keep the names clean and meaningful
use Gateway\App as Gateway;
use Nexus\Logger;
use Nexus\Engine;

$global_data = require CONFIG_PATH . 'global.php';

try {
    // This is the litmus test
    Logger::log("Engine " . Engine::getVersion() . " checking in.");
    echo "Success: Logger and Engine are online.";
} catch (\Throwable $e) {
    echo "Critical Failure: " . $e->getMessage();
}

// Determine BASE_URL for assets
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
define('BASE_URL', $protocol . $_SERVER['HTTP_HOST'] . '/revolutionofbliss-php/');

// 3. DISCOVERY: Hand the site_map to the Gateway to find the Spoke
// // We use require (not require_once) to ensure the array is returned to the variable
$site_keyword = Gateway::discover();

// 4. Identification Logic
// If discovery failed to find a keyword, fallback to hub_main
if (empty($site_keyword)) {
    $site_keyword = 'hub_main';
    Logger::log("Routing: No specific site found, defaulting to hub_main", "INFO");
}

// Logger log: Track which "Spoke" is being activated
Logger::log("Routing: Identified site keyword [$site_keyword]");

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

// Logger log: Final milestone
Logger::log("Rendering template for site: " . ($title ?? 'Unknown'));

// FINAL STEP: Load the template only after all variables exist
include TEMPLATE_PATH . 'main.php';