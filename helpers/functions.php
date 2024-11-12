<?php
// helpers/functions.php

function dbConnect()
{
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

function logDebug($message)
{
    $logFile = __DIR__ . '/../logs/debug.log'; 
    $timestamp = date('Y-m-d H:i:s');
    $formattedMessage = "[{$timestamp}] DEBUG: {$message}\n";

    file_put_contents($logFile, $formattedMessage, FILE_APPEND);
}

function getNavigations()
{
    // Start the session if not already started
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Get the database connection
    $db = dbConnect();
    $query = "SELECT * FROM navigations WHERE positionsAllowed IN (0, :position_id) AND isActive = 1 ORDER BY displayOrder ASC";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':position_id', $_SESSION['position_id'], PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
