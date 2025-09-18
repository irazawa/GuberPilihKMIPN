<?php
// Start session if it hasn't been started yet
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user has moderator or admin role
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'mod' && $_SESSION['role'] !== 'admin')) {
    // Include 403 Forbidden page
    include '../../forbidden.php';
    // Stop further execution
    exit;
}

// Include the database configuration file
include '../../config/config.php';

// Check if party ID is provided via POST request
if (isset($_POST['partyId'])) {
    // Get party ID from POST request
    $partyId = $_POST['partyId'];

    // Delete party from database based on party ID
    $sql = "DELETE FROM dbpartai WHERE Id = :partyId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':partyId', $partyId, PDO::PARAM_INT);

    // Execute the delete query
    if ($stmt->execute()) {
        // Return success response
        http_response_code(204); // No content
        exit();
    } else {
        // Return error response
        http_response_code(500); // Internal Server Error
        exit();
    }
} else {
    // Return error response for missing party ID
    http_response_code(400);
    exit();
}
