<?php
// controllers/HomeController.php

require_once __DIR__ . '/../models/User.php';

class HomeController {
    public function index() {
        $userModel = new User();
        $users = $userModel->getAllUsers();
        require __DIR__ . '/../views/home.php';
    }
}
