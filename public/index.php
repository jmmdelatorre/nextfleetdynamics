<?php
// public/index.php

require_once __DIR__ . '/../helpers/functions.php';
$request = $_GET['url'] ?? 'LandingPage';
logDebug($request);

// Start session if it hasn't been started yet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Initialize the master routes array
$routes = [];

// Load all route files dynamically from the routes directory
foreach (glob(__DIR__ . '/../routes/*.php') as $routeFile) {
    $moduleRoutes = require $routeFile;
    $routes = array_merge($routes, $moduleRoutes);
}

// Execute the corresponding route function
if (array_key_exists($request, $routes)) {
    $routes[$request]();
} else {
    require_once __DIR__ . '/../controllers/LandingPageController.php';
    $controller = new LandingPageController();
    $controller->pageNotFound();
}
