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

// Fetch all bookings (Newest first)
$stmt = $pdo->query("
    SELECT bookings.*, kitchens.name 
    FROM bookings 
    JOIN kitchens ON bookings.kitchen_id = kitchens.id
    ORDER BY bookings.created_at DESC
");
$bookings = $stmt->fetchAll();

// Include the global header (Fixes Logo & Logout 404s)
include "../includes/header.php"; 
?>

<div class="d-flex justify-content-between align-items-center mt-4 mb-4">
    <h2 class="fw-bold">Platform Bookings (Admin)</h2>
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
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Total Price</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($bookings) > 0): ?>
                        <?php foreach($bookings as $b): ?>
                            <tr>
                                <td>#<?php echo htmlspecialchars($b['id']); ?></td>
                                <td class="fw-bold"><?php echo htmlspecialchars($b['name']); ?></td>
                                
                                <td><?php echo htmlspecialchars(date('M d, Y - h:i A', strtotime($b['start_datetime']))); ?></td>
                                <td><?php echo htmlspecialchars(date('M d, Y - h:i A', strtotime($b['end_datetime']))); ?></td>
                                
                                <td>€<?php echo htmlspecialchars(number_format($b['total_price'], 2)); ?></td>
                                
                                <td>
                                    <?php 
                                        // Dynamic colored badges based on status
                                        $statusClass = 'bg-secondary';
                                        if($b['status'] == 'Approved') $statusClass = 'bg-success';
                                        if($b['status'] == 'Pending') $statusClass = 'bg-warning text-dark';
                                        if($b['status'] == 'Rejected') $statusClass = 'bg-danger';
                                        if($b['status'] == 'Cancelled') $statusClass = 'bg-dark';
                                    ?>
                                    <span class="badge <?php echo $statusClass; ?>"><?php echo htmlspecialchars($b['status']); ?></span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No bookings found in the system.</td>
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