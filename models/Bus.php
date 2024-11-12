<?php
// models/Bus.php

class Bus
{
    private $db;

    public function __construct()
    {
        $this->db = dbConnect();
    }

    public function getAllBuses()
    {
        $query = "SELECT * FROM buses";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBusById($id)
    {
        $query = "SELECT * FROM buses WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addBus($busData)
    {
        $query = "INSERT INTO buses (bus_name, license_plate, capacity, status) 
                  VALUES (:bus_name, :license_plate, :capacity, :status)";
        $stmt = $this->db->prepare($query);
        $stmt->execute($busData);
        return $this->db->lastInsertId();
    }

    public function updateBus($busData)
    {
        $query = "UPDATE buses SET bus_name = :bus_name, license_plate = :license_plate, capacity = :capacity,
                status = :status WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute($busData);
    }

    public function deleteBus($id)
    {
        $query = "DELETE FROM buses WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
