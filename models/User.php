<?php
// models/User.php

class User {
    private $db;

    public function __construct() {
        $this->db = dbConnect();
    }

    public function getAllUsers() {
        $stmt = $this->db->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
