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

// 3. Safely check if an ID was actually passed in the URL
if(isset($_GET['id'])){
    $kitchen_id = $_GET['id'];
    $owner_id = $_SESSION['user_id'];

    try {
        // FIX: Delete all bookings associated with this kitchen first
        // This prevents MySQL from crashing due to Foreign Key constraints!
        $stmt_bookings = $pdo->prepare("DELETE FROM bookings WHERE kitchen_id = ?");
        $stmt_bookings->execute([$kitchen_id]);

        // Now it is safe to delete the kitchen itself
        // The AND owner_id = ? ensures an owner can't hack the URL to delete someone else's kitchen
        $stmt_kitchen = $pdo->prepare("DELETE FROM kitchens WHERE id = ? AND owner_id = ?");
        $stmt_kitchen->execute([$kitchen_id, $owner_id]);

    } catch(PDOException $e) {
        // If anything goes wrong, we catch it so the user doesn't see a raw SQL error
    }
}

// 4. Absolute path redirect prevents 404 errors
header("Location: /owner/my_kitchens.php");
exit;
?>