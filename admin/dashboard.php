<?php
require_once '../config/db.php';
require_once 'includes/header.php';

$bookings = [];
$error = '';

try {
    $pdo = getDBConnection();
    // Join with users table to get customer info
    $sql = "SELECT b.*, u.full_name, u.phone 
            FROM bookings b 
            JOIN users u ON b.user_id = u.id 
            ORDER BY b.created_at DESC";
    $stmt = $pdo->query($sql);
    $bookings = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = "Database Error: " . $e->getMessage();
}
?>

    <div style="margin-top: 30px; margin-bottom: 20px;">
        <h2>Manage Bookings</h2>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
            <thead>
                <tr style="background: #2c3e50; color: white;">
                    <th style="padding: 12px;">ID</th>
                    <th style="padding: 12px;">Customer</th>
                    <th style="padding: 12px;">Phone</th>
                    <th style="padding: 12px;">Type</th>
                    <th style="padding: 12px;">Qty</th>
                    <th style="padding: 12px;">Pickup Date</th>
                    <th style="padding: 12px;">Status</th>
                    <th style="padding: 12px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($bookings)): ?>
                    <tr>
                        <td colspan="8" style="padding: 20px; text-align: center;">No bookings found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($bookings as $booking): ?>
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 12px;">#<?php echo $booking['id']; ?></td>
                            <td style="padding: 12px;"><?php echo htmlspecialchars($booking['full_name']); ?></td>
                            <td style="padding: 12px;"><?php echo htmlspecialchars($booking['phone']); ?></td>
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
                                            default => '#fff3cd'
                                        };
                                    ?>;
                                    color: <?php 
                                        echo match($booking['status']) {
                                            'confirmed' => '#155724',
                                            'cancelled' => '#721c24',
                                            default => '#856404'
                                        };
                                    ?>;
                                ">
                                    <?php echo ucfirst($booking['status']); ?>
                                </span>
                            </td>
                            <td style="padding: 12px;">
                                <a href="update_status?id=<?php echo $booking['id']; ?>&status=confirmed" 
                                   onclick="return confirm('Approve this booking?');"
                                   style="color: #27ae60; text-decoration: none; font-weight: bold; margin-right: 10px;">Approve</a>
                                <a href="update_status?id=<?php echo $booking['id']; ?>&status=cancelled" 
                                   onclick="return confirm('Cancel this booking?');"
                                   style="color: #c0392b; text-decoration: none; font-weight: bold;">Cancel</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
