<?php
// models/Booking.php

class Booking
{
    private $db;

    public function __construct()
    {
        $this->db = dbConnect();
    }

    public function getPresentBookingsPerUser()
    {
        $query = "SELECT *, 
        departure_terminal.terminal_name as departure, 
        destination_terminal.terminal_name as destination,
        s.date, s.time
            FROM bookings b 
            JOIN schedules s ON b.schedule_id = s.id 
            JOIN terminals departure_terminal ON s.departure_terminal_id = departure_terminal.id
            JOIN terminals destination_terminal ON s.destination_terminal_id = destination_terminal.id
            WHERE b.user_id = :user_id 
            AND s.date >= CURRENT_DATE";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPresentBookings()
    {
        $query = "SELECT *, 
        departure_terminal.terminal_name as departure, 
        destination_terminal.terminal_name as destination,
        s.date, s.time, SUM(b.quantity) as total_quantity
            FROM bookings b 
            JOIN schedules s ON b.schedule_id = s.id 
            JOIN terminals departure_terminal ON s.departure_terminal_id = departure_terminal.id
            JOIN terminals destination_terminal ON s.destination_terminal_id = destination_terminal.id
            WHERE s.date >= CURRENT_DATE
            GROUP BY b.schedule_id";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPastBookingsPerUser()
    {
        $query = "SELECT *, 
        departure_terminal.terminal_name as departure, 
        destination_terminal.terminal_name as destination,
        s.date, s.time
            FROM bookings b 
            JOIN schedules s ON b.schedule_id = s.id 
            JOIN terminals departure_terminal ON s.departure_terminal_id = departure_terminal.id
            JOIN terminals destination_terminal ON s.destination_terminal_id = destination_terminal.id
            WHERE b.user_id = :user_id 
            AND s.date < CURRENT_DATE";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function checkValidity($reference_number)
    {
        $query = "SELECT *, 
            departure_terminal.terminal_name as departure, 
            destination_terminal.terminal_name as destination,
            s.date, s.time, CONCAT(u.first_name, ' ',  u.last_name) as user_name
            FROM bookings b
            JOIN users u ON b.user_id = u.id 
            JOIN schedules s ON b.schedule_id = s.id 
            JOIN terminals departure_terminal ON s.departure_terminal_id = departure_terminal.id
            JOIN terminals destination_terminal ON s.destination_terminal_id = destination_terminal.id
            WHERE b.reference_number = :reference_number";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':reference_number', $reference_number);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
