<?php
// routes/routes_terminals.php

return [
    'ManageTerminals' => function () {
        require_once __DIR__ . '/../controllers/TerminalController.php';
        $controller = new TerminalController();
        $controller->index();
    },
    'ManageTerminals/add' => function () {
        require_once __DIR__ . '/../controllers/TerminalController.php';
        $controller = new TerminalController();
        $controller->add();
    },
    'ManageTerminals/list' => function () {
        require_once __DIR__ . '/../controllers/TerminalController.php';
        $controller = new TerminalController();
        $controller->list();
    },
    'ManageTerminals/update' => function () {
        require_once __DIR__ . '/../controllers/TerminalController.php';
        $controller = new TerminalController();
        $controller->update();
    },
    'ManageTerminals/delete' => function () {
        require_once __DIR__ . '/../controllers/TerminalController.php';
        $controller = new TerminalController();
        if (isset($_GET['id'])) {
            $controller->delete($_GET['id']);
        } else {
            echo "Terminal ID is required for deletion.";
        }
    },
];
