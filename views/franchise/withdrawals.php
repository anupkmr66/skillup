<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-money-bill-wave me-2"></i>Withdrawal Requests
        </h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Request Date</th>
                        <th>Amount</th>
                        <th>Bank Details</th>
                        <th>Status</th>
                        <th>Processed Date</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($withdrawals)): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">No withdrawal requests yet</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($withdrawals as $withdrawal): ?>
                            <tr>
                                <td><?= formatDate($withdrawal['request_date']) ?></td>
                                <td><strong><?= formatCurrency($withdrawal['amount']) ?></strong></td>
                                <td><small><?= e($withdrawal['bank_details']) ?></small></td>
                                <td>
                                    <?php
                                    $statusClass = 'secondary';
                                    if ($withdrawal['status'] === 'approved')
                                        $statusClass = 'success';
                                    elseif ($withdrawal['status'] === 'rejected')
                                        $statusClass = 'danger';
                                    elseif ($withdrawal['status'] === 'pending')
                                        $statusClass = 'warning';
                                    ?>
                                    <span class="badge badge-<?= $statusClass ?>">
                                        <?= ucfirst($withdrawal['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <?= $withdrawal['processed_date'] ? formatDate($withdrawal['processed_date']) : '-' ?>
                                </td>
                                <td><?= e($withdrawal['remarks'] ?? '-') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>