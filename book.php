<?php
require_once 'config/db.php';
include 'includes/header.php';

// Auth Check
if (!isset($_SESSION['user_id'])) {
    header('Location: login');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $chick_type = $_POST['chick_type'] ?? '';
    $quantity = (int) ($_POST['quantity'] ?? 0);
    $pickup_date = $_POST['pickup_date'] ?? '';

    // Validation
    if (empty($chick_type) || $quantity < 1 || empty($pickup_date)) {
        $error = 'Please fill in all fields correctly.';
    } elseif (strtotime($pickup_date) <= time()) {
        $error = 'Pickup date must be in the future.';
    } else {
        $allowed_types = ['Layer', 'Broiler', 'Cockerel'];
        if (!in_array($chick_type, $allowed_types)) {
            $error = 'Invalid chick type selected.';
        } else {
            try {
                $pdo = getDBConnection();
                $stmt = $pdo->prepare("INSERT INTO bookings (user_id, chick_type, quantity, pickup_date, status) VALUES (?, ?, ?, ?, 'pending')");
                
                if ($stmt->execute([$_SESSION['user_id'], $chick_type, $quantity, $pickup_date])) {
                    header('Location: dashboard?msg=booked');
                    exit;
                } else {
                    $error = 'Failed to create booking. Please try again.';
                }
            } catch (PDOException $e) {
                $error = 'Database Error: ' . $e->getMessage();
            }
        }
    }
}
?>

<div class="auth-wrapper">
    <div style="margin-bottom: 20px;">
        <a href="dashboard" style="text-decoration: none; color: #777;">&larr; Back to Dashboard</a>
    </div>
    
    <h2>Book New Chicks</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" action="book">
        <div class="form-group">
            <label for="chick_type">Chick Type</label>
            <select id="chick_type" name="chick_type" class="form-control" required>
                <option value="">-- Select Type --</option>
                <option value="Broiler" <?php echo (($_POST['chick_type'] ?? '') === 'Broiler') ? 'selected' : ''; ?>>Broiler</option>
                <option value="Layer" <?php echo (($_POST['chick_type'] ?? '') === 'Layer') ? 'selected' : ''; ?>>Layer</option>
                <option value="Cockerel" <?php echo (($_POST['chick_type'] ?? '') === 'Cockerel') ? 'selected' : ''; ?>>Cockerel</option>
            </select>
        </div>

        <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" id="quantity" name="quantity" class="form-control" min="1" value="<?php echo htmlspecialchars($_POST['quantity'] ?? ''); ?>" required>
        </div>

        <div class="form-group">
            <label for="pickup_date">Preferred Pickup Date</label>
            <input type="date" id="pickup_date" name="pickup_date" class="form-control" value="<?php echo htmlspecialchars($_POST['pickup_date'] ?? ''); ?>" required>
        </div>

        <button type="submit" class="btn">Confirm Booking</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
