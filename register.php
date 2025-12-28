<?php
require_once 'config/db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';

    // Basic Validation
    if (empty($full_name) || empty($phone) || empty($password)) {
        $error = 'Full Name, Phone, and Password are required.';
    } else {
        try {
            $pdo = getDBConnection();

            // Check if phone number exists
            $stmt = $pdo->prepare("SELECT id FROM users WHERE phone = ?");
            $stmt->execute([$phone]);
            if ($stmt->fetch()) {
                $error = 'Phone number is already registered.';
            } else {
                // Hash Password
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                // Insert User
                $insertStmt = $pdo->prepare("INSERT INTO users (full_name, email, phone, password_hash) VALUES (?, ?, ?, ?)");
                if ($insertStmt->execute([$full_name, $email, $phone, $hashed_password])) {
                    // Redirect to login
                    header('Location: login?registered=1');
                    exit;
                } else {
                    $error = 'Registration failed. Please try again.';
                }
            }
        } catch (PDOException $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}

include 'includes/header.php';
?>

<div class="auth-wrapper">
    <h2>Create Account</h2>
    
    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" action="register.php">
        <div class="form-group">
            <label for="full_name">Full Name</label>
            <input type="text" id="full_name" name="full_name" class="form-control" value="<?php echo htmlspecialchars($_POST['full_name'] ?? ''); ?>" required>
        </div>

        <div class="form-group">
            <label for="email">Email Address (Optional)</label>
            <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
        </div>

        <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone" class="form-control" value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn">Register</button>
        
        <p style="text-align: center; margin-top: 15px;">
            Already have an account? <a href="login">Login here</a>
        </p>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
