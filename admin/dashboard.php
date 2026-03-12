<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: /login.php");
    exit;
}
include "../includes/header.php";
?>

<div class="container mt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold">Admin Control Center</h1>
        <span class="text-muted">Logged in as: <strong>Admin</strong></span>
    </div>

    <div class="row g-4">
        
        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100 text-center">
                <div class="card-body p-4 d-flex flex-column">
                    <h4 class="fw-bold text-primary mb-3">Manage Users</h4>
                    <p class="small text-muted mb-4">View all registered chefs, kitchen owners, and admins.</p>
                    <a href="/admin/users.php" class="btn btn-outline-primary mt-auto">View Users</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100 text-center">
                <div class="card-body p-4 d-flex flex-column">
                    <h4 class="fw-bold text-success mb-3">Manage Kitchens</h4>
                    <p class="small text-muted mb-4">Review listings and verify trusted kitchens for chefs.</p>
                    <a href="/admin/kitchens.php" class="btn btn-success mt-auto text-white">Review Kitchens</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100 text-center">
                <div class="card-body p-4 d-flex flex-column">
                    <h4 class="fw-bold text-dark mb-3">View Bookings</h4>
                    <p class="small text-muted mb-4">Monitor all transactions and reservation statuses.</p>
                    <a href="/admin/bookings.php" class="btn btn-outline-dark mt-auto">Monitor Bookings</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100 text-center border-top border-info border-4">
                <div class="card-body p-4 d-flex flex-column">
                    <h4 class="fw-bold text-info mb-3">Support Inbox</h4>
                    <p class="small text-muted mb-4">Read and manage messages sent via the Contact Form.</p>
                    <a href="/admin/messages.php" class="btn btn-info mt-auto text-white shadow-sm">View Messages</a>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include "../includes/footer.php"; ?>