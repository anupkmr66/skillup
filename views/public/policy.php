<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refund & Cancellation Policy - SkillUp CIMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= url('public/assets/css/custom.css') ?>">
</head>

<body>
    <?php require_once VIEW_PATH . '/partials/public_navbar.php'; ?>

    <section class="py-5 text-white page-header-spacing" style="background: linear-gradient(135deg, #667eea, #764ba2);">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-3">Refund Policy</h1>
            <p class="lead">Our policy regarding cancellations and refunds</p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="card shadow-sm border-0">
                <div class="card-body p-5">
                    <h4>1. Course Fee Refunds</h4>
                    <p>Fees once paid for any course are non-refundable and non-transferable. Students are advised to
                        verify the course details and eligibility before enrolling.</p>

                    <h4 class="mt-4">2. Franchise Fee</h4>
                    <p>Franchise registration fees are non-refundable. The processing fee paid at the time of
                        application is for the verification process and will not be returned regardless of the
                        application outcome.</p>

                    <h4 class="mt-4">3. Duplicate Payment</h4>
                    <p>In case of double payment due to server error or technical glitch, the extra amount will be
                        refunded to the original payment source within 7-10 working days upon verification.</p>

                    <h4 class="mt-4">4. Cancellation Policy</h4>
                    <p>Admissions can be cancelled by the student within 3 days of registration, but the admission fee
                        will customized. Specific course cancellations are subject to the institute's discretion.</p>

                    <h4 class="mt-4">5. Contact Us</h4>
                    <p>If you have any questions about our Refund and Cancellation Policy, please contact us at
                        support@skillup.com.</p>
                </div>
            </div>
        </div>
    </section>

    <?php require_once VIEW_PATH . '/partials/public_footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= url('public/assets/js/main.js') ?>"></script>
</body>

</html>