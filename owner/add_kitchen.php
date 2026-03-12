<?php
// 1. Start session safely BEFORE any HTML
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require "../config/database.php";

// 2. CRITICAL SECURITY: Check if user is logged in AND is an owner
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'owner'){
    header("Location: /login.php");
    exit;
}

$message = "";

// 3. Process form BEFORE outputting HTML
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $address = trim($_POST['address']);
    $rate = floatval($_POST['rate']); // Force it to be a number
    $image = trim($_POST['image']);
    $notes = trim($_POST['notes']);

    // Basic validation
    if(empty($name) || empty($address) || empty($rate)){
        $message = "<div class='alert alert-danger'>Name, Address, and Hourly Rate are required fields.</div>";
    } else {
        $stmt = $pdo->prepare("
            INSERT INTO kitchens (owner_id, name, description, address, hourly_rate, image_url, availability_notes, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
        ");

        $stmt->execute([
            $_SESSION['user_id'],
            $name,
            $description,
            $address,
            $rate,
            $image,
            $notes
        ]);

        $message = "<div class='alert alert-success'>Kitchen added successfully! You can view it in <a href='/owner/my_kitchens.php' class='alert-link'>My Kitchens</a>.</div>";
    }
}

// Include the global header (Fixes Logo & Logout 404s)
include "../includes/header.php"; 
?>

<div class="d-flex justify-content-between align-items-center mt-4 mb-4">
    <h2 class="fw-bold">List a New Kitchen</h2>
    <a href="/owner/dashboard.php" class="btn btn-outline-secondary">Back to Dashboard</a>
</div>

<?php if($message) echo $message; ?>

<div class="card shadow-sm border-0 mb-5">
    <div class="card-body p-4">
        <form method="POST">
            
            <div class="row">
                <div class="col-md-8 mb-3">
                    <label class="form-label fw-bold text-muted">Kitchen Name <span class="text-danger">*</span></label>
                    <input class="form-control" name="name" placeholder="e.g. Downtown Commercial Prep Space" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold text-muted">Hourly Rate (€) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" class="form-control" name="rate" placeholder="e.g. 25.00" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold text-muted">Address / City <span class="text-danger">*</span></label>
                <input class="form-control" name="address" placeholder="Full address or neighborhood" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold text-muted">Image URL</label>
                <input class="form-control" name="image" placeholder="https://example.com/my-kitchen.jpg">
                <div class="form-text">Paste a direct link to an image of your kitchen.</div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold text-muted">Space Description</label>
                <textarea class="form-control" name="description" rows="4" placeholder="Tell chefs about the equipment, ovens, space size, and rules..."></textarea>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold text-muted">Availability Notes</label>
                <textarea class="form-control" name="notes" rows="2" placeholder="e.g. Only available on weekends, or available 24/7..."></textarea>
            </div>

            <button class="btn btn-success btn-lg px-5" type="submit">Publish Kitchen Listing</button>
        </form>
    </div>
</div>

<?php 
// Include the global footer (Pushes copyright to the bottom)
include "../includes/footer.php"; 
?>