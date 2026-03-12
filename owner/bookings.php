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

// 3. INLINE APPROVE / REJECT LOGIC (Fixes 404s and allows instant refresh)
if(isset($_GET['approve_id'])){
    $stmt = $pdo->prepare("UPDATE bookings SET status='Approved' WHERE id=?");
    $stmt->execute([$_GET['approve_id']]);
    header("Location: /owner/bookings.php"); 
    exit;
}

if(isset($_GET['reject_id'])){
    $stmt = $pdo->prepare("UPDATE bookings SET status='Rejected' WHERE id=?");
    $stmt->execute([$_GET['reject_id']]);
    header("Location: /owner/bookings.php"); 
    exit;
}

// Fetch incoming booking requests for THIS owner's kitchens (Newest first)
$stmt = $pdo->prepare("
    SELECT bookings.*, kitchens.name 
    FROM bookings 
    JOIN kitchens ON bookings.kitchen_id = kitchens.id
    WHERE kitchens.owner_id = ?
    ORDER BY bookings.created_at DESC
");
$stmt->execute([$_SESSION['user_id']]);
$bookings = $stmt->fetchAll();

// Include the global header (Fixes Logo & Logout 404s)
include "../includes/header.php"; 
?>

<div class="d-flex justify-content-between align-items-center mt-4 mb-4">
    <h2 class="fw-bold">Incoming Booking Requests</h2>
    <a href="/owner/dashboard.php" class="btn btn-outline-secondary">Back to Dashboard</a>
</div>

<div class="card shadow-sm border-0 mb-5">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Kitchen</th>
                        <th>Date & Time</th>
                        <th>Total Payout</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($bookings) > 0): ?>
                        <?php foreach($bookings as $b): ?>
                            <tr>
                                <td>#<?php echo htmlspecialchars($b['id']); ?></td>
                                <td class="fw-bold"><?php echo htmlspecialchars($b['name']); ?></td>
                                
                                <td class="small">
                                    <strong>In:</strong> <?php echo htmlspecialchars(date('M d, h:i A', strtotime($b['start_datetime']))); ?><br>
                                    <strong>Out:</strong> <?php echo htmlspecialchars(date('M d, h:i A', strtotime($b['end_datetime']))); ?>
                                </td>
                                
                                <td class="text-success fw-bold">€<?php echo htmlspecialchars(number_format($b['total_price'], 2)); ?></td>
                                
                                <td>
                                    <?php 
                                        $statusClass = 'bg-secondary';
                                        if($b['status'] == 'Approved') $statusClass = 'bg-success';
                                        if($b['status'] == 'Pending') $statusClass = 'bg-warning text-dark';
                                        if($b['status'] == 'Rejected') $statusClass = 'bg-danger';
                                        if($b['status'] == 'Cancelled') $statusClass = 'bg-dark';
                                    ?>
                                    <span class="badge <?php echo $statusClass; ?>"><?php echo htmlspecialchars($b['status']); ?></span>
                                </td>

                                <td>
                                    <?php if($b['status'] == 'Pending'): ?>
                                        <div class="btn-group">
                                            <a href="/owner/bookings.php?approve_id=<?php echo $b['id']; ?>" class="btn btn-success btn-sm">Approve</a>
                                            <a href="/owner/bookings.php?reject_id=<?php echo $b['id']; ?>" class="btn btn-danger btn-sm">Reject</a>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted small"><em>Resolved</em></span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">You have no booking requests at this time.</td>
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