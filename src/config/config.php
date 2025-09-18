<?php

// Require Composer's autoloader to autoload dependencies
require_once __DIR__ . '/../../vendor/autoload.php';

// Load environment variables from .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

// Database configuration
$host = $_ENV['DB_HOST'];
$dbname = $_ENV['DB_NAME'];
$username = $_ENV['DB_USER'];
$password = $_ENV['DB_PASSWORD'];

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host={$host};dbname={$dbname}", $username, $password);

    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Optionally, you can set other PDO attributes here

} catch (PDOException $e) {
    // Handle database connection errors
    die("Error connecting to the database: " . $e->getMessage());
}
