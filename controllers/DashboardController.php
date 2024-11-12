<?php
// controllers/DashboardController.php


class DashboardController
{
    public function index()
    {
        if (isset($_SESSION['position_id'])) {
            if ($_SESSION['position_id'] == 1) {
                header("Location: index.php?url=admin/Dashboard");
                exit;
            } elseif ($_SESSION['position_id'] == 2) {
                header("Location: index.php?url=passenger/Dashboard");
                exit;
            } else {
                require __DIR__ . '/../views/LandingPage.php';
            }
        } else {
            require __DIR__ . '/../views/LandingPage.php';
        }
    }
}
