<?php
// 1. Database connection
require "config/database.php";

// 2. Fetch dummy data/verified kitchens
$stmt = $pdo->query("SELECT * FROM kitchens WHERE is_verified = 1 LIMIT 3");
$kitchens = $stmt->fetchAll();

include "includes/header.php";
?>

<header class="bg-dark text-white py-5 shadow-lg" style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1556910103-1c02745aae4d?auto=format&fit=crop&w=1600&q=80'); background-size: cover; background-position: center;">
    <div class="container py-5 text-center">
        <h1 class="display-3 fw-bold mb-3">Professional Kitchens, <span class="text-primary">On Demand</span></h1>
        <p class="lead mb-4 mx-auto" style="max-width: 700px;">The marketplace for chefs to find licensed kitchen spaces and for owners to monetize their facilities.</p>
        <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
            <a href="/register.php" class="btn btn-primary btn-lg px-4 gap-3 fw-bold">Get Started as Chef</a>
            <a href="/register.php" class="btn btn-outline-light btn-lg px-4 fw-bold">List Your Kitchen</a>
        </div>
    </div>
</header>

<section class="py-5 bg-white">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-md-8">
                <h2 class="fw-bold">Available Kitchen Providers</h2>
                <p class="text-muted">Explore high-quality professional spaces near you.</p>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="/login.php" class="btn btn-link text-primary fw-bold text-decoration-none">View All Listings →</a>
            </div>
        </div>

        <div class="row g-4">
            <?php if (count($kitchens) > 0): ?>
                <?php foreach ($kitchens as $k): ?>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0">
                        <img src="<?php echo htmlspecialchars($k['image_url']); ?>" class="card-img-top" style="height: 220px; object-fit: cover;" alt="Kitchen">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="badge bg-success small">Verified</span>
                                <span class="text-primary fw-bold">€<?php echo number_format($k['hourly_rate'], 2); ?>/hr</span>
                            </div>
                            <h5 class="fw-bold mb-1"><?php echo htmlspecialchars($k['name']); ?></h5>
                            <p class="small text-muted mb-3"><i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($k['address']); ?></p>
                            <a href="/login.php" class="btn btn-outline-primary w-100 btn-sm">Check Availability</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0">
                        <img src="https://images.unsplash.com/photo-1590794056226-79ef3a8147e1?auto=format&fit=crop&w=800&q=80" class="card-img-top" style="height: 220px; object-fit: cover;">
                        <div class="card-body text-center py-4">
                            <h5 class="fw-bold">Sample Kitchen Space</h5>
                            <p class="text-muted small">No kitchens verified yet. Please log in as Admin to verify listings.</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="py-5 bg-light border-top">
    <div class="container">
        <h2 class="text-center fw-bold mb-5">How KitchenHop Works</h2>
        <div class="row text-center g-4">
            <div class="col-md-4">
                <div class="p-3">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">1</div>
                    <h5 class="fw-bold">Search</h5>
                    <p class="small text-muted">Browse verified kitchens by location, price, and equipment.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">2</div>
                    <h5 class="fw-bold">Book</h5>
                    <p class="small text-muted">Select your hours and book instantly through our secure system.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">3</div>
                    <h5 class="fw-bold">Cook</h5>
                    <p class="small text-muted">Access your workspace and start creating culinary magic.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include "includes/footer.php"; ?>
