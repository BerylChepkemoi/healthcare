<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header('Location: ../auth/login.php');
    exit();
}
include '../includes/db.php';
include '../includes/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="container">
        <h2>Admin Dashboard</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Users</h5>
                        <p class="card-text">
                            <?php
                            $stmt = $conn->query("SELECT COUNT(*) AS total_users FROM users");
                            $result = $stmt->fetch(PDO::FETCH_ASSOC);
                            echo $result['total_users'];
                            ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Appointments</h5>
                        <p class="card-text">
                            <?php
                            $stmt = $conn->query("SELECT COUNT(*) AS total_appointments FROM appointments");
                            $result = $stmt->fetch(PDO::FETCH_ASSOC);
                            echo $result['total_appointments'];
                            ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Pending Appointments</h5>
                        <p class="card-text">
                            <?php
                            $stmt = $conn->query("SELECT COUNT(*) AS pending_appointments FROM appointments WHERE status = 'pending'");
                            $result = $stmt->fetch(PDO::FETCH_ASSOC);
                            echo $result['pending_appointments'];
                            ?>
                        </p>
                    </div>
                </div>
            </div>

            <?php
            $report = generateReport('2023-01-01', '2023-12-31');
            ?>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Revenue</h5>
                        <p class="card-text">
                        <?php echo 'KES ' . number_format($report['total_revenue'], 2); ?>
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
