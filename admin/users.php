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

// Fetch all users, newest registrations first
$stmt = $pdo->query("SELECT * FROM users ORDER BY created_at DESC");
$users = $stmt->fetchAll();

// Include the global header (Fixes Logo & Logout 404s)
include "../includes/header.php"; 
?>

<div class="d-flex justify-content-between align-items-center mt-4 mb-4">
    <h2 class="fw-bold">Manage Users (Admin)</h2>
    <a href="/admin/dashboard.php" class="btn btn-outline-secondary">Back to Dashboard</a>
</div>

<div class="card shadow-sm border-0 mb-5">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Email Address</th>
                        <th>Platform Role</th>
                        <th>Registered On</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($users) > 0): ?>
                        <?php foreach($users as $u): ?>
                            <tr>
                                <td>#<?php echo htmlspecialchars($u['id']); ?></td>
                                <td class="fw-bold"><?php echo htmlspecialchars($u['full_name']); ?></td>
                                <td>
                                    <a href="mailto:<?php echo htmlspecialchars($u['email']); ?>" class="text-decoration-none">
                                        <?php echo htmlspecialchars($u['email']); ?>
                                    </a>
                                </td>
                                
                                <td>
                                    <?php if($u['role'] == 'admin'): ?>
                                        <span class="badge bg-danger">Admin</span>
                                    <?php elseif($u['role'] == 'owner'): ?>
                                        <span class="badge bg-success">Kitchen Owner</span>
                                    <?php else: ?>
                                        <span class="badge bg-primary">Chef</span>
                                    <?php endif; ?>
                                </td>
                                
                                <td class="text-muted small">
                                    <?php echo htmlspecialchars(date('M d, Y', strtotime($u['created_at']))); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">No users found in the system.</td>
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