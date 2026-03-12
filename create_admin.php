<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Connect to database
require "config/database.php";

// Include the global header (Fixes Logo & Logout 404s)
include "includes/header.php"; 
?>

<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <h2 class="mb-4">System Setup: Admin User</h2>
        <div class="card shadow-sm">
            <div class="card-body">
                
                <?php
                $password = password_hash("admin123", PASSWORD_DEFAULT);

                // Check if admin already exists
                $stmt = $pdo->prepare("SELECT * FROM users WHERE email=?");
                $stmt->execute(["admin@kitchenhop.com"]);

                if($stmt->rowCount() > 0){
                    echo "<div class='alert alert-info'><strong>Notice:</strong> The Admin account (admin@kitchenhop.com) already exists in the database.</div>";
                } else {
                    // Insert new admin
                    $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, ?)");
                    $stmt->execute(["Admin", "admin@kitchenhop.com", $password, "admin"]);
                    
                    echo "<div class='alert alert-success'><strong>Success!</strong> Admin created successfully. Credentials are: <br> Email: admin@kitchenhop.com <br> Password: admin123</div>";
                }
                ?>

                <div class="alert alert-warning mt-4 border-warning">
                    <strong>⚠️ Security Warning:</strong><br> 
                    Leaving this file on your live server is a major security risk. Please delete <code>create_admin.php</code> from your ByetHost File Manager immediately after confirming your admin login works.
                </div>

                <a href="/login.php" class="btn btn-primary w-100 mt-2">Go to Login</a>

            </div>
        </div>
    </div>
</div>

<?php 
// Include the global footer (Pushes copyright to the bottom)
include "includes/footer.php"; 
?>