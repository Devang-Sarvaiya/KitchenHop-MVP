<?php

$host = "sql105.byethost7.com";
$dbname = "b7_41364403_b1234567_kitchenhop";
$username = "b7_41364403";
$password = "YOUR_DB_PASSWORD";

try {

$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",$username,$password);

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {

die("Database connection failed: " . $e->getMessage());

}

?>
