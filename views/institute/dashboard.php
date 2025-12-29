<!-- Institute Dashboard Content -->
<div class="row">
    <!-- Welcome Card -->
    <div class="col-12 mb-4">
        <div class="card bg-gradient text-white" style="background: linear-gradient(135deg, #667eea, #764ba2);">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-1 text-black">Institute Dashboard</h2>
                        <p class="mb-0 text-warning">
                            <i class="fas fa-school me-2"></i><?= e($institute['institute_name']) ?>
                        </p>
                        <p class="mb-0 text-info">
                            <i class="fas fa-building me-2"></i><?= e($institute['franchise_name']) ?>
                        </p>
                    </div>
                    <div class="text-end">
                        <i class="fas fa-building fa-4x text-warning"></i>
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
            <h3><?= $stats['total_students'] ?></h3>
            <p>Total Students</p>
        </div>
        <div class="stat-icon">
            <i class="fas fa-user-graduate text-primary"></i>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <h3><?= $stats['total_batches'] ?></h3>
            <p>Active Batches</p>
        </div>
        <div class="stat-icon">
            <i class="fas fa-users text-success"></i>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <h3><?= formatCurrency($stats['total_fees_collected']) ?></h3>
            <p>Fees Collected</p>
        </div>
        <div class="stat-icon">
            <i class="fas fa-rupee-sign text-success"></i>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <h3><?= formatCurrency($stats['pending_fees']) ?></h3>
            <p>Pending Fees</p>
        </div>
        <div class="stat-icon">
            <i class="fas fa-clock text-danger"></i>
        </div>
    </div>
</div>

<!-- Quick Actions and Info -->
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
                    <a href="<?= url('institute/students') ?>" class="btn btn-primary">
                        <i class="fas fa-user-plus me-2"></i>Add Student
                    </a>
                    <a href="<?= url('institute/fees') ?>" class="btn btn-success">
                        <i class="fas fa-money-bill-wave me-2"></i>Collect Fee
                    </a>
                    <a href="<?= url('institute/exams') ?>" class="btn btn-info text-white">
                        <i class="fas fa-file-alt me-2"></i>Manage Exams
                    </a>
                    <a href="<?= url('institute/batches') ?>" class="btn btn-warning text-dark">
                        <i class="fas fa-clock me-2"></i>Manage Batches
                    </a>
                    <a href="<?= url('institute/attendance') ?>" class="btn btn-secondary">
                        <i class="fas fa-calendar-check me-2"></i>Attendance
                    </a>
                    <a href="<?= url('institute/profile') ?>" class="btn btn-light border">
                        <i class="fas fa-user-cog me-2"></i>Profile
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-history me-2"></i>Recent Activity
                </h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <?php if (isset($activities) && !empty($activities)): ?>
                        <?php foreach ($activities as $log): ?>
                            <div class="list-group-item px-0">
                                <?php
                                $module = strtolower($log['module'] ?? '');
                                $iconClass = match ($module) {
                                    'students', 'student' => 'fas fa-user-graduate text-primary',
                                    'fees', 'payment', 'finance' => 'fas fa-money-bill-wave text-success',
                                    'exams', 'exam' => 'fas fa-file-alt text-info',
                                    'auth', 'authentication', 'login' => 'fas fa-key text-warning',
                                    'batches', 'batch' => 'fas fa-clock text-dark',
                                    default => 'fas fa-circle text-secondary'
                                };

                                $displayText = !empty($log['description']) ? $log['description'] : $log['action'];
                                ?>
                                <i class="<?= $iconClass ?> me-2"></i>
                                <?= e($displayText) ?>
                                <small class="text-muted float-end">
                                    <?= date('d M h:i A', strtotime($log['created_at'])) ?>
                                </small>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center py-3 text-muted">
                            <small>No recent activity</small>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card text-white shadow" style="background: linear-gradient(135deg, #00B4DB, #0083B0);">
            <div class="card-header border-bottom-0 pb-0">
                <h6 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>Institute Info
                </h6>
            </div>
            <div class="card-body">
                <p class="mb-2 small">
                    <strong>Contact Person:</strong><br>
                    <?= e($institute['contact_person']) ?>
                </p>
                <p class="mb-2 small">
                    <strong>Email:</strong><br>
                    <?= e($institute['email']) ?>
                </p>
                <p class="mb-2 small">
                    <strong>Phone:</strong><br>
                    <?= e($institute['phone']) ?>
                </p>
                <p class="mb-0 small">
                    <strong>Location:</strong><br>
                    <?= e($institute['city'] . ', ' . $institute['state']) ?>
                </p>
            </div>
        </div>
    </div>
</div>