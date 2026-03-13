<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require "../config/database.php";

// Security Check
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'owner'){
    header("Location: /login.php");
    exit;
}

$message = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $address = trim($_POST['address']);
    $rate = floatval($_POST['rate']);
    $image = trim($_POST['image']);
    $notes = trim($_POST['notes']);

    if(empty($name) || empty($address) || empty($rate)){
        $message = "<div class='alert alert-danger shadow-sm'>Name, Address, and Hourly Rate are required.</div>";
    } else {
        $stmt = $pdo->prepare("
            INSERT INTO kitchens (owner_id, name, description, address, hourly_rate, image_url, availability_notes, is_verified, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, 0, NOW())
        ");

        $stmt->execute([$_SESSION['user_id'], $name, $description, $address, $rate, $image, $notes]);
        $message = "<div class='alert alert-success shadow-sm text-center'><strong>Success!</strong> Kitchen added. It will appear once verified by Admin. <a href='my_kitchens.php' class='alert-link'>View My Kitchens</a></div>";
    }
}

include "../includes/header.php"; 
?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold"><i class="bi bi-plus-circle text-success"></i> List a New Kitchen</h2>
        <a href="/owner/dashboard.php" class="btn btn-outline-secondary btn-sm">Back to Dashboard</a>
    </div>

    <?php echo $message; ?>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4 p-md-5">
            <form method="POST">
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label class="form-label fw-bold">Kitchen Name *</label>
                        <input type="text" class="form-control" name="name" placeholder="e.g. Downtown Gourmet Prep Space" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Hourly Rate (€) *</label>
                        <input type="number" step="0.01" class="form-control" name="rate" placeholder="0.00" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Address / City *</label>
                    <input type="text" class="form-control" name="address" placeholder="Full address" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Image URL</label>
                    <input type="url" class="form-control" name="image" id="imageUrl" placeholder="https://example.com/image.jpg">
                    <div class="form-text text-muted small">Paste a link to a professional photo (Unsplash, Pexels, etc.)</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Description</label>
                    <textarea class="form-control" name="description" rows="4" placeholder="Describe equipment, size, and kitchen rules..."></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Availability Notes</label>
                    <textarea class="form-control" name="notes" rows="2" placeholder="e.g. Mon-Fri 8am-5pm, or Weekend only..."></textarea>
                </div>

                <button type="submit" class="btn btn-success btn-lg px-5 shadow-sm">Publish Listing</button>
            </form>
        </div>
    </div>
</div>

<?php include "../includes/footer.php"; ?>
