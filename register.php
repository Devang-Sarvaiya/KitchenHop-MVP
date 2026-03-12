<?php
// 1. Start session BEFORE any HTML
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require "config/database.php";

$message = "";
$msgClass = "alert-info"; // Dynamically change alert colors (red/green/yellow)

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    if(empty($name) || empty($email) || empty($password)){
        $message = "All fields are required.";
        $msgClass = "alert-danger";
    } else {
        
        // FIX: Check if the email already exists to prevent a Fatal Database Error
        $checkEmail = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $checkEmail->execute([$email]);

        if($checkEmail->rowCount() > 0) {
            $message = "An account with this email already exists.";
            $msgClass = "alert-warning";
        } else {
            // Email is unique, proceed with registration
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $email, $hashedPassword, $role]);
            
            $message = "Account created successfully! You can now <a href='/login.php' class='alert-link'>log in here</a>.";
            $msgClass = "alert-success";
        }
    }
}

// Include the global header (Fixes Logo & Logout 404s)
include "includes/header.php"; 
?>

<div class="row justify-content-center mt-5 mb-5">
    <div class="col-md-5">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h2 class="text-center mb-4 fw-bold">Create an Account</h2>

                <?php if($message): ?>
                    <div class="alert <?php echo $msgClass; ?> text-center">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted">Full Name</label>
                        <input class="form-control form-control-lg" name="name" placeholder="John Doe" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted">Email Address</label>
                        <input class="form-control form-control-lg" type="email" name="email" placeholder="name@example.com" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted">Password</label>
                        <input class="form-control form-control-lg" type="password" name="password" placeholder="••••••••" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-muted">I want to join as a:</label>
                        <select class="form-select form-select-lg" name="role" required>
                            <option value="chef">Chef (Looking to book space)</option>
                            <option value="owner">Kitchen Owner (Looking to list space)</option>
                        </select>
                    </div>

                    <button class="btn btn-success btn-lg w-100" type="submit">Register Now</button>
                </form>

                <div class="text-center mt-4">
                    <p class="text-muted">Already have an account? <a href="/login.php" class="text-decoration-none fw-bold">Login here</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
// Include the global footer (Pushes copyright to the bottom)
include "includes/footer.php"; 
?>