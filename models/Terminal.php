<?php
// models/Terminal.php

class Terminal
{
    private $db;

    public function __construct()
    {
        $this->db = dbConnect();
    }

    public function getAllTerminals()
    {
        $query = "SELECT * FROM terminals";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTerminalById($id)
    {
        $query = "SELECT * FROM terminals WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addTerminal($terminalData)
    {
        $query = "INSERT INTO terminals (terminal_name, location, status) 
                  VALUES (:terminal_name, :location, :status)";
        $stmt = $this->db->prepare($query);
        $stmt->execute($terminalData);
        return $this->db->lastInsertId();
    }

    public function updateTerminal($terminalData)
    {
        $query = "UPDATE terminals SET terminal_name = :terminal_name, location = :location,
                status = :status WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute($terminalData);
    }

    public function deleteTerminal($id)
    {
        $query = "DELETE FROM terminals WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
