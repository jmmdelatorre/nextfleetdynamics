<?php
// controllers/UserAccountController.php


class UserAccountController
{
    public function index()
    {
        // Check if the user is authenticated
        if (!isset($_SESSION['user_id'])) {
            // Redirect to login page
            header("Location: index.php?url=Login");
            exit; 
        }

        // User is authenticated, load the dashboard
        require __DIR__ . '/../views/admin/Dashboard.php';
    }
}
