<?php
session_start();

// Check if user has moderator or admin role
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'mod' && $_SESSION['role'] !== 'admin')) {
    // Include 403 Forbidden page
    include '../../forbidden.php';
    // Stop further execution
    exit;
}
header('Location: dashboard');
