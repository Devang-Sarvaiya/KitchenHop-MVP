<?php
session_start();
require "config/database.php";

// Check if user is logged in and is a chef
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'chef'){
    header("Location: login.php");
    exit;
}

// Get kitchen ID from URL
if(!isset($_GET['id'])){
    echo "No kitchen selected.";
    exit;
}
$kitchen_id = $_GET['id'];

// Fetch kitchen details
$stmt = $pdo->prepare("SELECT * FROM kitchens WHERE id=?");
$stmt->execute([$kitchen_id]);
$kitchen = $stmt->fetch();

if(!$kitchen){
    echo "Kitchen not found.";
    exit;
}

// Handle booking form submission
if($_SERVER["REQUEST_METHOD"]=="POST"){

    $start = $_POST['start'];
    $end = $_POST['end'];

    // Validate start and end times
    if(strtotime($end) <= strtotime($start)){
        $message = "<div class='alert alert-danger'>End time must be after start time</div>";
    } else {

        $hours = (strtotime($end) - strtotime($start)) / 3600;
        $total = $hours * $kitchen['hourly_rate'];

        // Check for overlapping bookings
        $check = $pdo->prepare("
            SELECT * FROM bookings
            WHERE kitchen_id = ?
            AND status != 'Rejected'
            AND (start_datetime < ? AND end_datetime > ?)
        ");
        $check->execute([$kitchen_id, $end, $start]);

        if($check->rowCount() > 0){
            $message = "<div class='alert alert-danger'>Kitchen already booked in this time slot</div>";
        } else {
            // Insert booking
            $stmt = $pdo->prepare("
                INSERT INTO bookings (kitchen_id, chef_id, start_datetime, end_datetime, total_price, status, created_at)
                VALUES (?, ?, ?, ?, ?, 'Pending', NOW())
            ");
            $stmt->execute([$kitchen_id, $_SESSION['user_id'], $start, $end, $total]);

            $message = "<div class='alert alert-success'>Booking request sent successfully</div>";
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Kitchen - <?php echo htmlspecialchars($kitchen['name']); ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2><?php echo htmlspecialchars($kitchen['name']); ?></h2>
    <p><strong>Address:</strong> <?php echo htmlspecialchars($kitchen['address']); ?></p>
    <p><strong>Hourly Rate:</strong> €<?php echo htmlspecialchars($kitchen['hourly_rate']); ?></p>
    <p><strong>Availability Notes:</strong> <?php echo htmlspecialchars($kitchen['availability_notes']); ?></p>
    <p><strong>Verified:</strong> <?php echo $kitchen['is_verified'] ? "Yes" : "No"; ?></p>

    <?php if(isset($message)) echo $message; ?>

    <form method="POST" class="mt-4">
        <div class="mb-3">
            <label>Start Date & Time</label>
            <input type="datetime-local" name="start" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>End Date & Time</label>
            <input type="datetime-local" name="end" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Book Kitchen</button>
    </form>

    <a href="index.php" class="btn btn-secondary mt-3">Back to Kitchens</a>
</div>
</body>
</html>