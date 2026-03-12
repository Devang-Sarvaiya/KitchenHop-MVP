<?php
// 1. Start session safely (and only once!)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. CRITICAL SECURITY: Check if user is logged in AND is an owner
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'owner'){
    // FIX: Absolute path to prevent 404 errors
    header("Location: /login.php");
    exit();
}

// Include the global header (Fixes Logo & Logout 404s)
include "../includes/header.php"; 
?>

<div class="d-flex justify-content-between align-items-center mt-4 mb-4">
    <h2 class="fw-bold">Kitchen Owner Dashboard</h2>
    <p class="text-muted mb-0">Welcome back, <strong><?php echo htmlspecialchars($_SESSION['name']); ?></strong></p>
</div>

<div class="row g-4 mb-5">
    
    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body text-center p-4 d-flex flex-column">
                <h4 class="fw-bold text-success mb-3">Add Kitchen</h4>
                <p class="text-muted mb-4">List a new commercial kitchen space on the platform, set your hourly rate, and start earning.</p>
                <a href="/owner/add_kitchen.php" class="btn btn-success mt-auto w-100 shadow-sm">Create Listing</a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body text-center p-4 d-flex flex-column">
                <h4 class="fw-bold text-primary mb-3">My Kitchens</h4>
                <p class="text-muted mb-4">View, edit, or delete your existing kitchen listings and update your availability notes.</p>
                <a href="/owner/my_kitchens.php" class="btn btn-outline-primary mt-auto w-100">Manage Listings</a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body text-center p-4 d-flex flex-column">
                <h4 class="fw-bold text-warning text-dark mb-3">Booking Requests</h4>
                <p class="text-muted mb-4">Review incoming reservations from chefs. Quickly approve or reject pending time slots.</p>
                <a href="/owner/bookings.php" class="btn btn-warning text-dark mt-auto w-100 shadow-sm">View Requests</a>
            </div>
        </div>
    </div>

</div>

<?php 
// Include the global footer (Pushes copyright to the bottom)
include "../includes/footer.php"; 
?>