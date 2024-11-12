<?php
// routes/routes_main.php

return [
    'LandingPage' => function () {
        require_once __DIR__ . '/../controllers/LandingPageController.php';
        $controller = new LandingPageController();
        $controller->index();
    },
    'Dashboard' => function () {
        require_once __DIR__ . '/../controllers/DashboardController.php';
        $controller = new DashboardController();
        $controller->index();
    },
    'UserAccount' => function () {
        require_once __DIR__ . '/../controllers/UserAccountController.php';
        $controller = new UserAccountController();
        $controller->index();
    },
    'Login' => function () {
        require_once __DIR__ . '/../controllers/AuthController.php';
        $controller = new AuthController();
        $controller->login();
    },
    'Register' => function () {
        require_once __DIR__ . '/../controllers/AuthController.php';
        $controller = new AuthController();
        $controller->register();
    },
    'Logout' => function () {
        require_once __DIR__ . '/../controllers/AuthController.php';
        $controller = new AuthController();
        $controller->logout();
    },
    'passenger/Dashboard' => function () {
        require_once __DIR__ . '/../controllers/PassengerController.php';
        $controller = new PassengerController();
        $controller->dashboard();
    },
    'admin/Dashboard' => function () {
        require_once __DIR__ . '/../controllers/AdminController.php';
        $controller = new AdminController();
        $controller->dashboard();
    },
    'CheckValidity' => function () {
        require_once __DIR__ . '/../controllers/BookingController.php';
        $controller = new BookingController();
        $controller->checkValidity();
    },
    'Reports' => function () {
        require_once __DIR__ . '/../controllers/AdminController.php';
        $controller = new AdminController();
        $controller->reports();
    },
    'UserManagement' => function () {
        require_once __DIR__ . '/../controllers/AdminController.php';
        $controller = new AdminController();
        $controller->users();
    },
    'Profile' => function () {
        require_once __DIR__ . '/../controllers/AdminController.php';
        $controller = new AdminController();
        $controller->profile();
    },
];
