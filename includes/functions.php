<?php
include 'db.php';

function sendResetPasswordEmail($email) {
    global $conn;

    // Check if the email exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        // Generate a unique token
        $token = bin2hex(random_bytes(50));

        // Store the token in the database
        $stmt = $conn->prepare("INSERT INTO password_resets (email, token) VALUES (?, ?)");
        $stmt->execute([$email, $token]);

        // Send the reset email
        $resetLink = BASE_URL . "/auth/reset_password.php?token=$token";
        $subject = "Password Reset Request";
        $message = "Hi there, click on this <a href=\"$resetLink\">link</a> to reset your password.";
        $headers = "Content-Type: text/html; charset=UTF-8";

        if (mail($email, $subject, $message, $headers)) {
            return true;
        }
    }

    return false;
}

function resetPassword($token, $newPassword) {
    global $conn;

    // Find the reset token in the database
    $stmt = $conn->prepare("SELECT * FROM password_resets WHERE token = ?");
    $stmt->execute([$token]);
    $resetRequest = $stmt->fetch();

    if ($resetRequest) {
        // Get the user's email from the reset request
        $email = $resetRequest['email'];

        // Hash the new password
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        // Update the user's password in the database
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        if ($stmt->execute([$hashedPassword, $email])) {
            // Delete the reset request from the database
            $stmt = $conn->prepare("DELETE FROM password_resets WHERE email = ?");
            $stmt->execute([$email]);

            return true;
        }
    }

    return false;
}

function authenticate($email, $password) {
    global $conn;

    // Prepare and execute the query to fetch user by email
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // If user exists and passwords match, return true
    if ($user && password_verify($password, $user['password'])) {
        // Set session variables
        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role']
        ];
        return true;
    }

    // Authentication failed
    return false;
}

function displayFeedback($type, $message) {
    $alertType = '';

    switch ($type) {
        case 'success':
            $alertType = 'alert-success';
            break;
        case 'error':
            $alertType = 'alert-danger';
            break;
        case 'info':
            $alertType = 'alert-info';
            break;
        default:
            $alertType = 'alert-secondary';
    }

    return "<div class=\"alert $alertType\">$message</div>";
}

function registerUser($name, $email, $password) {
    global $conn;
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    return $stmt->execute([$name, $email, $hashed_password]);
}

function loginUser($email, $password) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        return $user;
    }
    return false;
}

function getAppointments($user_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM appointments WHERE user_id = ?");
    $stmt->execute([$user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function bookAppointment($user_id, $appointment_date, $specialty) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO appointments (user_id, appointment_date, specialty) VALUES (?, ?, ?)");
    return $stmt->execute([$user_id, $appointment_date, $specialty]);
}

function updateProfile($user_id, $name, $email) {
    global $conn;
    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
    return $stmt->execute([$name, $email, $user_id]);
}

function addDoctor($name, $specialty_id, $email, $phone) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO doctors (name, specialty_id, email, phone) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$name, $specialty_id, $email, $phone]);
}

function addSpecialty($name) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO specialties (name) VALUES (?)");
    return $stmt->execute([$name]);
}

function addMedicalRecord($user_id, $doctor_id, $appointment_id, $diagnosis, $treatment, $notes) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO medical_records (user_id, doctor_id, appointment_id, diagnosis, treatment, notes) VALUES (?, ?, ?, ?, ?, ?)");
    return $stmt->execute([$user_id, $doctor_id, $appointment_id, $diagnosis, $treatment, $notes]);
}

function generateReport($startDate, $endDate) {
    global $conn;
    $stmt = $conn->prepare("SELECT COUNT(*) AS total_appointments, SUM(amount) AS total_revenue FROM appointments WHERE appointment_date BETWEEN ? AND ?");
    $stmt->execute([$startDate, $endDate]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function addFeedback($user_id, $doctor_id, $appointment_id, $rating, $comments) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO feedback (user_id, doctor_id, appointment_id, rating, comments) VALUES (?, ?, ?, ?, ?)");
    return $stmt->execute([$user_id, $doctor_id, $appointment_id, $rating, $comments]);
}

function getNotifications($user_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM notifications WHERE user_id = ?");
    $stmt->execute([$user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getProviderSpecialties($provider_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT s.name FROM specialties s INNER JOIN provider_specialties ps ON s.id = ps.specialty_id WHERE ps.provider_id = ?");
    $stmt->execute([$provider_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getProviderAvailability($provider_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT pa.day_of_week, pa.start_time, pa.end_time, ct.name AS consultation_type FROM provider_availability pa INNER JOIN consultation_types ct ON pa.consultation_type_id = ct.id WHERE pa.provider_id = ?");
    $stmt->execute([$provider_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getProviderBookings($provider_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT a.id, a.appointment_date, u.name AS patient_name FROM appointments a INNER JOIN users u ON a.user_id = u.id WHERE a.provider_id = ?");
    $stmt->execute([$provider_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getProviderEarnings($provider_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT amount, booking_id, created_at FROM provider_earnings WHERE provider_id = ?");
    $stmt->execute([$provider_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllSpecialties() {
    global $conn;
    $stmt = $conn->query("SELECT * FROM specialties");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllConsultationTypes($provider_id) {
    global $conn;
    $stmt = $conn->query("SELECT * FROM consultation_types");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addProviderSpecialty($provider_id, $specialty_id) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO provider_specialties (provider_id, specialty_id) VALUES (?, ?)");
    return $stmt->execute([$provider_id, $specialty_id]);
}

function addProviderAvailability($provider_id, $day_of_week, $start_time, $end_time, $consultation_type_id) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO provider_availability (provider_id, day_of_week, start_time, end_time, consultation_type_id) VALUES (?, ?, ?, ?, ?)");
    return $stmt->execute([$provider_id, $day_of_week, $start_time, $end_time, $consultation_type_id]);
}


function getTestimonials() {
    global $conn;
    $stmt = $conn->query("SELECT * FROM testimonials");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>
