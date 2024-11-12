<?php
// routes/routes_schedules.php

return [
    'ManageSchedules' => function () {
        require_once __DIR__ . '/../controllers/SchedulesController.php';
        $controller = new SchedulesController();
        $controller->index();
    },
    'ManageSchedules/add' => function () {
        require_once __DIR__ . '/../controllers/SchedulesController.php';
        $controller = new SchedulesController();
        $controller->add();
    },
    'ManageSchedules/list' => function () {
        require_once __DIR__ . '/../controllers/SchedulesController.php';
        $controller = new SchedulesController();
        $controller->list();
    },
    'ManageSchedules/update' => function () {
        require_once __DIR__ . '/../controllers/SchedulesController.php';
        $controller = new SchedulesController();
        $controller->update();
    },
    'ManageSchedules/delete' => function () {
        require_once __DIR__ . '/../controllers/SchedulesController.php';
        $controller = new SchedulesController();
        if (isset($_GET['id'])) {
            $controller->delete($_GET['id']);
        } else {
            echo "Schedule ID is required for deletion.";
        }
    },
];
