<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-money-bill-wave me-2"></i>My Fee Details
        </h5>
    </div>
    <div class="card-body">
        <!-- Fee Summary -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <h6 class="text-muted mb-2">Total Fees</h6>
                        <h3 class="mb-0 text-primary"><?= formatCurrency(array_sum(array_column($fees, 'total_fee'))) ?>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <h6 class="text-muted mb-2">Paid Amount</h6>
                        <h3 class="mb-0 text-success">
                            <?= formatCurrency(array_sum(array_column($fees, 'paid_amount'))) ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <h6 class="text-muted mb-2">Due Amount</h6>
                        <h3 class="mb-0 text-danger"><?= formatCurrency(array_sum(array_column($fees, 'due_amount'))) ?>
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fee Details Table -->
        <h6 class="mb-3">Course-wise Fee Details</h6>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Course</th>
                        <th>Total Fee</th>
                        <th>Paid</th>
                        <th>Due</th>
                        <th>Due Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($fees as $fee): ?>
                        <tr>
                            <td><?= e($fee['course_name']) ?></td>
                            <td><?= formatCurrency($fee['total_fee']) ?></td>
                            <td class="text-success"><?= formatCurrency($fee['paid_amount']) ?></td>
                            <td class="text-danger"><?= formatCurrency($fee['due_amount']) ?></td>
                            <td><?= formatDate($fee['due_date']) ?></td>
                            <td>
                                <?php
                                $badgeClass = 'secondary';
                                if ($fee['status'] === 'paid')
                                    $badgeClass = 'success';
                                elseif ($fee['status'] === 'partial')
                                    $badgeClass = 'warning';
                                elseif ($fee['status'] === 'unpaid')
                                    $badgeClass = 'danger';
                                ?>
                                <span class="badge badge-<?= $badgeClass ?>">
                                    <?= ucfirst($fee['status']) ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Payment History -->
        <h6 class="mb-3 mt-4">Payment History</h6>
        <div class="table-responsive">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Receipt No.</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($payments)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted">No payments made yet</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($payments as $payment): ?>
                            <tr>
                                <td><strong><?= e($payment['receipt_number']) ?></strong></td>
                                <td><?= formatDate($payment['payment_date']) ?></td>
                                <td class="text-success"><?= formatCurrency($payment['amount']) ?></td>
                                <td><?= ucfirst($payment['payment_method']) ?></td>
                                <td><?= e($payment['remarks'] ?? '-') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>