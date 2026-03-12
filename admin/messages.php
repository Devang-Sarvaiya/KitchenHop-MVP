<?php
session_start();
require "../config/database.php";

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: /login.php");
    exit;
}

// Fetch messages
$stmt = $pdo->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
$messages = $stmt->fetchAll();

include "../includes/header.php";
?>

<div class="container mt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Support Messages</h2>
        <a href="/admin/dashboard.php" class="btn btn-outline-secondary btn-sm">Back to Dashboard</a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Sender</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Received</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($messages) > 0): ?>
                        <?php foreach($messages as $m): ?>
                        <tr>
                            <td>
                                <strong><?php echo htmlspecialchars($m['name']); ?></strong><br>
                                <span class="small text-muted"><?php echo htmlspecialchars($m['email']); ?></span>
                            </td>
                            <td class="fw-bold"><?php echo htmlspecialchars($m['subject']); ?></td>
                            <td style="max-width: 400px;"><?php echo nl2br(htmlspecialchars($m['message'])); ?></td>
                            <td class="small text-muted"><?php echo date('M d, Y', strtotime($m['created_at'])); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">No messages found in the inbox.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include "../includes/footer.php"; ?>