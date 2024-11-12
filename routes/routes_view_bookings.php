<?php
// routes/routes_view_bookings.php

return [
    'ViewBookings' => function () {
        require_once __DIR__ . '/../controllers/BookingController.php';
        $controller = new BookingController();
        $controller->index();
    },
    'admin/Bookings' => function () {
        require_once __DIR__ . '/../controllers/BookingController.php';
        $controller = new BookingController();
        $controller->bookings();
    },
    'BookingHistory' => function () {
        require_once __DIR__ . '/../controllers/BookingController.php';
        $controller = new BookingController();
        $controller->bookingHistory();
    },
];
