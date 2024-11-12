<?php
// controllers/BookTicketController.php

require_once __DIR__ . '/../models/Terminal.php'; // Include the Terminal model
require_once __DIR__ . '/../models/Schedule.php'; // Include the Schedule model
require_once __DIR__ . '/../vendor/autoload.php'; // Adjust the path as necessary

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\ValidationException;

class BookTicketController
{
    private $terminalModel;
    private $scheduleModel;

    public function __construct()
    {
        $this->terminalModel = new Terminal();
        $this->scheduleModel = new Schedule();
    }

    public function index()
    {
        // Check if the user is authenticated
        if (!isset($_SESSION['user_id'])) {
            // Redirect to login page
            header("Location: index.php?url=Login");
            exit;
        }

        $navigations = getNavigations();
        $terminals = $this->terminalModel->getAllTerminals();
        require __DIR__ . '/../views/passenger/BookTicketPage.php';
    }
    public function search($departure, $destination)
    {
        $schedules = $this->scheduleModel->getAllSchedulesWithFilter($departure, $destination);
        header('Content-Type: application/json');
        echo json_encode($schedules);
        exit;
    }
    public function confirmBooking()
    {
        $bookingData = [
            'scheduleId' => $_POST['scheduleId'],
            'seatQuantity' => $_POST['seatQuantity'],
            'totalFare' => $_POST['totalFare'],
            'paymentMethod' => 'Credit Card',
            'cardholderName' => $_POST['cardholderName'],
            'cardNumber' => $_POST['cardNumber'],
            'expiryDate' => $_POST['expiryDate'],
            'cvv' => $_POST['cvv'],
        ];
        $referenceNumber = $this->scheduleModel->confirmBooking($bookingData);

        // Prepare JSON response
        header('Content-Type: application/json');
        if ($referenceNumber) {
            echo json_encode(['success' => true, 'message' => 'Booking added successfully.', 'referenceNumber' => $referenceNumber]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to confirm booking.']);
        }
        exit;
    }

    public function bookingQRCode($reference)
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $baseUrl = $protocol . '://' . $_SERVER['HTTP_HOST'];
        $validityCheckUrl = $baseUrl . '/public/index.php?url=CheckValidity&reference=' . urlencode($reference);

        $qrCodeDataUrl = '';

        if (!empty($validityCheckUrl)) {
            // Create a QR Code
            $qrCode = new QrCode(
                data: $validityCheckUrl,
                encoding: new Encoding('UTF-8'),
                errorCorrectionLevel: ErrorCorrectionLevel::Low,
                size: 300,
                margin: 10,
                roundBlockSizeMode: RoundBlockSizeMode::Margin,
                foregroundColor: new Color(0, 0, 0),
                backgroundColor: new Color(255, 255, 255)
            );

            // Optional: Create a logo if needed
            // Uncomment the lines below and replace with your logo path
            /*
            $logo = new Logo(
                path: __DIR__ . '/assets/symfony.png', // Path to your logo
                resizeToWidth: 50,
                punchoutBackground: true
            );
            */

            // Optional: Create a label if needed
            // Uncomment the lines below and customize as necessary
            /*
            $label = new Label(
                text: 'Your Label Here',
                textColor: new Color(255, 0, 0) // Label text color
            );
            */

            // Create a writer instance
            $writer = new PngWriter();

            // Write the QR code result
            // If you include a logo and label, uncomment the next line
            // $result = $writer->write($qrCode, $logo, $label);
            $result = $writer->write($qrCode); // Without logo and label

            // Get the data URI for the QR code image
            $qrCodeDataUrl = $result->getDataUri();
        }

        $navigations = getNavigations();
        require __DIR__ . '/../views/passenger/BookingQRCode.php';
    }
}
