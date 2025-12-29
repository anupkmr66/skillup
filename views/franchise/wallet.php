<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-wallet me-2"></i>Franchise Wallet
        </h5>
    </div>
    <div class="card-body">
        <!-- Wallet Balance -->
        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <h6 class="opacity-75 mb-2">Available Balance</h6>
                        <h2 class="mb-0"><?= formatCurrency($wallet['balance'] ?? 0) ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <h6 class="opacity-75 mb-2">Total Earned</h6>
                        <h2 class="mb-0"><?= formatCurrency($wallet['total_earned'] ?? 0) ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#withdrawModal">
                <i class="fas fa-money-bill-wave me-2"></i>Request Withdrawal
            </button>
        </div>

        <!-- Transaction History -->
        <h6 class="mb-3">Transaction History</h6>
        <div class="table-responsive">
            <table class="table" id="transactionsTable">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Balance</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($transactions)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted">No transactions yet</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($transactions as $txn): ?>
                            <tr>
                                <td><?= formatDate($txn['created_at']) ?></td>
                                <td>
                                    <?php
                                    $badgeClass = $txn['type'] === 'credit' ? 'success' : 'danger';
                                    $icon = $txn['type'] === 'credit' ? 'plus' : 'minus';
                                    ?>
                                    <span class="badge badge-<?= $badgeClass ?>">
                                        <i class="fas fa-<?= $icon ?> me-1"></i><?= ucfirst($txn['type']) ?>
                                    </span>
                                </td>
                                <td><?= e($txn['description']) ?></td>
                                <td class="text-<?= $txn['type'] === 'credit' ? 'success' : 'danger' ?>">
                                    <?= $txn['type'] === 'credit' ? '+' : '-' ?>        <?= formatCurrency($txn['amount']) ?>
                                </td>
                                <td><?= formatCurrency($txn['balance_after']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Withdrawal Modal -->
<div class="modal fade" id="withdrawModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-money-bill-wave me-2"></i>Request Withdrawal
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <?= CSRF::field() ?>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Available Balance: <strong><?= formatCurrency($wallet['balance'] ?? 0) ?></strong>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Withdrawal Amount <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="amount" required min="500"
                            max="<?= $wallet['balance'] ?? 0 ?>">
                        <small class="text-muted">Minimum withdrawal: ₹500</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Bank Account Details</label>
                        <textarea class="form-control" name="bank_details" rows="3"
                            placeholder="Account Number, IFSC Code, Bank Name" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Remarks</label>
                        <input type="text" class="form-control" name="remarks">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check me-2"></i>Submit Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#transactionsTable').DataTable({
            pageLength: 10,
            order: [[0, 'desc']]
        });
    });
</script>