<?php
include 'includes/db.php';

// Seed specialties
$specialties = [
    'Cardiology',
    'Dermatology',
    'Neurology',
    'Pediatrics',
    'Oncology',
    'Orthopedics',
    'Psychiatry',
    'Radiology',
];

foreach ($specialties as $specialty) {
    $stmt = $conn->prepare("INSERT INTO specialties (name) VALUES (?)");
    $stmt->execute([$specialty]);
}

// Seed testimonials
$testimonials = [
    ['John Doe', 'Vital Care has provided me with excellent service. The doctors are very professional and caring.'],
    ['Jane Smith', 'I am very happy with the quality of care I received at Vital Care. Highly recommended!'],
    ['Sam Wilson', 'The staff at Vital Care is very friendly and accommodating. I always feel at ease during my visits.'],
    ['Emily Davis', 'The facilities at Vital Care are top-notch, and the doctors are very knowledgeable and attentive.'],
];

foreach ($testimonials as $testimonial) {
    $stmt = $conn->prepare("INSERT INTO testimonials (name, message) VALUES (?, ?)");
    $stmt->execute($testimonial);
}

echo "Database seeded successfully!";
?>
