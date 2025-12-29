<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt - <?= $payment['receipt_number'] ?></title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            padding: 40px;
        }

        .receipt-container {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #eee;
            padding: 40px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 20px;
        }

        .institute-name {
            font-size: 28px;
            font-weight: bold;
            color: #333;
            margin: 0;
        }

        .institute-details {
            font-size: 14px;
            color: #777;
            margin-top: 5px;
        }

        .receipt-title {
            font-size: 20px;
            font-weight: bold;
            margin-top: 20px;
            text-transform: uppercase;
            color: #555;
        }

        .receipt-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .info-group h5 {
            margin: 0 0 5px 0;
            color: #888;
            font-size: 12px;
            text-transform: uppercase;
        }

        .info-group p {
            margin: 0;
            font-size: 16px;
            font-weight: 500;
        }

        .table-container {
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            padding: 12px;
            background: #f9f9f9;
            color: #555;
            font-size: 14px;
            border-bottom: 1px solid #eee;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            font-size: 15px;
        }

        .total-row td {
            font-weight: bold;
            font-size: 18px;
            border-top: 2px solid #333;
            border-bottom: none;
        }

        .footer {
            text-align: center;
            margin-top: 60px;
            font-size: 12px;
            color: #aaa;
        }

        .status-stamp {
            position: absolute;
            top: 150px;
            right: 100px;
            border: 3px solid #4CAF50;
            color: #4CAF50;
            font-size: 24px;
            font-weight: bold;
            padding: 10px 20px;
            text-transform: uppercase;
            transform: rotate(-15deg);
            opacity: 0.8;
        }

        @media print {
            body {
                padding: 0;
            }

            .receipt-container {
                border: none;
                box-shadow: none;
                padding: 0;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="receipt-container">

        <div class="header">
            <?php if (!empty($payment['logo'])): ?>
                <img src="<?= uploadUrl($payment['logo']) ?>" style="height: 60px; margin-bottom: 10px;">
            <?php endif; ?>
            <h1 class="institute-name"><?= $payment['institute_name'] ?></h1>
            <div class="institute-details">
                <?= $payment['institute_address'] ?><br>
                Phone: <?= $payment['institute_phone'] ?> | Email: <?= $payment['institute_email'] ?>
            </div>
            <div class="receipt-title">Payment Receipt</div>
        </div>

        <div class="receipt-info">
            <div class="info-group">
                <h5>Receipt No</h5>
                <p>#<?= $payment['receipt_number'] ?></p>
            </div>
            <div class="info-group">
                <h5>Payment Date</h5>
                <p><?= date('d M, Y', strtotime($payment['payment_date'])) ?></p>
            </div>
            <div class="info-group">
                <h5>Payment Method</h5>
                <p><?= ucfirst($payment['payment_method']) ?>
                    <?= $payment['transaction_id'] ? '(' . $payment['transaction_id'] . ')' : '' ?></p>
            </div>
        </div>

        <div class="receipt-info">
            <div class="info-group">
                <h5>Student Name</h5>
                <p><?= $payment['first_name'] . ' ' . $payment['last_name'] ?></p>
                <small style="color: #888">ID: <?= $payment['student_id'] ?></small>
            </div>
            <div class="info-group">
                <h5>Course</h5>
                <p><?= $payment['course_name'] ?></p>
            </div>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Description</th>
                        <th style="text-align: right;">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Course Fee Installment</td>
                        <td style="text-align: right;">₹<?= number_format($payment['amount'], 2) ?></td>
                    </tr>
                    <tr class="total-row">
                        <td>Total Paid</td>
                        <td style="text-align: right;">₹<?= number_format($payment['amount'], 2) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div style="margin-top: 20px; border-top: 1px dashed #ccc; padding-top: 20px;">
            <div class="info-group">
                <h5>Summary</h5>
                <p style="font-size: 14px; color: #555;">
                    Total Fee: ₹<?= number_format($payment['total_fee'], 2) ?> |
                    Discount: ₹<?= number_format($payment['discount_amount'] ?? 0, 2) ?> |
                    Remaining Due: ₹<?= number_format($payment['due_amount'], 2) ?>
                </p>
            </div>
        </div>

        <div class="status-stamp">PAID</div>

        <div class="footer">
            <p>Thank you for your payment!</p>
            <p>This is a computer-generated receipt.</p>
        </div>

        <div class="no-print" style="text-align: center; margin-top: 40px;">
            <button onclick="window.print()"
                style="padding: 10px 20px; background: #333; color: #fff; border: none; cursor: pointer; border-radius: 4px;">Print
                Receipt</button>
        </div>

    </div>

</body>

</html>