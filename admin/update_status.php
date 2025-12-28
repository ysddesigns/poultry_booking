<?php
require_once '../config/db.php';
session_start();

// Auth Check
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index');
    exit;
}

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = (int) $_GET['id'];
    $status = $_GET['status'];
    
    // Whitelist status
    $allowed_statuses = ['confirmed', 'cancelled', 'pending', 'completed'];
    
    if (in_array($status, $allowed_statuses)) {
        try {
            $pdo = getDBConnection();
            $stmt = $pdo->prepare("UPDATE bookings SET status = ? WHERE id = ?");
            $stmt->execute([$status, $id]);
        } catch (PDOException $e) {
            // In a real app, flash an error message
            error_log($e->getMessage());
        }
    }
}

// Redirect back to dashboard
header('Location: dashboard');
exit;
