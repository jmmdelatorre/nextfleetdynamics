<?php
// controllers/LandingPageController.php


class LandingPageController
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
    public function pageNotFound()
    {
        require __DIR__ . '/../views/PageNotFound.php';
    }
}
