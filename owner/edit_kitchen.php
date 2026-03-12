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

$id = $_GET['id'] ?? null;
$message = "";

// 3. Ownership Check: Fetch the kitchen but ensure it belongs to THIS owner
$stmt = $pdo->prepare("SELECT * FROM kitchens WHERE id = ? AND owner_id = ?");
$stmt->execute([$id, $_SESSION['user_id']]);
$kitchen = $stmt->fetch();

if(!$kitchen){
    die("Kitchen not found or you do not have permission to edit it.");
}

// 4. Handle Post Request
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $address = trim($_POST['address']);
    $rate = floatval($_POST['rate']);

    $update = $pdo->prepare("UPDATE kitchens SET name=?, description=?, address=?, hourly_rate=? WHERE id=? AND owner_id=?");
    $update->execute([$name, $description, $address, $rate, $id, $_SESSION['user_id']]);
    
    // Refresh kitchen data to show updated values in form
    $kitchen['name'] = $name;
    $kitchen['description'] = $description;
    $kitchen['address'] = $address;
    $kitchen['hourly_rate'] = $rate;

    $message = "<div class='alert alert-success'>Kitchen details updated successfully!</div>";
}

include "../includes/header.php";
?>

<div class="d-flex justify-content-between align-items-center mt-4 mb-4">
    <h2 class="fw-bold">Edit Kitchen Details</h2>
    <a href="/owner/my_kitchens.php" class="btn btn-outline-secondary">Back to My Kitchens</a>
</div>

<?php echo $message; ?>

<div class="card shadow-sm border-0 mb-5">
    <div class="card-body p-4">
        <form method="POST">
            <div class="row">
                <div class="col-md-8 mb-3">
                    <label class="form-label fw-bold">Kitchen Name</label>
                    <input class="form-control" name="name" 
                           value="<?php echo htmlspecialchars($kitchen['name']); ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Hourly Rate (€)</label>
                    <input type="number" step="0.01" class="form-control" name="rate" 
                           value="<?php echo htmlspecialchars($kitchen['hourly_rate']); ?>" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Address / City</label>
                <input class="form-control" name="address" 
                       value="<?php echo htmlspecialchars($kitchen['address']); ?>" required>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Description</label>
                <textarea class="form-control" name="description" rows="5"><?php echo htmlspecialchars($kitchen['description']); ?></textarea>
            </div>

            <button class="btn btn-primary btn-lg px-5">Save Changes</button>
        </form>
    </div>
</div>

<?php include "../includes/footer.php"; ?>