<!-- Franchise Dashboard Content -->
<div class="row">
    <!-- Welcome Card -->
    <div class="col-12 mb-4">
        <div class="card bg-gradient text-white" style="background: linear-gradient(135deg, #667eea, #764ba2);">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-1">Franchise Dashboard</h2>
                        <p class="mb-0 opacity-75">
                            <i class="fas fa-building me-2"></i><?= e($franchise['franchise_name']) ?>
                        </p>
                        <p class="mb-0 opacity-75">
                            <i class="fas fa-code me-2"></i>Code: <?= e($franchise['franchise_code']) ?>
                        </p>
                    </div>
                    <div class="text-end">
                        <i class="fas fa-network-wired fa-4x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="stats-grid mb-4">
    <div class="stat-card">
        <div class="stat-info">
            <h3><?= $stats['total_institutes'] ?></h3>
            <p>Total Institutes</p>
        </div>
        <div class="stat-icon">
            <i class="fas fa-school text-primary"></i>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <h3><?= $stats['total_students'] ?></h3>
            <p>Total Students</p>
        </div>
        <div class="stat-icon">
            <i class="fas fa-user-graduate text-success"></i>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <h3><?= formatCurrency($stats['wallet_balance']) ?></h3>
            <p>Wallet Balance</p>
        </div>
        <div class="stat-icon">
            <i class="fas fa-wallet text-warning"></i>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <h3><?= formatCurrency($stats['total_earned']) ?></h3>
            <p>Total Earned</p>
        </div>
        <div class="stat-icon">
            <i class="fas fa-chart-line text-info"></i>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-bolt me-2"></i>Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex gap-2 flex-wrap">
                    <a href="<?= url('franchise/institutes') ?>" class="btn btn-primary">
                        <i class="fas fa-school me-2"></i>Manage Institutes
                    </a>
                    <a href="<?= url('franchise/wallet') ?>" class="btn btn-success">
                        <i class="fas fa-wallet me-2"></i>View Wallet
                    </a>
                    <a href="<?= url('franchise/withdrawals') ?>" class="btn btn-warning text-white">
                        <i class="fas fa-money-bill-wave me-2"></i>Withdrawals
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>Franchise Info
                </h6>
            </div>
            <div class="card-body">
                <p class="mb-2 small">
                    <strong>Contact Person:</strong><br>
                    <?= e($franchise['contact_person']) ?>
                </p>
                <p class="mb-2 small">
                    <strong>Email:</strong><br>
                    <?= e($franchise['email']) ?>
                </p>
                <p class="mb-0 small">
                    <strong>Phone:</strong><br>
                    <?= e($franchise['phone']) ?>
                </p>
            </div>
        </div>
    </div>
</div>