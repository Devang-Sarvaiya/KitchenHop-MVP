<?php
// 1. Start session BEFORE any HTML
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require "../config/database.php";

// 2. CRITICAL SECURITY: Check if user is logged in AND is a chef
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'chef'){
    header("Location: /login.php");
    exit;
}

// Fetch chef's bookings (Newest first)
$stmt = $pdo->prepare("
    SELECT bookings.*, kitchens.name 
    FROM bookings 
    JOIN kitchens ON bookings.kitchen_id = kitchens.id
    WHERE chef_id = ?
    ORDER BY bookings.created_at DESC
");
$stmt->execute([$_SESSION['user_id']]);
$bookings = $stmt->fetchAll();

// Include the global header (Fixes Logo & Logout 404s)
include "../includes/header.php"; 
?>

<div class="d-flex justify-content-between align-items-center mt-4 mb-4">
    <h2 class="fw-bold">My Booking History</h2>
    <a href="/chef/dashboard.php" class="btn btn-outline-secondary">Back to Dashboard</a>
</div>

<div class="card shadow-sm border-0 mb-5">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
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
                            <td colspan="5" class="text-center py-4 text-muted">
                                You haven't made any bookings yet. <br>
                                <a href="/kitchens.php" class="btn btn-primary btn-sm mt-2">Browse Kitchens</a>
                            </td>
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