<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Auth Check (Shared across all admin pages)
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Poultry Farm</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<header style="background-color: #34495e;">
    <nav>
        <div class="brand">🛡️ Admin Panel</div>
        <ul>
            <li><a href="dashboard" style="<?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'color: #fff; font-weight: bold;' : 'color: #bdc3c7;'; ?>">Bookings</a></li>
            <li><a href="users" style="<?php echo basename($_SERVER['PHP_SELF']) == 'users.php' ? 'color: #fff; font-weight: bold;' : 'color: #bdc3c7;'; ?>">Users</a></li>
            <li><a href="reports" style="<?php echo basename($_SERVER['PHP_SELF']) == 'reports.php' ? 'color: #fff; font-weight: bold;' : 'color: #bdc3c7;'; ?>">Reports</a></li>
            <li><a href="logout" style="background: rgba(255,255,255,0.1); margin-left: 15px;">Logout</a></li>
        </ul>
    </nav>
</header>

<div class="container">
