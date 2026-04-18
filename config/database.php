<?php
/**
 * Database Configuration
 */
// Set error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

return [
    'host' => 'localhost',  // Database host (leave as localhost for local setup)
    'port' => 3306,         // Default MySQL port is 3306 (adjust if using a different port)
    'dbname' => 'code_gaming',  // Your database name
    'username' => 'root',      // Default XAMPP MySQL username
    'password' => '',          // Default XAMPP MySQL password is empty
    'charset' => 'utf8mb4',    // Character set
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ],
];
