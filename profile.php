<?php
session_start();
include 'includes/db.php';
include 'includes/functions.php';

if (!isset($_SESSION['user'])) {
    header('Location: auth/login.php');
    exit();
}

$user_id = $_SESSION['user']['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];

    if (updateProfile($user_id, $name, $email)) {
        $_SESSION['user']['name'] = $name;
        $_SESSION['user']['email'] = $email;
        echo "Profile updated successfully!";
    } else {
        echo "Failed to update profile!";
    }
}
?>
<?php include 'includes/header.php'; ?>
<div class="container">
    <h2>Profile</h2>
    <form action="profile.php" method="post">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" class="form-control" value="<?php echo $_SESSION['user']['name']; ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" class="form-control" value="<?php echo $_SESSION['user']['email']; ?>" required>
        </div>
        <button type="submit" class="btn btn-book">Update Profile</button>
    </form>
</div>
<?php include 'includes/footer.php'; ?>
