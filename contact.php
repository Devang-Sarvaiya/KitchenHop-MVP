<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require "config/database.php";

$message_sent = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $msg = trim($_POST['message']);

    if (!empty($name) && !empty($email) && !empty($msg)) {
        $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $subject, $msg]);
        $message_sent = true;
    }
}

include "includes/header.php"; 
?>

<div class="row justify-content-center mt-5 mb-5">
    <div class="col-md-6">
        <div class="card shadow border-0">
            <div class="card-body p-4">
                <h2 class="fw-bold text-center mb-4">Contact Us</h2>
                
                <?php if ($message_sent): ?>
                    <div class="alert alert-success">
                        Thank you! Your message has been sent. We will get back to you soon.
                    </div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="name@example.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Subject</label>
                        <input type="text" name="subject" class="form-control" placeholder="How can we help?">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Message</label>
                        <textarea name="message" class="form-control" rows="5" placeholder="Write your message here..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-2">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "includes/footer.php"; ?>