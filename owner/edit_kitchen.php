<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require "../config/database.php";

// Security Check
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'owner'){
    header("Location: /login.php");
    exit;
}

$id = $_GET['id'] ?? null;
$message = "";

// Verify ownership before fetching
$stmt = $pdo->prepare("SELECT * FROM kitchens WHERE id = ? AND owner_id = ?");
$stmt->execute([$id, $_SESSION['user_id']]);
$kitchen = $stmt->fetch();

if(!$kitchen){
    die("Error: Kitchen not found or unauthorized access.");
}

// Process Update
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $address = trim($_POST['address']);
    $rate = floatval($_POST['rate']);
    $image = trim($_POST['image']);
    $notes = trim($_POST['notes']);

    $update = $pdo->prepare("UPDATE kitchens SET name=?, description=?, address=?, hourly_rate=?, image_url=?, availability_notes=? WHERE id=? AND owner_id=?");
    $update->execute([$name, $description, $address, $rate, $image, $notes, $id, $_SESSION['user_id']]);
    
    // Refresh local data for display
    $kitchen['name'] = $name;
    $kitchen['description'] = $description;
    $kitchen['address'] = $address;
    $kitchen['hourly_rate'] = $rate;
    $kitchen['image_url'] = $image;
    $kitchen['availability_notes'] = $notes;

    $message = "<div class='alert alert-info shadow-sm text-center'>Listing updated successfully!</div>";
}

include "../includes/header.php"; 
?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold"><i class="bi bi-pencil-square text-primary"></i> Edit Kitchen Details</h2>
        <a href="my_kitchens.php" class="btn btn-outline-secondary btn-sm">Back to List</a>
    </div>

    <?php echo $message; ?>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4 p-md-5">
            <form method="POST">
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label class="form-label fw-bold">Kitchen Name</label>
                        <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($kitchen['name']); ?>" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Hourly Rate (€)</label>
                        <input type="number" step="0.01" class="form-control" name="rate" value="<?php echo htmlspecialchars($kitchen['hourly_rate']); ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Address / City</label>
                    <input type="text" class="form-control" name="address" value="<?php echo htmlspecialchars($kitchen['address']); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Image URL</label>
                    <input type="url" class="form-control" name="image" value="<?php echo htmlspecialchars($kitchen['image_url']); ?>">
                    <?php if(!empty($kitchen['image_url'])): ?>
                        <div class="mt-2">
                            <small class="text-muted">Current Photo:</small><br>
                            <img src="<?php echo $kitchen['image_url']; ?>" class="rounded shadow-sm mt-1" style="height: 120px; width: 200px; object-fit: cover;">
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Description</label>
                    <textarea class="form-control" name="description" rows="4"><?php echo htmlspecialchars($kitchen['description']); ?></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Availability Notes</label>
                    <textarea class="form-control" name="notes" rows="2"><?php echo htmlspecialchars($kitchen['availability_notes']); ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm">Save Changes</button>
            </form>
        </div>
    </div>
</div>

<?php include "../includes/footer.php"; ?>
