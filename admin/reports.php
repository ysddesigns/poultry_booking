<?php
require_once '../config/db.php';
require_once 'includes/header.php';

$stats = [
    'total_users' => 0,
    'total_bookings' => 0,
    'bookings_by_type' => [],
    'bookings_by_status' => []
];

$error = '';

try {
    $pdo = getDBConnection();

    // 1. Total Users
    $stmt = $pdo->query("SELECT COUNT(*) FROM users");
    $stats['total_users'] = $stmt->fetchColumn();

    // 2. Total Bookings
    $stmt = $pdo->query("SELECT COUNT(*) FROM bookings");
    $stats['total_bookings'] = $stmt->fetchColumn();

    // 3. Bookings by Chick Type
    $stmt = $pdo->query("SELECT chick_type, COUNT(*) as count FROM bookings GROUP BY chick_type");
    $stats['bookings_by_type'] = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

    // 4. Bookings by Status
    $stmt = $pdo->query("SELECT status, COUNT(*) as count FROM bookings GROUP BY status");
    $stats['bookings_by_status'] = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

} catch (PDOException $e) {
    $error = "Database Error: " . $e->getMessage();
}
?>

<div style="margin-top: 30px; margin-bottom: 20px;">
    <h2>Reports & Analytics</h2>
</div>

<?php if ($error): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<!-- Top Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 40px;">
    <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); border-left: 5px solid #3498db;">
        <h3 style="margin: 0; color: #7f8c8d; font-size: 1em;">Total Customers</h3>
        <p style="margin: 10px 0 0; font-size: 2em; font-weight: bold; color: #2c3e50;"><?php echo number_format($stats['total_users']); ?></p>
    </div>
    <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); border-left: 5px solid #e67e22;">
        <h3 style="margin: 0; color: #7f8c8d; font-size: 1em;">Total Bookings</h3>
        <p style="margin: 10px 0 0; font-size: 2em; font-weight: bold; color: #2c3e50;"><?php echo number_format($stats['total_bookings']); ?></p>
    </div>
    <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); border-left: 5px solid #27ae60;">
        <h3 style="margin: 0; color: #7f8c8d; font-size: 1em;">Pending Orders</h3>
        <p style="margin: 10px 0 0; font-size: 2em; font-weight: bold; color: #2c3e50;">
            <?php echo number_format($stats['bookings_by_status']['pending'] ?? 0); ?>
        </p>
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
    
    <!-- Chick Type Breakdown -->
    <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
        <h3 style="border-bottom: 2px solid #ecf0f1; padding-bottom: 15px; margin-top: 0;">Bookings by Chick Type</h3>
        <table style="width: 100%; margin-top: 15px;">
            <?php foreach ($stats['bookings_by_type'] as $type => $count): ?>
                <tr>
                    <td style="padding: 10px 0; border-bottom: 1px solid #f1f1f1;"><?php echo htmlspecialchars($type); ?></td>
                    <td style="padding: 10px 0; border-bottom: 1px solid #f1f1f1; text-align: right; font-weight: bold;"><?php echo $count; ?></td>
                </tr>
            <?php endforeach; ?>
             <?php if (empty($stats['bookings_by_type'])): ?>
                <tr><td colspan="2" style="padding: 10px 0;">No data available.</td></tr>
            <?php endif; ?>
        </table>
    </div>

    <!-- Booking Status -->
    <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
        <h3 style="border-bottom: 2px solid #ecf0f1; padding-bottom: 15px; margin-top: 0;">Order Status Mix</h3>
        <table style="width: 100%; margin-top: 15px;">
            <?php foreach ($stats['bookings_by_status'] as $status => $count): ?>
                <tr>
                    <td style="padding: 10px 0; border-bottom: 1px solid #f1f1f1; text-transform: capitalize;"><?php echo htmlspecialchars($status); ?></td>
                    <td style="padding: 10px 0; border-bottom: 1px solid #f1f1f1; text-align: right; font-weight: bold;">
                        <?php echo $count; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
             <?php if (empty($stats['bookings_by_status'])): ?>
                <tr><td colspan="2" style="padding: 10px 0;">No data available.</td></tr>
            <?php endif; ?>
        </table>
    </div>

</div>

</div> <!-- Close Container -->
</body>
</html>
