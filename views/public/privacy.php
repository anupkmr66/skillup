<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy - SkillUp CIMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= url('public/assets/css/custom.css') ?>">
</head>

<body>
    <?php require_once VIEW_PATH . '/partials/public_navbar.php'; ?>

    <section class="py-5 text-white page-header-spacing" style="background: linear-gradient(135deg, #667eea, #764ba2);">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-3">Privacy Policy</h1>
            <p class="lead">Your privacy is important to us</p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="card shadow-sm border-0">
                <div class="card-body p-5">
                    <h4>1. Information We Collect</h4>
                    <p>We collect information that you provide directly to us, such as when you create an account,
                        enroll in a course, or contact us for support. This may include your name, email address, phone
                        number, and payment information.</p>

                    <h4 class="mt-4">2. How We Use Your Information</h4>
                    <p>We use the information we collect to provide, maintain, and improve our services, to process your
                        transactions, to send you related information, including confirmations and invoices, and to
                        communicate with you about promotions and events.</p>

                    <h4 class="mt-4">3. Data Security</h4>
                    <p>We implement appropriate security measures to protect against unauthorized access to or
                        unauthorized alteration, disclosure, or destruction of data. However, no data transmission over
                        the Internet or wireless network can be guaranteed to be 100% secure.</p>

                    <h4 class="mt-4">4. Cookies</h4>
                    <p>We use cookies to understand and save your preferences for future visits and compile aggregate
                        data about site traffic and site interaction so that we can offer better site experiences and
                        tools in the future.</p>

                    <h4 class="mt-4">5. Third-Party Disclosure</h4>
                    <p>We do not sell, trade, or otherwise transfer to outside parties your Personally Identifiable
                        Information unless we provide users with advance notice.</p>
                </div>
            </div>
        </div>
    </section>

    <?php require_once VIEW_PATH . '/partials/public_footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= url('public/assets/js/main.js') ?>"></script>
</body>

</html>