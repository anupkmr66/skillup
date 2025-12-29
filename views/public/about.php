<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="About SkillUp - Leading Computer Center Management System">
    <title>About Us - SkillUp CIMS</title>

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
            <h1 class="display-4 fw-bold mb-3" data-aos="fade-up">About SkillUp</h1>
            <p class="lead" data-aos="fade-up" data-aos-delay="200">
                Empowering Computer Education Through Technology
            </p>
        </div>
    </section>

    <!-- About Content -->
    <section class="py-5">
        <div class="container">
            <div class="row align-items-center mb-5">
                <div class="col-md-6" data-aos="fade-right">
                    <h2 class="mb-4">Who We Are</h2>
                    <p class="text-muted">
                        SkillUp is a comprehensive Computer Center Management System designed to streamline
                        operations for computer training institutes and franchise networks. Our platform
                        provides end-to-end solutions for managing students, courses, fees, exams, and
                        franchise operations.
                    </p>
                    <p class="text-muted">
                        With years of experience in educational technology, we understand the unique challenges
                        faced by computer training institutes. Our system is built to address these challenges
                        with innovative features and user-friendly interfaces.
                    </p>
                </div>
                <div class="col-md-6" data-aos="fade-left">
                    <img src="https://via.placeholder.com/500x350/667eea/ffffff?text=SkillUp+Platform"
                        class="img-fluid rounded shadow" alt="SkillUp Platform">
                </div>
            </div>

            <div class="row align-items-center mb-5">
                <div class="col-md-6 order-md-2" data-aos="fade-left">
                    <h2 class="mb-4">Our Mission</h2>
                    <p class="text-muted">
                        To revolutionize computer education management by providing institutions with
                        powerful, secure, and easy-to-use tools that enhance operational efficiency and
                        improve student outcomes.
                    </p>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Simplify institute
                            operations</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Enhance student
                            experience</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Enable franchise growth
                        </li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Ensure data security</li>
                    </ul>
                </div>
                <div class="col-md-6 order-md-1" data-aos="fade-right">
                    <img src="https://via.placeholder.com/500x350/764ba2/ffffff?text=Our+Mission"
                        class="img-fluid rounded shadow" alt="Our Mission">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5" data-aos="fade-up">Why Choose SkillUp?</h2>

            <div class="row">
                <div class="col-md-3 mb-4" data-aos="zoom-in">
                    <div class="card h-100 text-center border-0 shadow-sm">
                        <div class="card-body">
                            <div class="mb-3">
                                <i class="fas fa-shield-alt fa-3x text-primary"></i>
                            </div>
                            <h5>Secure & Reliable</h5>
                            <p class="text-muted small">Enterprise-grade security with encrypted data storage</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-4" data-aos="zoom-in" data-aos-delay="100">
                    <div class="card h-100 text-center border-0 shadow-sm">
                        <div class="card-body">
                            <div class="mb-3">
                                <i class="fas fa-mobile-alt fa-3x text-success"></i>
                            </div>
                            <h5>Mobile Friendly</h5>
                            <p class="text-muted small">Access from any device, anywhere, anytime</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-4" data-aos="zoom-in" data-aos-delay="200">
                    <div class="card h-100 text-center border-0 shadow-sm">
                        <div class="card-body">
                            <div class="mb-3">
                                <i class="fas fa-headset fa-3x text-warning"></i>
                            </div>
                            <h5>24/7 Support</h5>
                            <p class="text-muted small">Dedicated support team always ready to help</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-4" data-aos="zoom-in" data-aos-delay="300">
                    <div class="card h-100 text-center border-0 shadow-sm">
                        <div class="card-body">
                            <div class="mb-3">
                                <i class="fas fa-chart-line fa-3x text-danger"></i>
                            </div>
                            <h5>Analytics</h5>
                            <p class="text-muted small">Comprehensive reports and insights</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 text-white" style="background: linear-gradient(135deg, #667eea, #764ba2);">
        <div class="container text-center">
            <h2 class="mb-4" data-aos="fade-up">Ready to Transform Your Institute?</h2>
            <p class="lead mb-4" data-aos="fade-up" data-aos-delay="200">
                Join hundreds of institutes already using SkillUp
            </p>
            <div data-aos="fade-up" data-aos-delay="400">
                <a href="<?= url('franchise-inquiry') ?>" class="btn btn-light btn-lg me-3">
                    <i class="fas fa-handshake me-2"></i>Become a Franchise
                </a>
                <a href="<?= url('contact') ?>" class="btn btn-outline-light btn-lg">
                    <i class="fas fa-envelope me-2"></i>Contact Us
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