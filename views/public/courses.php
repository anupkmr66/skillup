<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Browse computer training courses at SkillUp">
    <title>Courses - SkillUp CIMS</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= url('public/assets/css/custom.css') ?>">
</head>

<body>

    <!-- Navigation -->
    <?php require_once VIEW_PATH . '/partials/public_navbar.php'; ?>

    <!-- Page Header -->
    <section class="py-5 text-white page-header-spacing" style="background: linear-gradient(135deg, #667eea, #764ba2);">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-3" data-aos="fade-up">Our Courses</h1>
            <p class="lead" data-aos="fade-up" data-aos-delay="200">
                Professional Computer Training Programs
            </p>
        </div>
    </section>

    <!-- Courses Grid -->
    <section class="py-5">
        <div class="container">
            <?php if (empty($courses)): ?>
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle me-2"></i>
                    No courses available at the moment. Please check back later.
                </div>
            <?php else: ?>
                <div class="row g-4">
                    <?php foreach ($courses as $index => $course): ?>
                        <div class="col-md-6 col-lg-4 d-flex align-items-stretch" data-aos="fade-up"
                            data-aos-delay="<?= $index * 100 ?>">
                            <div class="card w-100 border-0 shadow-lg overflow-hidden course-card transition-all">
                                <!-- Card Header / Image Placeholder -->
                                <div class="course-header text-white p-4 d-flex align-items-center justify-content-center"
                                    style="min-height: 140px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); position: relative;">
                                    <div class="text-center position-relative" style="z-index: 2;">
                                        <i class="fas fa-laptop-code fa-3x mb-2 opacity-75"></i>
                                        <h4 class="fw-bold mb-0 text-white"><?= e($course['course_name']) ?></h4>
                                        <span
                                            class="badge bg-white text-primary mt-2 shadow-sm rounded-pill px-3"><?= e($course['category'] ?: 'Certificate') ?></span>
                                    </div>
                                    <!-- Decorative Circles -->
                                    <div class="position-absolute"
                                        style="top: -20px; right: -20px; width: 100px; height: 100px; background: rgba(255,255,255,0.1); border-radius: 50%;">
                                    </div>
                                    <div class="position-absolute"
                                        style="bottom: -10px; left: -10px; width: 60px; height: 60px; background: rgba(255,255,255,0.1); border-radius: 50%;">
                                    </div>
                                </div>

                                <div class="card-body p-4 d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="text-muted small"><i class="fas fa-code text-primary me-1"></i>
                                            <?= e($course['course_code']) ?></span>
                                        <span class="text-muted small"><i class="fas fa-clock text-warning me-1"></i>
                                            <?= e($course['duration']) ?> Months</span>
                                    </div>

                                    <p class="text-muted flex-grow-1 mb-4" style="font-size: 0.95rem; line-height: 1.6;">
                                        <?= e(substr($course['description'] ?? 'Professional training course designed for career growth.', 0, 100)) ?>...
                                    </p>

                                    <?php if ($course['syllabus']): ?>
                                        <div class="bg-light p-3 rounded mb-3 small text-muted">
                                            <i class="fas fa-list-ul me-2 text-secondary"></i>
                                            <strong>Includes: </strong>
                                            <?= e(substr($course['syllabus'], 0, 50)) ?>...
                                        </div>
                                    <?php endif; ?>

                                    <div class="mt-auto">
                                        <div class="d-flex justify-content-between align-items-end mb-3">
                                            <div>
                                                <small class="text-muted d-block text-uppercase fw-bold"
                                                    style="font-size: 0.7rem;">Course Fee</small>
                                                <div class="d-flex align-items-baseline">
                                                    <span
                                                        class="fs-4 fw-bold text-success me-2">₹<?= number_format($course['offer_price']) ?></span>
                                                    <?php if (!empty($course['regular_price']) && $course['regular_price'] > $course['offer_price']): ?>
                                                        <small
                                                            class="text-muted text-decoration-line-through">₹<?= number_format($course['regular_price']) ?></small>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star-half-alt text-warning"></i>
                                            </div>
                                        </div>

                                        <a href="<?= url('course/details?id=' . $course['id']) ?>"
                                            class="btn btn-primary w-100 rounded-pill py-2 fw-bold shadow-sm course-btn">
                                            View Details <i class="fas fa-arrow-right ms-2"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 bg-light">
        <div class="container text-center">
            <h2 class="mb-4" data-aos="fade-up">Can't Find What You're Looking For?</h2>
            <p class="lead mb-4 text-muted" data-aos="fade-up" data-aos-delay="200">
                Contact us for customized training solutions
            </p>
            <div data-aos="fade-up" data-aos-delay="400">
                <a href="<?= url('contact') ?>" class="btn btn-primary btn-lg">
                    <i class="fas fa-phone me-2"></i>Contact Us
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php require_once VIEW_PATH . '/partials/public_footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="<?= url('public/assets/js/main.js') ?>"></script>
</body>

</html>