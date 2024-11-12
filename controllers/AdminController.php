<?php
// controllers/AdminController.php


class AdminController
{
    private $db;

    public function __construct()
    {
        $this->db = dbConnect();
    }

    public function dashboard()
    {
        $navigations = getNavigations();
        require __DIR__ . '/../views/admin/Dashboard.php';
    }

    public function reports()
    {
        $navigations = getNavigations();
        require __DIR__ . '/../views/admin/ViewReports.php';
    }
    public function users()
    {
        $navigations = getNavigations();
        require __DIR__ . '/../views/admin/ManageUsers.php';
    }
    public function profile()
    {
        $navigations = getNavigations();
        require __DIR__ . '/../views/ManageProfile.php';
    }
}
