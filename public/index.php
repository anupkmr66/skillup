<?php
/**
 * Application Entry Point
 */

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Autoloader
spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/../core/' . $class . '.php',
        __DIR__ . '/../app/Controllers/' . $class . '.php',
        __DIR__ . '/../app/Models/' . $class . '.php',
        __DIR__ . '/../app/Middleware/' . $class . '.php',
    ];

    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

// Load configuration
require __DIR__ . '/../config/constants.php';
require __DIR__ . '/../app/Helpers/helpers.php';

// Start session
Session::start();

// Initialize router
$router = new Router();

// Load routes
require __DIR__ . '/../routes/web.php';

// Dispatch request
$router->dispatch();
