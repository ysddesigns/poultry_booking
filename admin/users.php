<?php
require_once '../config/db.php';
require_once 'includes/header.php';

$users = [];
$error = '';
$search = $_GET['search'] ?? '';

try {
    $pdo = getDBConnection();
    
    // Base SQL
    $sql = "SELECT * FROM users";
    $params = [];

    // Search Logic
    if (!empty($search)) {
        $sql .= " WHERE full_name LIKE ? OR phone LIKE ?";
        $params[] = "%$search%";
        $params[] = "%$search%";
    }
    
    $sql .= " ORDER BY created_at DESC";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $users = $stmt->fetchAll();

} catch (PDOException $e) {
    $error = "Database Error: " . $e->getMessage();
}

// Handle Delete (Simple Action)
if (isset($_GET['delete_id'])) {
    try {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$_GET['delete_id']]);
        echo "<script>alert('User deleted successfully'); window.location='users.php';</script>";
        exit;
    } catch (PDOException $e) {
        $error = "Failed to delete user: " . $e->getMessage();
    }
}
?>

<div style="margin-top: 30px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
    <h2>Manage Users</h2>
    <form method="GET" action="users.php" style="display: flex;">
        <input type="text" name="search" placeholder="Search name or phone..." value="<?php echo htmlspecialchars($search); ?>" style="padding: 8px; border: 1px solid #ccc; border-radius: 4px 0 0 4px;">
        <button type="submit" class="btn" style="padding: 8px 15px; border-radius: 0 4px 4px 0; margin: 0;">Search</button>
    </form>
</div>

<?php if ($error): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<div style="overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <thead>
            <tr style="background: #2c3e50; color: white;">
                <th style="padding: 12px;">ID</th>
                <th style="padding: 12px;">Full Name</th>
                <th style="padding: 12px;">Phone</th>
                <th style="padding: 12px;">Email</th>
                <th style="padding: 12px;">Joined Date</th>
                <th style="padding: 12px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($users)): ?>
                <tr>
                    <td colspan="6" style="padding: 20px; text-align: center;">No users found.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($users as $user): ?>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 12px;">#<?php echo $user['id']; ?></td>
                        <td style="padding: 12px;"><?php echo htmlspecialchars($user['full_name']); ?></td>
                        <td style="padding: 12px;"><?php echo htmlspecialchars($user['phone']); ?></td>
                        <td style="padding: 12px;"><?php echo htmlspecialchars($user['email'] ?? 'N/A'); ?></td>
                        <td style="padding: 12px;"><?php echo date('M d, Y', strtotime($user['created_at'])); ?></td>
                        <td style="padding: 12px;">
                            <a href="users.php?delete_id=<?php echo $user['id']; ?>" 
                               onclick="return confirm('Are you sure? This will delete all bookings for this user!');"
                               style="color: #c0392b; text-decoration: none; font-weight: bold;">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</div> <!-- Close Container -->
</body>
</html>
