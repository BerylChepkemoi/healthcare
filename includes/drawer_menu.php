<?php
include_once 'config.php';
?>
<nav id="drawerMenu" class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="<?php echo BASE_URL; ?>">
        <img src="<?php echo BASE_URL; ?>/images/logo.png" width="100" height="100" alt="Logo">
        Vital Care Appointments
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo BASE_URL; ?>/index.php"><i class="fas fa-home"></i> Home</a>
            </li>
            <?php if (isset($_SESSION['user'])) : ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/profile.php"><i class="fas fa-user"></i> Profile</a>
                </li>
                <?php if ($_SESSION['user']['role'] == 'admin') : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>/admin/dashboard.php"><i class="fas fa-tachometer-alt"></i> Admin Dashboard</a>
                    </li>
                <?php endif; ?>
                <?php if ($_SESSION['user']['role'] == 'provider') : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>/dashboard/provider_dashboard.php"><i class="fas fa-tachometer-alt"></i> Provider Dashboard</a>
                    </li>
                <?php endif; ?>
                <?php if ($_SESSION['user']['role'] == 'patient') : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>/dashboard/patient_dashboard.php"><i class="fas fa-tachometer-alt"></i> Patient Dashboard</a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/appointments/book.php"><i class="fas fa-calendar-plus"></i> Book Appointment</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/notifications.php"><i class="fas fa-bell"></i> Notifications</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/auth/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </li>
            <?php else : ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/auth/login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/auth/register.php"><i class="fas fa-user-plus"></i> Register</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>