<?php
session_start();
session_unset();
session_destroy();

// FIX: The forward slash ensures it always goes to the main root login page!
header("Location: /login.php");
exit();
?>