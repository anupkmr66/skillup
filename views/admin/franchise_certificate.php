<?php
// views/admin/franchise_certificate.php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Franchise Certificate - <?= e($franchise['franchise_name']) ?></title>
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }

        body {
            font-family: 'Times New Roman', serif;
            margin: 0;
            padding: 0;
            background: #fdfdfd;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            print-color-adjust: exact;
            -webkit-print-color-adjust: exact;
        }

        .certificate-container {
            width: 297mm;
            height: 209mm;
            /* Slightly less than 210mm to prevent extra page */
            background: #fff;
            position: relative;
            padding: 10mm;
            /* Use mm for padding */
            box-sizing: border-box;
            border: 5px solid #1a2a6c;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            background-image: radial-gradient(circle at center, rgba(255, 255, 255, 0.95), rgba(255, 255, 255, 0.9)), url('<?= url('public/assets/images/pattern.png') ?>');
            background-size: cover;
            page-break-after: avoid;
            page-break-inside: avoid;
        }

        .border-inner {
            position: absolute;
            top: 20px;
            left: 20px;
            right: 20px;
            bottom: 20px;
            border: 2px solid #b21f1f;
            z-index: 1;
        }

        .cert-header {
            margin-bottom: 20px;
            z-index: 2;
        }

        .cert-title {
            font-size: 60px;
            font-weight: bold;
            color: #1a2a6c;
            text-transform: uppercase;
            letter-spacing: 5px;
            margin: 0;
        }

        .cert-subtitle {
            font-size: 24px;
            color: #555;
            margin-top: 10px;
        }

        .cert-body {
            margin: 30px 0;
            z-index: 2;
        }

        .cert-text {
            font-size: 20px;
            color: #333;
            margin: 10px 0;
        }

        .franchise-name {
            font-size: 42px;
            font-weight: bold;
            color: #b21f1f;
            margin: 20px 0;
            font-family: 'Great Vibes', cursive;
            /* Assuming included or fallback */
            border-bottom: 1px solid #ddd;
            display: inline-block;
            padding-bottom: 10px;
        }

        .cert-details {
            display: flex;
            justify-content: space-between;
            width: 80%;
            margin-top: 60px;
            z-index: 2;
        }

        .detail-item {
            text-align: center;
        }

        .signature-line {
            width: 200px;
            border-top: 2px solid #333;
            margin-top: 50px;
            font-weight: bold;
        }

        .qr-code {
            position: absolute;
            bottom: 60px;
            right: 60px;
            width: 100px;
            height: 100px;
            background: #eee;
            z-index: 2;
        }

        .badge-seal {
            position: absolute;
            bottom: 60px;
            left: 50%;
            transform: translateX(-50%);
            width: 120px;
            height: 120px;
            z-index: 2;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
                background: white;
            }

            .certificate-container {
                border: 5px solid #1a2a6c;
                width: 297mm;
                height: 209mm;
                page-break-after: avoid;
            }

            @page {
                size: A4 landscape;
                margin: 0;
                /* Important for full bleed */
            }
        }
    </style>
</head>

<body>
    <div class="certificate-container">
        <div class="border-inner"></div>

        <div class="cert-header">
            <h1 class="cert-title">Certificate</h1>
            <div class="cert-subtitle">OF FRANCHISE AUTHORIZATION</div>
        </div>

        <div class="cert-body">
            <p class="cert-text">This is to certify that</p>
            <div class="franchise-name"><?= e($franchise['franchise_name']) ?></div>
            <p class="cert-text">Run by <strong><?= e($franchise['owner_name']) ?></strong></p>
            <p class="cert-text" style="width: 700px; line-height: 1.6;">
                Has been officially authorized as a registered franchise partner of<br>
                <strong>SkillUp Computer Center</strong>.<br>
                This center is authorized to conduct training programs and issue certificates in accordance with the
                institute's guidelines.
            </p>
        </div>

        <div class="cert-details">
            <div class="detail-item">
                <p><strong>Certificate No:</strong> <?= e($certificate['certificate_number']) ?></p>
                <p><strong>Issue Date:</strong> <?= date('d M Y', strtotime($certificate['issue_date'])) ?></p>
            </div>

            <img src="<?= url('public/assets/images/certificate_seal.png') ?>" alt="Seal" class="badge-seal"
                onerror="this.style.display='none'">

            <div class="detail-item">
                <div class="signature-line">Authorized Signatory</div>
                <p>Director, SkillUp CIMS</p>
            </div>
        </div>

        <div class="qr-code">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=<?= url('verify-certificate?cert_no=' . $certificate['certificate_number']) ?>"
                alt="QR Code">
        </div>
    </div>
    <script>
        window.print();
    </script>
</body>

</html>