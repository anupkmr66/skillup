<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Certificate - <?= e($result['first_name']) ?></title>
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700&family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Great+Vibes&family=Roboto:wght@300;400;500&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Playfair Display', serif;
            background: #e0e0e0;
        }

        .certificate-container {
            width: 210mm;
            /* A4 Portrait */
            height: 297mm;
            background: #fff;
            margin: 20px auto;
            position: relative;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            padding: 10mm;
            box-sizing: border-box;
            background-image:
                radial-gradient(circle at 50% 50%, #fffdf5 0%, #fff 100%);
        }

        /* ... existing styles ... */



        /* Ornamental Border using CSS */
        .ornamental-border {
            border: 2px solid #b8860b;
            padding: 5px;
            height: 100%;
            box-sizing: border-box;
            position: relative;
        }

        .ornamental-border::before {
            content: '';
            position: absolute;
            top: 5px;
            left: 5px;
            right: 5px;
            bottom: 5px;
            border: 2px solid #d4af37;
            pointer-events: none;
        }

        .corner-decoration {
            position: absolute;
            width: 100px;
            height: 100px;
            background-size: contain;
            background-repeat: no-repeat;
            pointer-events: none;
            z-index: 10;
        }

        .top-left {
            top: -15px;
            left: -15px;
            transform: rotate(0deg);
            background-image: url('https://i.ibb.co/vz1yWjR/corner-ornament.png');
        }

        /* Placeholder URL */
        .top-right {
            top: -15px;
            right: -15px;
            transform: rotate(90deg);
            background-image: url('https://i.ibb.co/vz1yWjR/corner-ornament.png');
        }

        .bottom-right {
            bottom: -15px;
            right: -15px;
            transform: rotate(180deg);
            background-image: url('https://i.ibb.co/vz1yWjR/corner-ornament.png');
        }

        .bottom-left {
            bottom: -15px;
            left: -15px;
            transform: rotate(270deg);
            background-image: url('https://i.ibb.co/vz1yWjR/corner-ornament.png');
        }

        /* Fallback for corners if external images fail/not allowed, use CSS patterns or SVG inline */
        .corner-svg {
            position: absolute;
            width: 80px;
            height: 80px;
            fill: #b8860b;
        }

        .c-tl {
            top: 0;
            left: 0;
            transform: scaleX(1);
        }

        .c-tr {
            top: 0;
            right: 0;
            transform: scaleX(-1);
        }

        .c-bl {
            bottom: 0;
            left: 0;
            transform: scaleY(-1);
        }

        .c-br {
            bottom: 0;
            right: 0;
            transform: scale(-1);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding: 0 40px;
        }

        .qr-code {
            width: 100px;
            height: 100px;
            border: 1px solid #ddd;
            padding: 5px;
            background: #fff;
        }

        .institute-logo {
            max-width: 100px;
            max-height: 100px;
            object-fit: contain;
        }

        .student-photo {
            width: 110px;
            height: 130px;
            border: 1px solid #aaa;
            object-fit: cover;
            background: #f8f9fa;
        }

        .cert-header-courses {
            text-align: center;
            flex-grow: 1;
        }

        .institute-title {
            font-family: 'Cinzel Decorative', cursive;
            font-size: 32px;
            color: #2c3e50;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
            text-shadow: 1px 1px 0px rgba(0, 0, 0, 0.1);
        }

        .institute-subtitle {
            font-size: 14px;
            color: #555;
            font-family: 'Roboto', sans-serif;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .certificate-title {
            font-family: 'Great Vibes', cursive;
            /* Or Old English style */
            font-size: 72px;
            color: #c0392b;
            /* Deep Red for Title */
            text-align: center;
            margin: 10px 0;
            text-shadow: 2px 2px 2px rgba(0, 0, 0, 0.1);
        }

        .cert-body {
            text-align: center;
            padding: 0 60px;
        }

        .cert-text {
            font-size: 18px;
            color: #444;
            font-style: italic;
            margin: 10px 0;
        }

        .student-name {
            font-size: 36px;
            color: #1a237e;
            /* Deep Blue */
            font-weight: bold;
            font-family: 'Cinzel Decorative', cursive;
            margin: 10px 0;
            border-bottom: 2px solid #b8860b;
            display: inline-block;
            padding: 0 30px;
        }

        .course-title {
            font-size: 26px;
            font-weight: bold;
            color: #2c3e50;
            margin: 10px 0;
        }

        .grade-info {
            font-family: 'Roboto', sans-serif;
            font-size: 16px;
            color: #555;
            margin-top: 20px;
            border: 1px solid #d4af37;
            display: inline-block;
            padding: 5px 20px;
            background: #fffdf5;
        }

        .footer {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
            padding: 0 60px;
        }

        .signature-box {
            text-align: center;
            width: 200px;
        }

        .signature-line {
            border-top: 1px solid #333;
            margin-bottom: 5px;
        }

        .reg-info {
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            font-family: 'Roboto', sans-serif;
            font-size: 10px;
            color: #777;
            width: 80%;
            text-align: center;
        }

        .watermark-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 300px;
            height: 300px;
            background: url('<?= !empty($result['logo']) ? asset("uploads/logos/" . $result['logo']) : "" ?>') no-repeat center;
            background-size: contain;
            opacity: 0.08;
            pointer-events: none;
        }

        @media print {
            @page {
                size: A4 portrait;
                margin: 0;
            }

            html,
            body {
                margin: 0;
                padding: 0;
                width: 210mm;
                height: 297mm;
                overflow: hidden;
                /* Force single page */
            }

            .certificate-container {
                margin: 0;
                width: 100%;
                height: 100%;
                box-shadow: none;
                border: none;
                page-break-after: avoid;
                /* Prevent extra page */
                page-break-inside: avoid;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                background: #fff;
            }

            .no-print {
                display: none;
            }
        }

        .btn-print {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #2c3e50;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            transition: background 0.3s;
            z-index: 1000;
        }
    </style>
</head>

<body>

    <button class="no-print btn-print" onclick="window.print()">
        <i class="fas fa-print me-2"></i> Print Certificate
    </button>

    <div class="certificate-container">

        <!-- Ornamental SVG Corners -->
        <svg class="corner-svg c-tl" viewBox="0 0 100 100">
            <path d="M0,0 L0,40 Q0,10 30,10 L90,10 L90,0 Z" fill="#b8860b" />
        </svg>
        <svg class="corner-svg c-tr" viewBox="0 0 100 100">
            <path d="M0,0 L0,40 Q0,10 30,10 L90,10 L90,0 Z" fill="#b8860b" />
        </svg>
        <svg class="corner-svg c-bl" viewBox="0 0 100 100">
            <path d="M0,0 L0,40 Q0,10 30,10 L90,10 L90,0 Z" fill="#b8860b" />
        </svg>
        <svg class="corner-svg c-br" viewBox="0 0 100 100">
            <path d="M0,0 L0,40 Q0,10 30,10 L90,10 L90,0 Z" fill="#b8860b" />
        </svg>

        <div class="ornamental-border">

            <div class="reg-info">
                Certificate No: <strong>CERT-<?= str_pad($result['id'], 6, '0', STR_PAD_LEFT) ?></strong> &nbsp; |
                &nbsp;
                ISO 9001:2015 Certified Institute
            </div>

            <div class="header">
                <!-- SkillUp Logo (Always Visible) -->
                <div class="brand-logo" style="position: absolute; left: 40px; top: 40px;">
                     <img src="<?= asset('assets/img/skillup_logo.png') ?>" alt="SkillUp" style="height: 60px;">
                </div>

                <div class="qr-code d-flex align-items-center justify-content-center" style="margin-left: auto;">
                    <!-- Placeholder QR -->
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=CERT-<?= $result['id'] ?>"
                        alt="QR" width="90">
                </div>

                <div class="cert-header-courses" style="margin-top: 40px;">
                    <?php if (!empty($result['logo'])): ?>
                        <img src="<?= asset('uploads/logos/' . $result['logo']) ?>" alt="Logo" class="institute-logo mb-2">
                    <?php endif; ?>
                    <div class="institute-title"><?= e($result['institute_name']) ?></div>
                    <div class="institute-subtitle">Sanctioned & Recognized Computer Training Center</div>
                    <div style="font-size: 12px; margin-top: 5px;"><?= e($result['city'] . ', ' . $result['state']) ?>
                    </div>
                </div>

                <div class="student-photo-container">
                    <?php if (!empty($result['photo'])): ?>
                        <img src="<?= asset('uploads/students/' . $result['photo']) ?>" alt="Student" class="student-photo">
                    <?php else: ?>
                        <div class="student-photo d-flex align-items-center justify-content-center text-muted">No Photo
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="certificate-title">Certificate</div>

            <div class="watermark-overlay"></div>

            <div class="cert-body">
                <div class="cert-text">This is to certify that</div>

                <div class="student-name"><?= e($result['first_name'] . ' ' . $result['last_name']) ?></div>
                <div class="cert-text" style="font-size: 14px;">(Student ID: <?= e($result['student_id']) ?>)</div>

                <div class="cert-text">has successfully completed the course of</div>

                <div class="course-title"><?= e($result['course_name']) ?></div>

                <div class="cert-text">
                    at our authorized study center in <br>
                    <strong><?= e($result['institute_name']) ?></strong>
                </div>

                <div class="cert-text">
                    and has secured a performance grade of
                    <strong style="color: #c0392b; font-size: 20px;">
                        <?= $result['grade'] ?? ($result['percentage'] >= 80 ? 'A+' : ($result['percentage'] >= 60 ? 'A' : 'B')) ?>
                    </strong>
                </div>

                <div class="grade-info">
                    Total Marks: <strong><?= $result['marks_obtained'] ?> / <?= $result['total_marks'] ?></strong>
                    &nbsp; | &nbsp;
                    Percentage:
                    <strong><?= number_format(($result['marks_obtained'] / $result['total_marks']) * 100, 2) ?>%</strong>
                </div>
            </div>

            <div class="footer">
                <div class="signature-box">
                    <div style="height: 40px;"></div> <!-- Sign space -->
                    <div class="signature-line"></div>
                    <strong>Date of Issue</strong><br>
                    <?= date('d M Y') ?>
                </div>
                <div class="signature-box">
                    <div style="height: 40px;"> <!-- Image for sign --> </div>
                    <div class="signature-line"></div>
                    <strong>Center Director</strong>
                </div>
            </div>

        </div>
    </div>

</body>

</html>