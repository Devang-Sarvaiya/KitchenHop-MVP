<?php
// 1. Start session safely (and only once!)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. CRITICAL SECURITY: Check if user is logged in AND is a chef
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'chef'){
    // FIX: Absolute path to prevent 404 errors
    header("Location: /login.php");
    exit();
}

// Include the global header (Fixes Logo & Logout 404s)
include "../includes/header.php"; 
?>

<div class="d-flex justify-content-between align-items-center mt-4 mb-4">
    <h2 class="fw-bold">Chef Dashboard</h2>
    <p class="text-muted mb-0">Welcome back, <strong><?php echo htmlspecialchars($_SESSION['name']); ?></strong></p>
</div>

<div class="row g-4 mb-5">
    
    <div class="col-md-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body text-center p-4 d-flex flex-column">
                <h4 class="fw-bold text-primary mb-3">Browse Kitchens</h4>
                <p class="text-muted mb-4">Find and book the perfect professional kitchen space for your next culinary project or event.</p>
                <a href="/kitchens.php" class="btn btn-primary mt-auto w-100 shadow-sm">Explore Kitchens</a>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body text-center p-4 d-flex flex-column">
                <h4 class="fw-bold text-secondary mb-3">My Bookings</h4>
                <p class="text-muted mb-4">View your past and upcoming reservations, check approval statuses, and manage your schedule.</p>
                <a href="/chef/my_bookings.php" class="btn btn-outline-secondary mt-auto w-100">View Booking History</a>
            </div>
        </div>
    </div>

</div>

<?php 
// Include the global footer (Pushes copyright to the bottom)
include "../includes/footer.php"; 
?>