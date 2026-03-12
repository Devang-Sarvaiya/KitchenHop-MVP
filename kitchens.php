<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require "config/database.php";

// Fetch ONLY verified kitchens, newest first
$stmt = $pdo->query("SELECT * FROM kitchens WHERE is_verified = 1 ORDER BY created_at DESC");
$kitchens = $stmt->fetchAll();

// Include the global header (Fixes Logo & Logout 404s)
include "includes/header.php"; 
?>

<div class="d-flex justify-content-between align-items-center mt-4 mb-4">
    <h2 class="fw-bold">Available Kitchens</h2>
</div>

<div class="row row-cols-1 row-cols-md-3 g-4 mb-5">
    
    <?php if(count($kitchens) > 0): ?>
        <?php foreach($kitchens as $k): ?>
            <div class="col">
                <div class="card h-100 shadow-sm border-0">
                    
                    <?php if(!empty($k['image_url'])): ?>
                        <img src="<?php echo htmlspecialchars($k['image_url']); ?>" 
                             class="card-img-top" 
                             alt="<?php echo htmlspecialchars($k['name']); ?>" 
                             style="height: 200px; object-fit: cover;">
                    <?php else: ?>
                        <div class="bg-secondary text-white d-flex justify-content-center align-items-center card-img-top" style="height: 200px;">
                            <span>No Image</span>
                        </div>
                    <?php endif; ?>
                    
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold text-truncate"><?php echo htmlspecialchars($k['name']); ?></h5>
                        <p class="text-muted small mb-2"><?php echo htmlspecialchars($k['address']); ?></p>
                        <h6 class="text-primary mb-3">€<?php echo htmlspecialchars($k['hourly_rate']); ?> <span class="text-muted small">/ hour</span></h6>
                        
                        <a href="/kitchen_details.php?id=<?php echo $k['id']; ?>" class="btn btn-outline-primary mt-auto w-100">
                            View Details
                        </a>
                    </div>

                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12 text-center py-5">
            <h4 class="text-muted">No verified kitchens available right now.</h4>
            <p>Check back later for new professional spaces!</p>
        </div>
    <?php endif; ?>

</div>

<?php 
// Include the global footer (Pushes copyright to the bottom)
include "includes/footer.php"; 
?>