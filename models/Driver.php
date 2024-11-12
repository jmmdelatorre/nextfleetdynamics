<?php
// models/Driver.php

class Driver
{
    private $db;

    public function __construct()
    {
        $this->db = dbConnect();
    }

    public function getAllDrivers()
    {
        $query = "SELECT * FROM drivers";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDriverById($id)
    {
        $query = "SELECT * FROM drivers WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addDriver($driverData)
    {
        $query = "INSERT INTO drivers (name, license_number, status) 
                  VALUES (:name, :license_number, :status)";
        $stmt = $this->db->prepare($query);
        $stmt->execute($driverData);
        return $this->db->lastInsertId();
    }

    public function updateDriver($driverData)
    {
        $query = "UPDATE drivers SET name = :name, license_number = :license_number,
                 status = :status WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute($driverData);
    }

    public function deleteDriver($id)
    {
        $query = "DELETE FROM drivers WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
