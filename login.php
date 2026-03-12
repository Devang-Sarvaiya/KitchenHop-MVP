<?php
// 1. Start session BEFORE any HTML output
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Process login logic BEFORE including the header (prevents "headers already sent" error)
require "config/database.php";

$message = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email=?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if($user && password_verify($password, $user['password'])){
        
        // Set session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['name'] = $user['full_name'];

        // FIX: Absolute paths for redirects to prevent 404s
        if($user['role'] == "chef"){
            header("Location: /chef/dashboard.php");
            exit;
        } elseif($user['role'] == "owner"){
            header("Location: /owner/dashboard.php");
            exit;
        } elseif($user['role'] == "admin"){
            header("Location: /admin/dashboard.php");
            exit;
        }

    } else {
        $message = "Invalid email or password.";
    }
}

// 3. NOW we can safely include the header and output HTML
include "includes/header.php"; 
?>

<div class="row justify-content-center mt-5 mb-5">
    <div class="col-md-5">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h2 class="text-center mb-4 fw-bold">Welcome Back</h2>

                <?php if($message): ?>
                    <div class="alert alert-danger text-center"><?php echo htmlspecialchars($message); ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted">Email Address</label>
                        <input class="form-control form-control-lg" type="email" name="email" placeholder="name@example.com" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-muted">Password</label>
                        <input class="form-control form-control-lg" type="password" name="password" placeholder="••••••••" required>
                    </div>

                    <button class="btn btn-primary btn-lg w-100" type="submit">Login</button>
                </form>

                <div class="text-center mt-4">
                    <p class="text-muted">Don't have an account? <a href="/register.php" class="text-decoration-none fw-bold">Register here</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
// Include the global footer (Pushes copyright to the bottom)
include "includes/footer.php"; 
?>