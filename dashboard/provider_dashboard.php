<?php
session_start();
include '../includes/db.php';
include '../includes/functions.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'provider') {
    header('Location: ../auth/login.php');
    exit();
}

$provider_id = $_SESSION['user']['id'];

// Fetch provider details
$specialties = getProviderSpecialties($provider_id);
$availability = getProviderAvailability($provider_id);
$bookings = getProviderBookings($provider_id);
$earnings = getProviderEarnings($provider_id);

?>
<?php include '../includes/header.php'; ?>
<div class="container">
    <h2>Provider Dashboard</h2>
    <div class="row">
        <div class="col-md-6">
            <h3>Specialties</h3>
            <ul class="list-group">
                <?php foreach ($specialties as $specialty) : ?>
                    <li class="list-group-item"><?php echo $specialty['name']; ?></li>
                <?php endforeach; ?>
            </ul>
            <a href="../specialties/manage.php" class="btn btn-primary mt-2"><i class="fas fa-edit"></i> Manage Specialties</a>
        </div>
        <div class="col-md-6">
            <h3>Availability</h3>
            <ul class="list-group">
                <?php foreach ($availability as $available) : ?>
                    <li class="list-group-item">
                        <?php echo $available['day_of_week'] . ' ' . $available['start_time'] . ' - ' . $available['end_time'] . ' (' . $available['consultation_type'] . ')'; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
            <a href="../availability/manage.php" class="btn btn-primary mt-2"><i class="fas fa-clock"></i> Manage Availability</a>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-6">
            <h3>Bookings</h3>
            <ul class="list-group">
                <?php foreach ($bookings as $booking) : ?>
                    <li class="list-group-item">
                        <?php echo 'Booking ID: ' . $booking['id'] . ' Date: ' . $booking['appointment_date'] . ' Patient: ' . $booking['patient_name']; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="col-md-6">
            <h3>Earnings</h3>
            <ul class="list-group">
                <?php foreach ($earnings as $earning) : ?>
                    <li class="list-group-item">
                        <?php echo 'Amount: KES' . number_format($earning['amount'], 2) . ' Booking ID: ' . $earning['booking_id'] . ' Date: ' . $earning['created_at']; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
            <h4>Total Earnings: $<?php echo number_format(array_sum(array_column($earnings, 'amount')), 2); ?></h4>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>