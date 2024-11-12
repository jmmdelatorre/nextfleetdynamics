<?php
// routes/routes_book_ticket.php

return [
    'BookTicket' => function () {
        require_once __DIR__ . '/../controllers/BookTicketController.php';
        $controller = new BookTicketController();
        $controller->index();
    },
    'BookTicket/search' => function () {
        require_once __DIR__ . '/../controllers/BookTicketController.php';
        $controller = new BookTicketController();
        if (isset($_GET['departure']) && isset($_GET['destination'])) {
            $controller->search($_GET['departure'], $_GET['destination']);
        } else {
            echo "Please select both Departure and Destination.";
        }
    },
    'BookTicket/confirmBooking' => function () {
        require_once __DIR__ . '/../controllers/BookTicketController.php';
        $controller = new BookTicketController();
        $controller->confirmBooking();
    },
    'BookTicket/bookingQRCode' => function () {
        require_once __DIR__ . '/../controllers/BookTicketController.php';
        $controller = new BookTicketController();
        if (isset($_GET['reference'])) {
            $controller->bookingQRCode($_GET['reference']);
        } else {
            echo "Reference is required for QRCode.";
        }
    },
];
