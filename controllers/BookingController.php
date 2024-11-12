<?php
// controllers/BookingController.php

require_once __DIR__ . '/../models/Booking.php'; // Include the Booking model

class BookingController
{
    private $bookingModel;

    public function __construct()
    {
        $this->bookingModel = new Booking();
    }

    public function index()
    {
        $navigations = getNavigations();
        $presentBookings = $this->bookingModel->getPresentBookingsPerUser();
        require __DIR__ . '/../views/passenger/ViewBookings.php';
    }

    public function bookings()
    {
        $navigations = getNavigations();
        $presentBookings = $this->bookingModel->getPresentBookings();
        require __DIR__ . '/../views/admin/Bookings.php';
    }

    public function bookingHistory()
    {
        $navigations = getNavigations();
        $bookingHistory = $this->bookingModel->getPastBookingsPerUser();
        require __DIR__ . '/../views/passenger/BookingHistory.php';
    }

    public function checkValidity()
    {
        logDebug($_GET['reference']);
        if (isset($_GET['reference'])) {
            $checkValidity = $this->bookingModel->checkValidity($_GET['reference']);
            require __DIR__ . '/../views/CheckValidity.php';
        } else {
            header("Location: index.php?url=admin/Dashboard");
        }
    }
}
