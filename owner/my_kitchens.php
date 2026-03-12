<?php
// 1. Start session safely
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require "../config/database.php";

// 2. CRITICAL SECURITY: Check if user is logged in AND is an owner
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'owner'){
    header("Location: /login.php");
    exit;
}

// 3. Fetch kitchens belonging to this owner
$stmt = $pdo->prepare("SELECT * FROM kitchens WHERE owner_id = ? ORDER BY created_at DESC");
$stmt->execute([$_SESSION['user_id']]);
$kitchens = $stmt->fetchAll();

include "../includes/header.php";
?>

<div class="d-flex justify-content-between align-middle mt-4 mb-4">
    <h2 class="fw-bold">My Kitchen Listings</h2>
    <a href="/owner/add_kitchen.php" class="btn btn-success">+ Add New Kitchen</a>
</div>

<div class="card shadow-sm border-0 mb-5">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Kitchen Details</th>
                        <th>Hourly Rate</th>
                        <th>Admin Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($kitchens) > 0): ?>
                        <?php foreach($kitchens as $k): ?>
                            <tr>
                                <td>
                                    <div class="fw-bold"><?php echo htmlspecialchars($k['name']); ?></div>
                                    <small class="text-muted"><?php echo htmlspecialchars($k['address']); ?></small>
                                </td>
                                <td class="fw-bold text-primary">€<?php echo htmlspecialchars(number_format($k['hourly_rate'], 2)); ?></td>
                                <td>
                                    <?php if($k['is_verified']): ?>
                                        <span class="badge bg-success">Verified & Live</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">Pending Admin Approval</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="/owner/edit_kitchen.php?id=<?php echo $k['id']; ?>" 
                                           class="btn btn-outline-warning btn-sm">Edit</a>
                                        
                                        <a href="/owner/delete_kitchen.php?id=<?php echo $k['id']; ?>" 
                                           class="btn btn-outline-danger btn-sm" 
                                           onclick="return confirm('Are you sure? This will also delete all associated bookings for this kitchen.');">
                                           Delete
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <p class="mb-2">You haven't listed any kitchens yet.</p>
                                <a href="/owner/add_kitchen.php" class="btn btn-primary btn-sm">List Your First Kitchen</a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include "../includes/footer.php"; ?>