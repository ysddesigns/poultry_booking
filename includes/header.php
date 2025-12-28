<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Poultry Farm Booking</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header>
    <nav>
        <a href="index" class="brand">🐔 Poultry Booking</a>
        <ul>
            <?php if (isset($_SESSION['user_id'])): ?>
                <!-- Logged In Links -->
                <li><a href="dashboard">Dashboard</a></li>
                <li><a href="book">Book Chicks</a></li> <!-- Placeholder for Booking -->
                <li><a href="logout">Logout</a></li>
            <?php else: ?>
                <!-- Guest Links -->
                <li><a href="index">Home</a></li>
                <li><a href="login">Login</a></li>
                <li><a href="register">Register</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<div class="container">
