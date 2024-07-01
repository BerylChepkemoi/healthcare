<?php
include 'includes/db.php';

function addNotification($user_id, $message) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO notifications (user_id, message) VALUES (?, ?)");
    return $stmt->execute([$user_id, $message]);
}

// Add a test notification
addNotification(1, 'This is a test notification');
?>
