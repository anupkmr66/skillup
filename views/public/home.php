<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="SkillUp Computer Center Management System with Franchise Management - Professional institute management solution">
    <title>SkillUp - Computer Center Management System</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= url('public/assets/css/custom.css') ?>">
</head>

<body>

    <!-- Navigation -->
    <?php require_once VIEW_PATH . '/partials/public_navbar.php'; ?>


    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content">
            <h1 class="hero-title" data-aos="fade-up">
                COMPUTER CENTER MANAGEMENT SYSTEM
            </h1>

            <div class="hero-badge" data-aos="fade-up" data-aos-delay="200">
                <i class="fas fa-star me-2"></i>WITH FRANCHISE MANAGEMENT
            </div>

            <p class="hero-description" data-aos="fade-up" data-aos-delay="400">
                Complete solution for managing computer training institutes, students, courses,<br>
                fees, exams, certificates, and franchise operations - all in one powerful system
            </p>

            <div class="d-flex gap-3 justify-content-center mb-5" data-aos="fade-up" data-aos-delay="600">
                <a href="<?= url('login') ?>" class="btn btn-primary btn-lg">
                    <i class="fas fa-sign-in-alt me-2"></i> Login to Dashboard
                </a>
                <a href="<?= url('franchise-inquiry') ?>" class="btn btn-outline btn-lg">
                    <i class="fas fa-handshake me-2"></i> Become a Franchise
                </a>
            </div>

            <!-- Feature Cards Grid -->
            <div class="features-grid" data-aos="fade-up" data-aos-delay="800">
                <div class="feature-card" data-aos="zoom-in" data-aos-delay="100">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="feature-title">Unlimited Students</h3>
                </div>

                <div class="feature-card" data-aos="zoom-in" data-aos-delay="200">
                    <div class="feature-icon">
                        <i class="fas fa-network-wired"></i>
                    </div>
                    <h3 class="feature-title">Unlimited Franchise</h3>
                </div>

                <div class="feature-card" data-aos="zoom-in" data-aos-delay="300">
                    <div class="feature-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <h3 class="feature-title">Fees Management</h3>
                </div>

                <div class="feature-card" data-aos="zoom-in" data-aos-delay="400">
                    <div class="feature-icon">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <h3 class="feature-title">Certificate Verification</h3>
                </div>

                <div class="feature-card" data-aos="zoom-in" data-aos-delay="500">
                    <div class="feature-icon">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <h3 class="feature-title">Franchise Wallet</h3>
                </div>

                <div class="feature-card" data-aos="zoom in" data-aos-delay="600">
                    <div class="feature-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h3 class="feature-title">Admit Card, Exam & Result</h3>
                </div>

                <div class="feature-card" data-aos="zoom-in" data-aos-delay="700">
                    <div class="feature-icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <h3 class="feature-title">Courses & Study Material</h3>
                </div>

                <div class="feature-card" data-aos="zoom-in" data-aos-delay="800">
                    <div class="feature-icon">
                        <i class="fas fa-user-lock"></i>
                    </div>
                    <h3 class="feature-title">Multiple User Login</h3>
                </div>

                <div class="feature-card" data-aos="zoom-in" data-aos-delay="900">
                    <div class="feature-icon">
                        <i class="fas fa-globe"></i>
                    </div>
                    <h3 class="feature-title">Frontend Website</h3>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Links Section -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-4 mb-4" data-aos="fade-up">
                    <div class="card h-100">
                        <div class="card-body">
                            <i class="fas fa-graduation-cap fa-3x text-primary mb-3"></i>
                            <h3>Courses</h3>
                            <p class="text-muted">Explore our comprehensive computer training courses</p>
                            <a href="<?= url('courses') ?>" class="btn btn-primary">View Courses</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card h-100">
                        <div class="card-body">
                            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                            <h3>Verify Certificate</h3>
                            <p class="text-muted">Verify the authenticity of certificates instantly</p>
                            <a href="<?= url('verify-certificate') ?>" class="btn btn-success">Verify Now</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="card h-100">
                        <div class="card-body">
                            <i class="fas fa-envelope fa-3x text-info mb-3"></i>
                            <h3>Contact Us</h3>
                            <p class="text-muted">Get in touch with us for any queries</p>
                            <a href="<?= url('contact') ?>" class="btn btn-info text-white">Contact Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5" data-aos="fade-up">
                <span class="gradient-text">Why Choose SkillUp?</span>
            </h2>

            <div class="row">
                <div class="col-md-6 mb-4" data-aos="fade-right">
                    <div class="card h-100">
                        <div class="card-body">
                            <h4><i class="fas fa-shield-alt text-primary me-2"></i> Secure & Reliable</h4>
                            <p class="text-muted">
                                Built with enterprise-grade security featuring role-based access control,
                                encrypted data, and secure session management.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4" data-aos="fade-left">
                    <div class="card h-100">
                        <div class="card-body">
                            <h4><i class="fas fa-mobile-alt text-success me-2"></i> Mobile Responsive</h4>
                            <p class="text-muted">
                                Access from anywhere, any device. Fully responsive design that works
                                seamlessly on desktop, tablet, and mobile devices.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4" data-aos="fade-right" data-aos-delay="200">
                    <div class="card h-100">
                        <div class="card-body">
                            <h4><i class="fas fa-chart-line text-warning me-2"></i> Detailed Reports</h4>
                            <p class="text-muted">
                                Comprehensive reporting system with student performance, fee collection,
                                franchise earnings, and detailed analytics.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4" data-aos="fade-left" data-aos-delay="200">
                    <div class="card h-100">
                        <div class="card-body">
                            <h4><i class="fas fa-headset text-danger me-2"></i> 24/7 Support</h4>
                            <p class="text-muted">
                                Dedicated support team available round the clock to assist you with
                                any technical or operational queries.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php require_once VIEW_PATH . '/partials/public_footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- Custom JS -->
    <script src="<?= url('public/assets/js/main.js') ?>"></script>
</body>

</html>