<?php
// 1. Start session BEFORE any HTML
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require "../config/database.php";

// 2. CRITICAL SECURITY: Check if user is logged in AND is an admin
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: /login.php");
    exit;
}

// 3. FOOLPROOF VERIFICATION LOGIC (Fixes the 404 error!)
// We handle the verification right here in the same file to avoid missing pages.
if(isset($_GET['verify_id'])){
    $verify_stmt = $pdo->prepare("UPDATE kitchens SET is_verified = 1 WHERE id = ?");
    $verify_stmt->execute([$_GET['verify_id']]);
    header("Location: /admin/kitchens.php"); // Refresh page to update buttons
    exit;
}

// Added Unverify feature for a realistic admin panel
if(isset($_GET['unverify_id'])){
    $unverify_stmt = $pdo->prepare("UPDATE kitchens SET is_verified = 0 WHERE id = ?");
    $unverify_stmt->execute([$_GET['unverify_id']]);
    header("Location: /admin/kitchens.php");
    exit;
}

// Fetch all kitchens
$stmt = $pdo->query("SELECT * FROM kitchens ORDER BY created_at DESC");
$kitchens = $stmt->fetchAll();

// Include the global header (Fixes Logo & Logout 404s)
include "../includes/header.php"; 
?>

<div class="d-flex justify-content-between align-items-center mt-4 mb-4">
    <h2 class="fw-bold">Manage Kitchens (Admin)</h2>
    <a href="/admin/dashboard.php" class="btn btn-outline-secondary">Back to Dashboard</a>
</div>

<div class="card shadow-sm border-0 mb-5">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Kitchen Name</th>
                        <th>Address</th>
                        <th>Hourly Rate</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($kitchens) > 0): ?>
                        <?php foreach($kitchens as $k): ?>
                            <tr>
                                <td>#<?php echo htmlspecialchars($k['id']); ?></td>
                                <td class="fw-bold"><?php echo htmlspecialchars($k['name']); ?></td>
                                <td><?php echo htmlspecialchars($k['address']); ?></td>
                                <td>€<?php echo htmlspecialchars(number_format($k['hourly_rate'], 2)); ?></td>
                                
                                <td>
                                    <?php if($k['is_verified'] == 1): ?>
                                        <span class="badge bg-success">Verified</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php if($k['is_verified'] == 0): ?>
                                        <a href="/admin/kitchens.php?verify_id=<?php echo $k['id']; ?>" class="btn btn-success btn-sm">
                                            Verify Kitchen
                                        </a>
                                    <?php else: ?>
                                        <a href="/admin/kitchens.php?unverify_id=<?php echo $k['id']; ?>" class="btn btn-outline-danger btn-sm">
                                            Revoke Verification
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No kitchens found in the system.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php 
// Include the global footer (Pushes copyright to the bottom)
include "../includes/footer.php"; 
?>