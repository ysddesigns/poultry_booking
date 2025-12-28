<?php
require_once 'config/db.php';
include 'includes/header.php';

// Auth Check
if (!isset($_SESSION['user_id'])) {
    header('Location: login');
    exit;
}

$user_id = $_SESSION['user_id'];
$bookings = [];
$error = '';

try {
    $pdo = getDBConnection();
    $stmt = $pdo->prepare("SELECT * FROM bookings WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->execute([$user_id]);
    $bookings = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = "Error fetching bookings: " . $e->getMessage();
}

$msg = $_GET['msg'] ?? '';
?>

<div class="dashboard-container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'User'); ?>!</h2>
        <a href="book" class="btn" style="width: auto;">Book New Chicks</a>
    </div>

    <?php if ($msg === 'booked'): ?>
        <div class="alert alert-success">Booking created successfully!</div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
            <thead>
                <tr style="background: #2c3e50; color: white;">
                    <th style="padding: 12px;">ID</th>
                    <th style="padding: 12px;">Chick Type</th>
                    <th style="padding: 12px;">Quantity</th>
                    <th style="padding: 12px;">Pickup Date</th>
                    <th style="padding: 12px;">Status</th>
                    <th style="padding: 12px;">Date Booked</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($bookings)): ?>
                    <tr>
                        <td colspan="6" style="padding: 20px; text-align: center;">You haven't booked any chicks yet.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($bookings as $booking): ?>
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 12px;">#<?php echo $booking['id']; ?></td>
                            <td style="padding: 12px;"><?php echo htmlspecialchars($booking['chick_type']); ?></td>
                            <td style="padding: 12px;"><?php echo number_format($booking['quantity']); ?></td>
                            <td style="padding: 12px;"><?php echo date('M d, Y', strtotime($booking['pickup_date'])); ?></td>
                            <td style="padding: 12px;">
                                <span style="
                                    padding: 5px 10px; 
                                    border-radius: 15px; 
                                    font-size: 0.85em;
                                    background: <?php 
                                        echo match($booking['status']) {
                                            'confirmed' => '#d4edda',
                                            'cancelled' => '#f8d7da',
                                            'completed' => '#cce5ff',
                                            default => '#fff3cd'
                                        };
                                    ?>;
                                    color: <?php 
                                        echo match($booking['status']) {
                                            'confirmed' => '#155724',
                                            'cancelled' => '#721c24',
                                            'completed' => '#004085',
                                            default => '#856404'
                                        };
                                    ?>;
                                ">
                                    <?php echo ucfirst($booking['status']); ?>
                                </span>
                            </td>
                            <td style="padding: 12px; color: #777;"><?php echo date('M d, Y', strtotime($booking['created_at'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
