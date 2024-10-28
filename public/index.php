<?php
// public/index.php

require_once __DIR__ . '/../helpers/functions.php';

$request = $_GET['url'] ?? 'home';

switch ($request) {
    case 'home':
        require_once __DIR__ . '/../controllers/HomeController.php';
        $controller = new HomeController();
        $controller->index();
        break;
    default:
        http_response_code(404);
        echo "404 - Page Not Found";
        break;
}
