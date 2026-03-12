<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require "config/database.php";

// 1. Safe check: Did they provide an ID?
if(!isset($_GET['id'])){
    include "includes/header.php";
    echo "<div class='alert alert-danger mt-4'>No kitchen selected. <a href='/kitchens.php'>Go back</a></div>";
    include "includes/footer.php";
    exit;
}

$id = $_GET['id'];

// 2. Fetch the kitchen safely
$stmt = $pdo->prepare("SELECT * FROM kitchens WHERE id=?");
$stmt->execute([$id]);
$kitchen = $stmt->fetch();

// 3. Safe check: Does this kitchen exist in the database?
if(!$kitchen){
    include "includes/header.php";
    echo "<div class='alert alert-danger mt-4'>Kitchen not found. <a href='/kitchens.php'>Browse other kitchens</a></div>";
    include "includes/footer.php";
    exit;
}

// 4. Include the global header (Fixes Logo & Logout 404s)
include "includes/header.php";
?>

<div class="row mt-4">
    <div class="col-md-6 mb-4">
        <?php if(!empty($kitchen['image_url'])): ?>
            <img src="<?php echo htmlspecialchars($kitchen['image_url']); ?>" 
                 alt="<?php echo htmlspecialchars($kitchen['name']); ?>" 
                 class="img-fluid rounded shadow-sm w-100" 
                 style="height: 400px; object-fit: cover;">
        <?php else: ?>
            <div class="bg-secondary text-white d-flex justify-content-center align-items-center rounded shadow-sm w-100" style="height: 400px;">
                <span>No Image Available</span>
            </div>
        <?php endif; ?>
    </div>

    <div class="col-md-6">
        <h2 class="fw-bold mb-2"><?php echo htmlspecialchars($kitchen['name']); ?></h2>
        
        <h4 class="text-primary mb-3">€<?php echo htmlspecialchars($kitchen['hourly_rate']); ?> <span class="text-muted fs-6">/ hour</span></h4>
        
        <p class="text-muted mb-4">
            <strong>Address:</strong> <?php echo htmlspecialchars($kitchen['address']); ?>
        </p>

        <h5 class="fw-bold">About this space</h5>
        <p class="mb-4"><?php echo nl2br(htmlspecialchars($kitchen['description'])); ?></p>

        <?php if(!empty($kitchen['availability_notes'])): ?>
            <h5 class="fw-bold">Availability Notes</h5>
            <p class="mb-4"><?php echo nl2br(htmlspecialchars($kitchen['availability_notes'])); ?></p>
        <?php endif; ?>

        <div class="mt-4 pt-3 border-top">
            <a class="btn btn-success btn-lg px-4 shadow-sm" href="/book_kitchen.php?id=<?php echo $kitchen['id']; ?>">
                Book This Kitchen
            </a>
            <a class="btn btn-outline-secondary btn-lg ms-2" href="/kitchens.php">
                Back to Browse
            </a>
        </div>
    </div>
</div>

<?php 
// Include the global footer (Pushes copyright to the bottom)
include "includes/footer.php"; 
?>