<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fee Statement - <?= $fee['student_id'] ?></title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            padding: 40px;
            color: #333;
        }

        .stmt-container {
            max-width: 900px;
            margin: 0 auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .institute-info h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }

        .institute-info p {
            margin: 5px 0 0;
            color: #666;
            font-size: 14px;
        }

        .stmt-title {
            text-align: right;
        }

        .stmt-title h2 {
            margin: 0;
            font-size: 28px;
            color: #555;
            text-transform: uppercase;
        }

        .stmt-title p {
            margin: 5px 0 0;
            color: #888;
        }

        .student-box {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
        }

        .student-info h3 {
            margin: 0 0 10px;
            font-size: 18px;
        }

        .student-info p {
            margin: 3px 0;
            font-size: 14px;
            color: #555;
        }

        .financials {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }

        .fin-card {
            flex: 1;
            background: #fff;
            border: 1px solid #eee;
            padding: 15px;
            text-align: center;
            border-radius: 6px;
        }

        .fin-card h4 {
            margin: 0 0 5px;
            color: #888;
            font-size: 12px;
            text-transform: uppercase;
        }

        .fin-card span {
            font-size: 22px;
            font-weight: bold;
            color: #333;
        }

        .fin-card.due {
            border-color: #ffebee;
            background: #fffafa;
        }

        .fin-card.due span {
            color: #d32f2f;
        }

        .fin-card.paid {
            border-color: #e8f5e9;
            background: #f1f8e9;
        }

        .fin-card.paid span {
            color: #388e3c;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        th {
            text-align: left;
            padding: 12px;
            background: #333;
            color: white;
            border-bottom: 1px solid #ddd;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }

        tr:nth-child(even) {
            background-color: #fcfcfc;
        }

        .no-dues-stamp {
            text-align: center;
            margin-top: 40px;
            padding: 20px;
            border: 2px dashed #4CAF50;
            color: #4CAF50;
            font-weight: bold;
            font-size: 20px;
            display: inline-block;
        }

        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            text-align: center;
            font-size: 12px;
            color: #999;
        }

        @media print {
            .no-print {
                display: none;
            }

            body {
                padding: 20px;
            }

            .stmt-container {
                width: 100%;
                max-width: none;
            }
        }
    </style>
</head>

<body>

    <div class="stmt-container">

        <div class="header">
            <div class="institute-info">
                <h1><?= $fee['institute_name'] ?></h1>
                <p><?= $fee['institute_address'] ?></p>
                <p>Phone: <?= $fee['institute_phone'] ?> | Email: <?= $fee['institute_email'] ?></p>
            </div>
            <div class="stmt-title">
                <h2>Fee Statement</h2>
                <p>Date: <?= date('d M, Y') ?></p>
            </div>
        </div>

        <div class="student-box">
            <div class="student-info">
                <h3>Student Details</h3>
                <p><strong>Name:</strong> <?= $fee['first_name'] . ' ' . $fee['last_name'] ?></p>
                <p><strong>ID:</strong> <?= $fee['student_id'] ?></p>
                <p><strong>Course:</strong> <?= $fee['course_name'] ?></p>
            </div>
            <div class="stmt-meta" style="text-align: right;">
                <p><strong>Statement Period:</strong> All Time</p>
                <p><strong>Status:</strong> <span
                        style="text-transform: uppercase; font-weight: bold; color: <?= $fee['status'] == 'paid' ? 'green' : 'orange' ?>"><?= $fee['status'] ?></span>
                </p>
            </div>
        </div>

        <div class="financials">
            <div class="fin-card">
                <h4>Total Fee</h4>
                <span>₹<?= number_format($fee['total_fee'], 2) ?></span>
            </div>
            <div class="fin-card">
                <h4>Discount</h4>
                <span>₹<?= number_format($fee['discount_amount'] ?? 0, 2) ?></span>
            </div>
            <div class="fin-card paid">
                <h4>Total Paid</h4>
                <span>₹<?= number_format($fee['paid_amount'], 2) ?></span>
            </div>
            <div class="fin-card due">
                <h4>Balance Due</h4>
                <span>₹<?= number_format($fee['due_amount'], 2) ?></span>
            </div>
        </div>

        <h3>Transaction History</h3>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Receipt No</th>
                    <th>Method</th>
                    <th>Transaction ID</th>
                    <th style="text-align: right;">Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($payments)): ?>
                    <?php foreach ($payments as $p): ?>
                        <tr>
                            <td><?= date('d-m-Y', strtotime($p['payment_date'])) ?></td>
                            <td><?= $p['receipt_number'] ?></td>
                            <td><?= ucfirst($p['payment_method']) ?></td>
                            <td><?= $p['transaction_id'] ? $p['transaction_id'] : '-' ?></td>
                            <td style="text-align: right;">₹<?= number_format($p['amount'], 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center; color: #999;">No payments recorded.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <?php if ($fee['due_amount'] <= 0): ?>
            <div style="text-align: center;">
                <div class="no-dues-stamp">
                    ✅ NO DUES PENDING
                </div>
            </div>
        <?php endif; ?>

        <div class="footer">
            <p>Generated by SkillUp CIMS</p>
        </div>

        <div class="no-print" style="margin-top: 30px; text-align: center;">
            <button onclick="window.print()"
                style="padding: 12px 24px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">
                <i class="fas fa-print"></i> Print Statement
            </button>
        </div>

    </div>

</body>

</html>