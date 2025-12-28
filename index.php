<?php
require_once 'config/db.php';
include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero">
    <div class="hero-content">
        <h1>Quality Chicks for Your Poultry Farm</h1>
        <p>Book Day-Old Broilers, Layers, and Cockerels with ease. Reliable delivery and top-notch quality guaranteed.</p>
        
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="book" class="btn btn-hero">Book Now</a>
        <?php else: ?>
            <a href="register" class="btn btn-hero">Get Started</a>
            <a href="login" class="btn btn-hero-outline">Login</a>
        <?php endif; ?>
    </div>
</section>

<!-- Features Section -->
<section class="features">
    <h2 style="text-align: center; margin-bottom: 40px; color: var(--primary-color);">Available Chick Types</h2>
    <div class="features-grid">
        <!-- Broiler -->
        <div class="feature-card">
            <div class="icon">🍗</div>
            <h3>Broilers</h3>
            <p>Fast-growing meat birds. Ready for market in just 6-8 weeks. High feed conversion ratio.</p>
        </div>

        <!-- Layer -->
        <div class="feature-card">
            <div class="icon">🥚</div>
            <h3>Layers</h3>
            <p>Prolific egg producers. bred for high egg output and longevity. Ideal for commercial egg production.</p>
        </div>

        <!-- Cockerel/Noiler -->
        <div class="feature-card">
            <div class="icon">🐓</div>
            <h3>Cockerels / Noilers</h3>
            <p>Hardy dual-purpose birds. Great for meat and withstand tough environmental conditions.</p>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section style="text-align: center; padding: 60px 20px; background-color: var(--white);">
    <h3>Ready to scale your farm?</h3>
    <p style="margin-bottom: 20px; color: #666;">Join hundreds of satisfied farmers who trust us.</p>
    <a href="<?php echo isset($_SESSION['user_id']) ? 'book' : 'register'; ?>" class="btn">Place Your Order</a>
</section>

<?php include 'includes/footer.php'; ?>
