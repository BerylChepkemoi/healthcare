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
    $specialty_id = $_POST['specialty_id'];
    if (addProviderSpecialty($provider_id, $specialty_id)) {
        echo "Specialty added successfully!";
    } else {
        echo "Failed to add specialty!";
    }
}

// Fetch all specialties
$all_specialties = getAllSpecialties();
$provider_specialties = getProviderSpecialties($provider_id);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Specialties</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <?php include '../includes/drawer_menu.php'; ?>
    <div class="container">
        <h2>Manage Specialties</h2>
        <form action="manage.php" method="post">
            <div class="form-group">
                <label for="specialty">Add Specialty:</label>
                <select id="specialty" name="specialty_id" class="form-control" required>
                    <?php foreach ($all_specialties as $specialty): ?>
                        <option value="<?php echo $specialty['id']; ?>"><?php echo $specialty['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add Specialty</button>
        </form>
        <h3 class="mt-4">Current Specialties</h3>
        <ul class="list-group">
            <?php foreach ($provider_specialties as $specialty): ?>
                <li class="list-group-item"><?php echo $specialty['name']; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
