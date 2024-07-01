<?php
session_start();
include '../includes/config.php';
include '../includes/db.php';
include '../includes/functions.php';

$feedback = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];
    $password = $_POST['password'];
    
    if (resetPassword($token, $password)) {
        $feedback = displayFeedback('success', 'Password has been reset successfully. <a href="login.php">Login now</a>.');
    } else {
        $feedback = displayFeedback('error', 'Failed to reset password. Please try again.');
    }
}

include '../includes/header.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-12">
            <h2 class="text-center">Reset Password</h2>
            <?php if ($feedback): ?>
                <?php echo $feedback; ?>
            <?php endif; ?>
            <form action="reset_password.php" method="post">
                <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
                <div class="form-group">
                    <label for="password">New Password:</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
            </form>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
