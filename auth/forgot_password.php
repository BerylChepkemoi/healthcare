<?php
session_start();
include '../includes/config.php';
include '../includes/db.php';
include '../includes/functions.php';

$feedback = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    
    if (sendResetPasswordEmail($email)) {
        $feedback = displayFeedback('success', 'Password reset link has been sent to your email.');
    } else {
        $feedback = displayFeedback('error', 'Failed to send reset link. Please try again.');
    }
}

include '../includes/header.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-12">
            <h2 class="text-center">Forgot Password</h2>
            <?php if ($feedback): ?>
                <?php echo $feedback; ?>
            <?php endif; ?>
            <form action="forgot_password.php" method="post">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Send Reset Link</button>
                <div class="text-center mt-3">
                    <a href="login.php">Back to Login</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
