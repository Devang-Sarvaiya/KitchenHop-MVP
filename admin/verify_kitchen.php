<?php
session_start();
require "../config/database.php";

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit;
}

$id = $_GET['id'] ?? null;
if($id){
    $stmt = $pdo->prepare("UPDATE kitchens SET is_verified=1 WHERE id=?");
    $stmt->execute([$id]);
}
header("Location: dashboard.php");
exit;
?>