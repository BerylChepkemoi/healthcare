<?php
session_start();
include '../includes/db.php';
include '../includes/functions.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'patient') {
    header('Location: ../auth/login.php');
    exit();
}

$user_id = $_SESSION['user']['id'];

// Fetch appointments
$appointments = getAppointments($user_id);

// Fetch notifications
$notifications = getNotifications($user_id);

?>
<?php include '../includes/header.php'; ?>
<div class="container">
    <h2>Patient Dashboard</h2>
    <div class="row">
        <div class="col-md-6">
            <h3>Appointment History</h3>
            <ul class="list-group">
                <?php foreach ($appointments as $appointment) : ?>
                    <li class="list-group-item">
                        <strong>Date:</strong> <?php echo $appointment['appointment_date']; ?><br>
                        <strong>Status:</strong> <?php echo $appointment['status']; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="col-md-6">
            <h3>Notifications</h3>
            <ul class="list-group">
                <?php foreach ($notifications as $notification) : ?>
                    <li class="list-group-item">
                        <?php echo $notification['message']; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>