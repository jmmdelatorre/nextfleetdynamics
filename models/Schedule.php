<?php
// models/Schedule.php

class Schedule
{
    private $db;

    public function __construct()
    {
        $this->db = dbConnect();
    }

    public function getAllSchedules()
    {
        $query = "SELECT s.*, 
                         d.name AS driver_name, 
                         b.bus_name, 
                         b.capacity, 
                         dt1.terminal_name AS departure_terminal, 
                         dt2.terminal_name AS destination_terminal 
                  FROM schedules s
                  JOIN drivers d ON s.driver_id = d.id
                  JOIN buses b ON s.bus_id = b.id
                  JOIN terminals dt1 ON s.departure_terminal_id = dt1.id
                  JOIN terminals dt2 ON s.destination_terminal_id = dt2.id
                  WHERE s.date >= CURRENT_DATE";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllSchedulesWithFilter($departure, $destination)
    {
        $query = "SELECT s.*, 
                 d.name AS driver_name, 
                 b.bus_name, 
                 b.capacity, 
                 dt1.terminal_name AS departure_terminal, 
                 dt2.terminal_name AS destination_terminal,
                 (b.capacity - IFNULL(SUM(bk.quantity), 0)) AS remaining_seats
          FROM schedules s
          JOIN drivers d ON s.driver_id = d.id
          JOIN buses b ON s.bus_id = b.id
          JOIN terminals dt1 ON s.departure_terminal_id = dt1.id
          JOIN terminals dt2 ON s.destination_terminal_id = dt2.id
          LEFT JOIN bookings bk ON s.id = bk.schedule_id
          WHERE s.departure_terminal_id = :departure 
            AND s.destination_terminal_id = :destination
            AND s.date >= CURRENT_DATE
          GROUP BY s.id";


        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':departure', $departure);
        $stmt->bindParam(':destination', $destination);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getScheduleById($id)
    {
        $query = "SELECT * FROM schedules WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addSchedule($scheduleData)
    {
        $query = "INSERT INTO schedules (date, time, departure_terminal_id, destination_terminal_id, bus_id, driver_id, fare) 
                  VALUES (:date, :time, :departure_terminal_id, :destination_terminal_id, :bus_id, :driver_id, :fare)";
        $stmt = $this->db->prepare($query);
        $stmt->execute($scheduleData);
        return $this->db->lastInsertId();
    }

    public function updateSchedule($scheduleData)
    {
        $query = "UPDATE schedules SET date = :date, time = :time, 
                  departure_terminal_id = :departure_terminal_id, 
                  destination_terminal_id = :destination_terminal_id, 
                  bus_id = :bus_id, driver_id = :driver_id, fare = :fare 
                  WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute($scheduleData);
    }

    public function deleteSchedule($id)
    {
        $query = "DELETE FROM schedules WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function confirmBooking($bookingData)
    {
        try {
            // Start a transaction
            $this->db->beginTransaction();

            // Step 1: Insert into bookings table
            $referenceNumber = uniqid('BOOKING_'); // Generate a unique reference number

            $bookingQuery = "INSERT INTO bookings (user_id, schedule_id, fare, quantity, reference_number, booking_date)
                         VALUES (:userId, :scheduleId, :fare, :quantity, :referenceNumber, NOW())";

            $bookingStmt = $this->db->prepare($bookingQuery);
            logDebug($_SESSION['user_id']);
            // Bind parameters for booking
            $bookingStmt->bindParam(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
            $bookingStmt->bindParam(':scheduleId', $bookingData['scheduleId'], PDO::PARAM_INT);
            $bookingStmt->bindParam(':fare', $bookingData['totalFare']);
            $bookingStmt->bindParam(':quantity', $bookingData['seatQuantity'], PDO::PARAM_INT);
            $bookingStmt->bindParam(':referenceNumber', $referenceNumber);

            $bookingStmt->execute();

            // Get the last inserted booking ID
            $bookingId = $this->db->lastInsertId();

            // Step 2: Insert into payments table
            $paymentQuery = "INSERT INTO payments (booking_id, amount, payment_date, payment_method, cardholder_name, card_number, expiry_date, cvv)
                         VALUES (:bookingId, :amount, NOW(), :paymentMethod, :cardholderName, :cardNumber, :expiryDate, :cvv)";

            $paymentStmt = $this->db->prepare($paymentQuery);

            // Bind parameters for payment
            $paymentStmt->bindParam(':bookingId', $bookingId, PDO::PARAM_INT);
            $paymentStmt->bindParam(':amount', $bookingData['totalFare']);
            $paymentStmt->bindParam(':paymentMethod', $bookingData['paymentMethod']); // Set payment method here
            $paymentStmt->bindParam(':cardholderName', $bookingData['cardholderName']);
            $paymentStmt->bindParam(':cardNumber', $bookingData['cardNumber']);
            $paymentStmt->bindParam(':expiryDate', $bookingData['expiryDate']);
            $paymentStmt->bindParam(':cvv', $bookingData['cvv']);

            $paymentStmt->execute();

            // Commit transaction
            $this->db->commit();

            return $referenceNumber;
        } catch (PDOException $e) {
            // Rollback transaction in case of error
            $this->db->rollBack();
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }
}
