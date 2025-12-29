<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate Verification - SkillUp CIMS</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= url('public/assets/css/custom.css') ?>">
</head>

<body>

    <!-- Navigation -->
    <?php require_once VIEW_PATH . '/partials/public_navbar.php'; ?>

    <!-- Page Header -->
    <section class="py-5 text-white page-header-spacing" style="background: linear-gradient(135deg, #667eea, #764ba2);">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-3">
                <i class="fas fa-shield-alt me-3"></i>Certificate Verification
            </h1>
            <p class="lead">
                Verify the authenticity of certificates instantly
            </p>
        </div>
    </section>

    <!-- Verification Section -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-lg border-0">
                        <div class="card-body p-5">
                            <div class="text-center mb-4">
                                <i class="fas fa-certificate fa-4x text-primary mb-3"></i>
                                <h3>Enter Certificate Number</h3>
                                <p class="text-muted">Enter the certificate number to verify its authenticity</p>
                            </div>

                            <form id="verificationForm">
                                <div class="input-group input-group-lg mb-3">
                                    <span class="input-group-text">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text" class="form-control" id="certificate_number"
                                        name="certificate_number" placeholder="e.g., CERT-000123" required>
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-check me-2"></i>Verify
                                    </button>
                                </div>
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Certificate numbers are case-sensitive
                                </small>
                            </form>

                            <!-- Result Container -->
                            <div id="resultContainer" class="mt-4" style="display: none;">
                                <!-- Results will be loaded here via AJAX -->
                            </div>
                        </div>
                    </div>

                    <!-- How to Find Certificate Number -->
                    <div class="card mt-4 shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="mb-3">
                                <i class="fas fa-question-circle me-2"></i>How to find your certificate number?
                            </h5>
                            <ul class="mb-0">
                                <li>The certificate number is printed on the top-right corner of your certificate</li>
                                <li>It typically starts with "CERT-" followed by a unique number</li>
                                <li>Example format: CERT-000123</li>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?= url('public/assets/js/main.js') ?>"></script>

    <script>
        document.getElementById('verificationForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const certificateNumber = document.getElementById('certificate_number').value;
            const resultContainer = document.getElementById('resultContainer');

            if (!certificateNumber.trim()) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Invalid Input',
                    text: 'Please enter a certificate number'
                });
                return;
            }

            // Show loading
            resultContainer.innerHTML = `
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted">Verifying certificate...</p>
                </div>
            `;
            resultContainer.style.display = 'block';

            // AJAX request
            fetch('<?= url('verify-certificate') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'certificate_number=' + encodeURIComponent(certificateNumber)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Check if pre-rendered HTML is returned (for Franchise Certificates)
                        if (data.html) {
                            resultContainer.innerHTML = data.html;
                            return;
                        }

                        // Valid certificate (Student - Existing Logic)
                        resultContainer.innerHTML = `
                        <div class="alert alert-success border-0 shadow-sm">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-check-circle fa-3x text-success me-3"></i>
                                <div>
                                    <h4 class="mb-0">✅ Certificate Verified!</h4>
                                    <p class="mb-0">This is a valid certificate issued by SkillUp</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-2"><strong>Student Name:</strong><br>${data.data.student_name}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-2"><strong>Certificate No:</strong><br>${data.data.certificate_number}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-2"><strong>Course:</strong><br>${data.data.course_name}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-2"><strong>Grade:</strong><br>${data.data.grade}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-2"><strong>Institute:</strong><br>${data.data.institute_name}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-0"><strong>Issue Date:</strong><br>${data.data.issue_date}</p>
                                </div>
                            </div>
                        </div>
                    `;
                    } else {
                        // Invalid certificate
                        resultContainer.innerHTML = `
                        <div class="alert alert-danger border-0 shadow-sm">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-times-circle fa-3x text-danger me-3"></i>
                                <div>
                                    <h4 class="mb-0">❌ Verification Failed</h4>
                                    <p class="mb-0">${data.message}</p>
                                </div>
                            </div>
                        </div>
                    `;
                    }
                })
                .catch(error => {
                    resultContainer.innerHTML = `
                    <div class="alert alert-warning border-0 shadow-sm">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Error verifying certificate. Please try again.
                    </div>
                `;
                });
        });
    </script>
</body>

</html>