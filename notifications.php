<?php
session_start();
include 'includes/db.php';
include 'includes/functions.php';

if (!isset($_SESSION['user'])) {
    header('Location: auth/login.php');
    exit();
}

$user_id = $_SESSION['user']['id'];

// Fetch notifications
$notifications = getNotifications($user_id);
?>
<?php include 'includes/header.php'; ?>
<div class="container">
    <h2>Notifications</h2>
    <ul class="list-group">
        <?php foreach ($notifications as $notification) : ?>
            <li class="list-group-item">
                <?php echo $notification['message']; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<?php include 'includes/footer.php'; ?>