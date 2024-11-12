<?php
// routes/routes_drivers.php

return [
    'ManageDrivers' => function () {
        require_once __DIR__ . '/../controllers/DriversController.php';
        $controller = new DriversController();
        $controller->index();
    },
    'ManageDrivers/add' => function () {
        require_once __DIR__ . '/../controllers/DriversController.php';
        $controller = new DriversController();
        $controller->add();
    },
    'ManageDrivers/list' => function () {
        require_once __DIR__ . '/../controllers/DriversController.php';
        $controller = new DriversController();
        $controller->list();
    },
    'ManageDrivers/update' => function () {
        require_once __DIR__ . '/../controllers/DriversController.php';
        $controller = new DriversController();
        $controller->update();
    },
    'ManageDrivers/delete' => function () {
        require_once __DIR__ . '/../controllers/DriversController.php';
        $controller = new DriversController();
        if (isset($_GET['id'])) {
            $controller->delete($_GET['id']);
        } else {
            echo "Driver ID is required for deletion.";
        }
    },
];
