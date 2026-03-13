<?php
session_start();
require "../config/database.php";

// Security Check
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'owner'){
    header("Location: /login.php");
    exit;
}

// Fetch ALL kitchens belonging to THIS owner (No LIMIT here)
$stmt = $pdo->prepare("SELECT * FROM kitchens WHERE owner_id = ? ORDER BY created_at DESC");
$stmt->execute([$_SESSION['user_id']]);
$my_kitchens = $stmt->fetchAll();

include "../includes/header.php";
?>

<div class="container mt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">My Kitchen Listings</h2>
        <a href="/owner/add_kitchen.php" class="btn btn-success"><i class="bi bi-plus-lg"></i> Add New Kitchen</a>
    </div>

    <?php if(count($my_kitchens) > 0): ?>
        <div class="row g-4">
            <?php foreach($my_kitchens as $k): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm border-0 h-100">
                        <img src="<?php echo (!empty($k['image_url'])) ? htmlspecialchars($k['image_url']) : 'https://via.placeholder.com/800x600?text=No+Image'; ?>" 
                             class="card-img-top" style="height: 180px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="fw-bold"><?php echo htmlspecialchars($k['name']); ?></h5>
                            <p class="text-muted small mb-2 text-truncate"><?php echo htmlspecialchars($k['address']); ?></p>
                            
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="badge <?php echo $k['is_verified'] ? 'bg-success' : 'bg-warning text-dark'; ?>">
                                    <?php echo $k['is_verified'] ? 'Verified' : 'Pending Review'; ?>
                                </span>
                                <strong class="text-primary">€<?php echo number_format($k['hourly_rate'], 2); ?>/hr</strong>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0 d-flex gap-2 pb-3">
                            <a href="/owner/edit_kitchen.php?id=<?php echo $k['id']; ?>" class="btn btn-outline-primary btn-sm flex-fill">Edit</a>
                            <a href="/owner/delete_kitchen.php?id=<?php echo $k['id']; ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Delete this listing?')">Delete</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="card p-5 text-center shadow-sm border-0">
            <h4 class="text-muted">You haven't listed any kitchens yet.</h4>
            <p>Start monetizing your space by clicking the button above!</p>
        </div>
    <?php endif; ?>
</div>

<?php include "../includes/footer.php"; ?>
