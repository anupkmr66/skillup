<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Contact SkillUp - Get in touch with us">
    <title>Contact Us - SkillUp CIMS</title>

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
            <h1 class="display-4 fw-bold mb-3" data-aos="fade-up">Contact Us</h1>
            <p class="lead" data-aos="fade-up" data-aos-delay="200">
                We'd love to hear from you
            </p>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Contact Form -->
                <div class="col-md-7 mb-4" data-aos="fade-right">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <h3 class="mb-4">Send Us a Message</h3>

                            <?php if ($success = getFlash('success')): ?>
                                <div class="alert alert-success">
                                    <i class="fas fa-check-circle me-2"></i><?= e($success) ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($error = getFlash('error')): ?>
                                <div class="alert alert-danger">
                                    <i class="fas fa-exclamation-circle me-2"></i><?= e($error) ?>
                                </div>
                            <?php endif; ?>

                            <form method="POST" action="<?= url('contact') ?>" id="contactForm">
                                <?= CSRF::field() ?>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email <span
                                                class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="tel" class="form-control" id="phone" name="phone">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="subject" class="form-label">Subject</label>
                                        <input type="text" class="form-control" id="subject" name="subject">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="message" class="form-label">Message <span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" id="message" name="message" rows="5"
                                        required></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary btn-lg w-100">
                                    <i class="fas fa-paper-plane me-2"></i>Send Message
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="col-md-5 mb-4" data-aos="fade-left">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body p-4">
                            <h3 class="mb-4">Contact Information</h3>

                            <div class="mb-4">
                                <h6 class="text-primary mb-2">
                                    <i class="fas fa-map-marker-alt me-2"></i>Address
                                </h6>
                                <p class="text-muted mb-0">
                                    123, Education Hub<br>
                                    New Delhi - 110001<br>
                                    India
                                </p>
                            </div>

                            <div class="mb-4">
                                <h6 class="text-primary mb-2">
                                    <i class="fas fa-phone me-2"></i>Phone
                                </h6>
                                <p class="text-muted mb-0">
                                    +91-9876543210
                                </p>
                            </div>

                            <div class="mb-4">
                                <h6 class="text-primary mb-2">
                                    <i class="fas fa-envelope me-2"></i>Email
                                </h6>
                                <p class="text-muted mb-0">
                                    info@skillup.com<br>
                                    support@skillup.com
                                </p>
                            </div>

                            <div>
                                <h6 class="text-primary mb-2">
                                    <i class="fas fa-clock me-2"></i>Business Hours
                                </h6>
                                <p class="text-muted mb-0">
                                    Monday - Saturday: 9:00 AM - 6:00 PM<br>
                                    Sunday: Closed
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <h5 class="mb-3">Follow Us</h5>
                            <div class="d-flex gap-3">
                                <a href="#" class="btn btn-outline-primary btn-sm">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="#" class="btn btn-outline-info btn-sm">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="#" class="btn btn-outline-danger btn-sm">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="#" class="btn btn-outline-primary btn-sm">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section (Placeholder) -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3501.7419!2d77.2090!3d28.6139!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjjCsDM2JzUwLjAiTiA3N8KwMTInMzIuNCJF!5e0!3m2!1sen!2sin!4v1234567890"
                        width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy">
                    </iframe>
                </div>
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