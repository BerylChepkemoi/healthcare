<?php
session_start();
include '../includes/db.php';
include '../includes/functions.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'provider') {
    header('Location: ../auth/login.php');
    exit();
}

$provider_id = $_SESSION['user']['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $day_of_week = $_POST['day_of_week'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $consultation_type_id = $_POST['consultation_type_id'];
    if (addProviderAvailability($provider_id, $day_of_week, $start_time, $end_time, $consultation_type_id)) {
        echo "Availability added successfully!";
    } else {
        echo "Failed to add availability!";
    }
}

// Fetch all consultation types
$consultation_types = getAllConsultationTypes();
$provider_availability = getProviderAvailability($provider_id);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Availability</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <?php include '../includes/drawer_menu.php'; ?>
    <div class="container">
        <h2>Manage Availability</h2>
        <form action="manage.php" method="post">
            <div class="form-group">
                <label for="day_of_week">Day of the Week:</label>
                <select id="day_of_week" name="day_of_week" class="form-control" required>
                    <option value="Sunday">Sunday</option>
                    <option value="Monday">Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday">Thursday</option>
                    <option value="Friday">Friday</option>
                    <option value="Saturday">Saturday</option>
                </select>
            </div>
            <div class="form-group">
                <label for="start_time">Start Time:</label>
                <input type="time" id="start_time" name="start_time" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="end_time">End Time:</label>
                <input type="time" id="end_time" name="end_time" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="consultation_type">Consultation Type:</label>
                <select id="consultation_type" name="consultation_type_id" class="form-control" required>
                    <?php foreach ($consultation_types as $type): ?>
                        <option value="<?php echo $type['id']; ?>"><?php echo $type['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add Availability</button>
        </form>
        <h3 class="mt-4">Current Availability</h3>
        <ul class="list-group">
            <?php foreach ($provider_availability as $available): ?>
                <li class="list-group-item">
                    <?php echo $available['day_of_week'] . ' ' . $available['start_time'] . ' - ' . $available['end_time'] . ' (' . $available['consultation_type'] . ')'; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
