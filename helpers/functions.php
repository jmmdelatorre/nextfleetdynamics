<?php
// helpers/functions.php

function dbConnect() {
    $config = require __DIR__ . '/../config/config.php';
    try {
        return new PDO(
            "mysql:host=" . $config['db']['host'] . ";dbname=" . $config['db']['dbname'],
            $config['db']['user'],
            $config['db']['pass']
        );
    } catch (PDOException $e) {
        die("Database connection error: " . $e->getMessage());
    }
}
