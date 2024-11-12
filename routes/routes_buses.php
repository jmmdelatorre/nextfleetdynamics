<?php
// routes/routes_buses.php

return [
    'ManageBuses' => function () {
        require_once __DIR__ . '/../controllers/BusController.php';
        $controller = new BusController();
        $controller->index();
    },
    'ManageBuses/add' => function () {
        require_once __DIR__ . '/../controllers/BusController.php';
        $controller = new BusController();
        $controller->add();
    },
    'ManageBuses/list' => function () {
        require_once __DIR__ . '/../controllers/BusController.php';
        $controller = new BusController();
        $controller->list();
    },
    'ManageBuses/update' => function () {
        require_once __DIR__ . '/../controllers/BusController.php';
        $controller = new BusController();
        $controller->update();
    },
    'ManageBuses/delete' => function () {
        require_once __DIR__ . '/../controllers/BusController.php';
        $controller = new BusController();
        if (isset($_GET['id'])) {
            $controller->delete($_GET['id']);
        } else {
            echo "Bus ID is required for deletion.";
        }
    },
];
