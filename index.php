<?php
session_start();
include 'includes/db.php';
include 'includes/functions.php';
include 'includes/config.php';

// Fetch specialties
$specialties = getAllSpecialties();

// Fetch featured items (for demonstration purposes, we'll use specialties as featured items)
$featured = getAllSpecialties();

// Fetch testimonials
$testimonials = getTestimonials();

include 'includes/header.php';
?>

<div class="banner"></div>

<div class="section specialties">
    <body style="background_color:red;">
    <h2 class="section-title">Specialties</h2>
    <div class="row">
        <?php foreach ($specialties as $specialty): ?>
            <div class="col-md-4 mb-3">
                <div class="card">
                    
                    <div class="card-body text-center">
                        <h5 class="card-title"><?php echo $specialty['name']; ?></h5>
                        <a href="<?php echo BASE_URL; ?>/appointments/book.php?specialty=<?php echo urlencode($specialty['name']); ?>" class="btn btn-book"><i class="fas fa-calendar-alt"></i> Book</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!--
<div class="section featured">
    <h2 class="section-title">Featured</h2>
    <div class="row">
        <?php foreach ($featured as $item): ?>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <img src="<?php echo BASE_URL; ?>/images/specialties/<?php echo strtolower($item['name']); ?>.jpg" class="card-img-top" alt="<?php echo $item['name']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $item['name']; ?></h5>
                        <a href="<?php echo BASE_URL; ?>/appointments/book.php?specialty=<?php echo urlencode($item['name']); ?>" class="btn btn-book"><i class="fas fa-calendar-alt"></i> Book</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
        -->

<div class="section testimonials">
    <h2 class="section-title">Testimonials</h2>
    <div class="row">
        <?php foreach ($testimonials as $testimonial): ?>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <strong><?php echo $testimonial['name']; ?></strong>: <?php echo $testimonial['message']; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
        



