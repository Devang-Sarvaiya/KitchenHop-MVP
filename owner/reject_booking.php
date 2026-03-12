<?php

require "../config/database.php";

$id = $_GET['id'];

$stmt = $pdo->prepare("UPDATE bookings SET status='Rejected' WHERE id=?");

$stmt->execute([$id]);

header("Location: bookings.php");

?>