<?php
// controllers/PassengerController.php


class PassengerController
{
    private $db;

    public function __construct()
    {
        $this->db = dbConnect();
    }

    public function dashboard()
    {
        $navigations = getNavigations();
        require __DIR__ . '/../views/passenger/Dashboard.php';
    }
}
