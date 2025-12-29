<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($course['course_name']) ?> - SkillUp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= url('public/assets/css/custom.css') ?>">
    <style>
        .course-hero {
            background: linear-gradient(135deg, #1a2a6c, #b21f1f, #fdbb2d);
            background-size: 200% 200%;
            animation: gradientBG 15s ease infinite;
            color: white;
            padding: 160px 0 100px 0;
            /* Keep the good padding */
            position: relative;
            overflow: hidden;
        }

        @keyframes gradientBG {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .course-hero::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -100px;
            right: -100px;
            animation: float 6s ease-in-out infinite;
        }

        .course-hero::after {
            content: '';
            position: absolute;
            width: 250px;
            height: 250px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            bottom: -50px;
            left: -50px;
            animation: float 8s ease-in-out infinite reverse;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .info-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 30px;
            position: relative;
            z-index: 10;
        }

        .sidebar-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            /* Sticky Sidebar */
            z-index: 20;
        }

        /* Responsive Margins for Overlap */
        @media (min-width: 992px) {

            .info-card,
            .sidebar-card {
                margin-top: -60px;
                /* Increased overlap as requested */
            }
        }

        @media (max-width: 991px) {
            .info-card {
                margin-top: -30px;
            }

            .sidebar-card {
                margin-top: 30px;
            }
        }

        .nav-pills .nav-link {
            color: #555;
            background: #f8f9fa;
            margin-right: 10px;
            border-radius: 50px;
            /* Rounded pills */
            padding: 10px 25px;
            transition: all 0.3s;
            font-weight: 600;
        }

        .nav-pills .nav-link.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            box-shadow: 0 5px 15px rgba(118, 75, 162, 0.4);
        }

        .sidebar-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 100px;
            /* Sticky Sidebar */
        }
    </style>
</head>

<body>

    <?php require_once VIEW_PATH . '/partials/public_navbar.php'; ?>

    <!-- Hero Section -->
    <section class="course-hero">
        <div class="container position-relative" style="z-index: 2;">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <?php if ($course['category']): ?>
                        <span class="badge bg-light text-primary mb-3"><?= e($course['category']) ?></span>
                    <?php endif; ?>
                    <h1 class="display-3 fw-bold mb-3"><?= e($course['course_name']) ?></h1>
                    <p class="lead mb-4 opacity-75">Code: <?= e($course['course_code']) ?> | Duration:
                        <?= e($course['duration']) ?> Months
                    </p>
                    <button class="btn btn-light btn-lg px-5 py-3 fw-bold rounded-pill text-primary"
                        data-bs-toggle="modal" data-bs-target="#leadFormModal">
                        <i class="fas fa-paper-plane me-2"></i>Enroll Now
                    </button>
                </div>
                <div class="col-lg-4 text-center d-none d-lg-block">
                    <i class="fas fa-graduation-cap fa-10x opacity-50 text-white"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container pb-5">
        <div class="row">
            <!-- Left Column -->
            <div class="col-lg-8">
                <div class="info-card mb-5">
                    <ul class="nav nav-pills mb-4" id="courseTab" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="pill"
                                data-bs-target="#overview">Overview</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#syllabus">Syllabus</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#faq">FAQ</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="courseTabContent">
                        <div class="tab-pane fade show active" id="overview">
                            <h3 class="mb-4">About the Course</h3>
                            <p class="text-muted lead"><?= nl2br(e($course['description'])) ?></p>

                            <div class="row mt-5">
                                <div class="col-md-6 mb-4">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                                            <i class="fas fa-certificate text-primary fa-2x"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-1">Certified</h5>
                                            <p class="mb-0 text-muted">Get recognized verification</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-success bg-opacity-10 p-3 rounded-circle me-3">
                                            <i class="fas fa-chalkboard-teacher text-success fa-2x"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-1">Expert Mentors</h5>
                                            <p class="mb-0 text-muted">Learn from the best</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="syllabus">
                            <h3 class="mb-4">Course Syllabus</h3>
                            <div class="bg-light p-4 rounded-3 text-muted">
                                <?= $course['syllabus'] ? nl2br(e($course['syllabus'])) : 'Detailed syllabus available on request.' ?>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="faq">
                            <div class="accordion" id="faqAccordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#faq1">
                                            Is there any prerequisite for this course?
                                        </button>
                                    </h2>
                                    <div id="faq1" class="accordion-collapse collapse show"
                                        data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            Basic computer knowledge is recommended but not mandatory for beginners
                                            courses.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#faq2">
                                            Do you provide placement assistance?
                                        </button>
                                    </h2>
                                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            Yes, we provide career guidance and placement assistance for top performing
                                            students.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar -->
            <div class="col-lg-4" style="margin-top: -100px;">
                <div class="card sidebar-card mb-4 position-relative">
                    <div class="card-body p-4">
                        <div class="alert alert-warning gradient-alert text-white shadow-sm mb-4" role="alert"
                            style="background: linear-gradient(45deg, #ff6b6b, #f06595); border: none;">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-gift fa-2x me-3"></i>
                                <div>
                                    <h6 class="alert-heading fw-bold mb-1">Special Offer! 🎉</h6>
                                    <p class="mb-0 small">Join any course and get <a
                                            href="<?= url('course/details?id=2') ?>"
                                            class="text-white fw-bold text-decoration-underline">Typing Course
                                            ABSOLUTELY FREE!</a></p>
                                </div>
                            </div>
                        </div>
                        <h4 class="text-center mb-4">Course Fee</h4>
                        <div class="text-center mb-4">
                            <?php if (!empty($course['regular_price']) && $course['regular_price'] > $course['offer_price']): ?>
                                <span
                                    class="text-muted text-decoration-line-through fs-5 me-2">₹<?= number_format($course['regular_price'], 2) ?></span>
                            <?php endif; ?>
                            <span
                                class="display-4 fw-bold text-success">₹<?= number_format($course['offer_price'], 2) ?></span>
                        </div>

                        <div class="d-grid gap-2">
                            <button class="btn btn-primary btn-lg shine-effect" data-bs-toggle="modal"
                                data-bs-target="#leadFormModal">
                                Enroll Now
                            </button>
                            <a href="<?= url('contact') ?>" class="btn btn-outline-dark">Talk to Counselor</a>
                        </div>

                        <hr class="my-4">

                        <ul class="list-unstyled mb-0">
                            <li class="mb-3"><i class="fas fa-check-circle text-success me-2"></i>Full Access</li>
                            <li class="mb-3"><i class="fas fa-check-circle text-success me-2"></i>Study Material</li>
                            <li class="mb-3"><i class="fas fa-check-circle text-success me-2"></i>Certificate of
                                Completion</li>
                        </ul>
                    </div>
                </div>

                <!-- Other Courses Widget -->
                <?php if (!empty($otherCourses)): ?>
                    <div class="card sidebar-card">
                        <div class="card-header bg-white border-0 pt-4">
                            <h5 class="mb-0">You might also like</h5>
                        </div>
                        <div class="card-body">
                            <?php foreach ($otherCourses as $other): ?>
                                <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                                    <div class="bg-light p-2 rounded me-3">
                                        <i class="fas fa-book text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1"><a href="<?= url('course/details?id=' . $other['id']) ?>"
                                                class="text-decoration-none text-dark"><?= e($other['course_name']) ?></a></h6>
                                        <small class="text-success fw-bold">₹<?= number_format($other['offer_price']) ?></small>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php require_once VIEW_PATH . '/partials/lead_form_modal.php'; ?>
    <?php require_once VIEW_PATH . '/partials/public_footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= url('public/assets/js/main.js') ?>"></script>
</body>

</html>