<?php
session_start();
include '../includes/config.php';
include '../includes/db.php';
include '../includes/functions.php';

$feedback = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Use the authenticate function to check credentials
    if (authenticate($email, $password)) {
        // Redirect to dashboard or appropriate page based on user role
        if ($_SESSION['user']['role'] == 'admin') {
            header('Location: ../admin/dashboard.php');
        } elseif ($_SESSION['user']['role'] == 'provider') {
            header('Location: ../dashboard/provider_dashboard.php');
        } else {
            header('Location: ../dashboard/patient_dashboard.php');
        }
        exit();
    } else {
        $feedback = displayFeedback('error', 'Invalid email or password.');
    }
}

include '../includes/header.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-12">
            <h2 class="text-center">Login</h2>
            <?php if ($feedback): ?>
                <?php echo $feedback; ?>
            <?php endif; ?>
            <form action="login.php" method="post">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Login</button>
                <div class="text-center mt-3">
                    <a href="forgot_password.php">Forgot Password?</a> | 
                    <a href="register.php">Register</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
