<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Franchise Inquiry -SkillUp CIMS</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= url('public/assets/css/custom.css') ?>">
</head>

<body>

    <!-- Navigation -->
    <?php require_once VIEW_PATH . '/partials/public_navbar.php'; ?>

    <!-- Hero Section -->
    <section class="py-5 text-white page-header-spacing" style="background: linear-gradient(135deg, #667eea, #764ba2);">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-3" data-aos="fade-up">
                <i class="fas fa-handshake me-3"></i>Become a Franchise Partner
            </h1>
            <p class="lead" data-aos="fade-up" data-aos-delay="200">
                Join India's Leading Computer Education Network
            </p>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5" data-aos="fade-up">Why Partner With Us?</h2>

            <div class="row">
                <div class="col-md-4 mb-4" data-aos="zoom-in">
                    <div class="card h-100 text-center border-0 shadow">
                        <div class="card-body p-4">
                            <i class="fas fa-chart-line fa-3x text-success mb-3"></i>
                            <h5>High ROI</h5>
                            <p class="text-muted">Attractive commission structure and recurring revenue model</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4" data-aos="zoom-in" data-aos-delay="100">
                    <div class="card h-100 text-center border-0 shadow">
                        <div class="card-body p-4">
                            <i class="fas fa-headset fa-3x text-primary mb-3"></i>
                            <h5>Complete Support</h5>
                            <p class="text-muted">Training, marketing materials, and ongoing technical support</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4" data-aos="zoom-in" data-aos-delay="200">
                    <div class="card h-100 text-center border-0 shadow">
                        <div class="card-body p-4">
                            <i class="fas fa-award fa-3x text-warning mb-3"></i>
                            <h5>Proven Brand</h5>
                            <p class="text-muted">Established reputation in computer education sector</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Inquiry Form -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-lg border-0">
                        <div class="card-body p-5">
                            <h3 class="text-center mb-4">Franchise Inquiry Form</h3>

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

                            <form method="POST" action="<?= url('franchise-inquiry') ?>">
                                <?= CSRF::field() ?>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Full Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email Address <span
                                                class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">Phone Number <span
                                                class="text-danger">*</span></label>
                                        <input type="tel" class="form-control" id="phone" name="phone" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="city" class="form-label">City <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="city" name="city" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="state" class="form-label">State <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="state" name="state" required>
                                        <option value="">Select State</option>
                                        <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                                        <option value="Andhra Pradesh">Andhra Pradesh</option>
                                        <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                        <option value="Assam">Assam</option>
                                        <option value="Bihar">Bihar</option>
                                        <option value="Chandigarh">Chandigarh</option>
                                        <option value="Chhattisgarh">Chhattisgarh</option>
                                        <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli
                                            and Daman and Diu</option>
                                        <option value="Delhi">Delhi</option>
                                        <option value="Goa">Goa</option>
                                        <option value="Gujarat">Gujarat</option>
                                        <option value="Haryana">Haryana</option>
                                        <option value="Himachal Pradesh">Himachal Pradesh</option>
                                        <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                                        <option value="Jharkhand">Jharkhand</option>
                                        <option value="Karnataka">Karnataka</option>
                                        <option value="Kerala">Kerala</option>
                                        <option value="Ladakh">Ladakh</option>
                                        <option value="Lakshadweep">Lakshadweep</option>
                                        <option value="Madhya Pradesh">Madhya Pradesh</option>
                                        <option value="Maharashtra">Maharashtra</option>
                                        <option value="Manipur">Manipur</option>
                                        <option value="Meghalaya">Meghalaya</option>
                                        <option value="Mizoram">Mizoram</option>
                                        <option value="Nagaland">Nagaland</option>
                                        <option value="Odisha">Odisha</option>
                                        <option value="Puducherry">Puducherry</option>
                                        <option value="Punjab">Punjab</option>
                                        <option value="Rajasthan">Rajasthan</option>
                                        <option value="Sikkim">Sikkim</option>
                                        <option value="Tamil Nadu">Tamil Nadu</option>
                                        <option value="Telangana">Telangana</option>
                                        <option value="Tripura">Tripura</option>
                                        <option value="Uttar Pradesh">Uttar Pradesh</option>
                                        <option value="Uttarakhand">Uttarakhand</option>
                                        <option value="West Bengal">West Bengal</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="message" class="form-label">Tell us about yourself</label>
                                    <textarea class="form-control" id="message" name="message" rows="4"
                                        placeholder="Your experience, investment capacity, preferred location, etc."></textarea>
                                </div>

                                <div class="form-check mb-4">
                                    <input class="form-check-input" type="checkbox" id="agree" required>
                                    <label class="form-check-label" for="agree">
                                        I agree to be contacted by SkillUp regarding franchise opportunities
                                    </label>
                                </div>

                                <button type="submit" class="btn btn-primary btn-lg w-100">
                                    <i class="fas fa-paper-plane me-2"></i>Submit Inquiry
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Investment Details -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Investment & Returns</h2>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="text-primary mb-3">
                                <i class="fas fa-rupee-sign me-2"></i>Investment Range
                            </h5>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Franchise Fee: ₹2,00,000
                                    - ₹5,00,000</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Infrastructure: ₹3,00,000
                                    - ₹8,00,000</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Working Capital:
                                    ₹1,00,000 - ₹2,00,000</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="text-success mb-3">
                                <i class="fas fa-hand-holding-usd me-2"></i>Expected Returns
                            </h5>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Break-even: 12-18 months
                                </li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Commission: 10-15% on
                                    enrollments</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>ROI: 25-30% annually</li>
                            </ul>
                        </div>
                    </div>
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