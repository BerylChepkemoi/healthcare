<?php
session_start();
include '../includes/config.php';
include '../includes/db.php';
include '../includes/functions.php';

$feedback = '';

if (!isset($_SESSION['user'])) {
    header('Location: ../auth/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $specialty = $_POST['specialty'];
    $appointment_date = $_POST['appointment_date'];
    $user_id = $_SESSION['user']['id'];

    if (bookAppointment($user_id, $appointment_date, $specialty)) {
        $feedback = displayFeedback('success', 'Appointment booked successfully!');
    } else {
        $feedback = displayFeedback('error', 'Failed to book appointment. Please try again.');
    }
}

// Fetch specialties for dropdown
$specialties = getAllSpecialties();

// Pre-select specialty if passed in URL
$selected_specialty = isset($_GET['specialty']) ? $_GET['specialty'] : '';

include '../includes/header.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-12">
            <h2 class="text-center">Book Appointment</h2>
            <?php if ($feedback): ?>
                <?php echo $feedback; ?>
            <?php endif; ?>
            <form action="book.php" method="post">
                <div class="form-group">
                    <label for="specialty">Specialty:</label>
                    <select id="specialty" name="specialty" class="form-control" required>
                        <?php foreach ($specialties as $specialty): ?>
                            <option value="<?php echo $specialty['name']; ?>" <?php echo ($selected_specialty == $specialty['name']) ? 'selected' : ''; ?>><?php echo $specialty['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="appointment_date">Appointment Date:</label>
                    <input type="datetime-local" id="appointment_date" name="appointment_date" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-book btn-block"><i class="fas fa-calendar-alt"></i> Book</button>
            </form>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
