<!-- Statistics Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-info">
            <h3><?= $stats['total_franchises'] ?></h3>
            <p>Total Franchises</p>
        </div>
        <div class="stat-icon">
            <i class="fas fa-network-wired text-primary"></i>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <h3><?= $stats['total_institutes'] ?></h3>
            <p>Total Institutes</p>
        </div>
        <div class="stat-icon">
            <i class="fas fa-school text-success"></i>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <h3><?= $stats['total_students'] ?></h3>
            <p>Total Students</p>
        </div>
        <div class="stat-icon">
            <i class="fas fa-user-graduate text-info"></i>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <h3><?= $stats['total_courses'] ?></h3>
            <p>Total Courses</p>
        </div>
        <div class="stat-icon">
            <i class="fas fa-book text-warning"></i>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <h3><?= formatCurrency($stats['total_revenue']) ?></h3>
            <p>Total Revenue</p>
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

<div class="row">
    <!-- Recent Students -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-users me-2"></i> Recent Students
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Student ID</th>
                                <th>Name</th>
                                <th>Institute</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentStudents as $student): ?>
                                <tr>
                                    <td><?= e($student['student_id']) ?></td>
                                    <td><?= e($student['first_name'] . ' ' . $student['last_name']) ?></td>
                                    <td><?= e($student['institute_name']) ?></td>
                                    <td>
                                        <span
                                            class="badge badge-<?= $student['status'] === 'active' ? 'success' : 'danger' ?>">
                                            <?= ucfirst($student['status']) ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Payments -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-money-bill-wave me-2"></i> Recent Payments
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Receipt No</th>
                                <th>Student</th>
                                <th>Amount</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentPayments as $payment): ?>
                                <tr>
                                    <td><?= e($payment['receipt_number']) ?></td>
                                    <td><?= e($payment['first_name'] . ' ' . $payment['last_name']) ?></td>
                                    <td><?= formatCurrency($payment['amount']) ?></td>
                                    <td><?= formatDate($payment['payment_date']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Inquiries -->
<div class="row">
    <div class="col-12 mb-4">
        <div class="card border-warning border-top-3">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0 text-warning">
                    <i class="fas fa-question-circle me-2"></i> New Franchise Inquiries
                </h5>
            </div>
            <div class="card-body">
                <?php if (empty($recentInquiries)): ?>
                    <p class="text-muted mb-0">No new inquiries found.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>City/State</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentInquiries as $inquiry): ?>
                                    <tr>
                                        <td class="fw-bold"><?= e($inquiry['name']) ?></td>
                                        <td><?= e($inquiry['city']) ?>, <?= e($inquiry['state']) ?></td>
                                        <td><?= e($inquiry['phone']) ?></td>
                                        <td><?= e($inquiry['email']) ?></td>
                                        <td>
                                            <a href="mailto:<?= e($inquiry['email']) ?>" class="btn btn-sm btn-outline-primary"
                                                title="Reply">
                                                <i class="fas fa-envelope"></i>
                                            </a>
                                            <a href="tel:<?= e($inquiry['phone']) ?>" class="btn btn-sm btn-outline-success"
                                                title="Call">
                                                <i class="fas fa-phone"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-bolt me-2"></i> Quick Actions
        </h5>
    </div>
    <div class="card-body">
        <div class="d-flex gap-2 flex-wrap">
            <a href="<?= url('admin/franchises') ?>" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i> Add Franchise
            </a>
            <a href="<?= url('admin/institutes') ?>" class="btn btn-success">
                <i class="fas fa-plus me-2"></i> Add Institute
            </a>
            <a href="<?= url('admin/students') ?>" class="btn btn-info text-white">
                <i class="fas fa-plus me-2"></i> Add Student
            </a>
            <a href="<?= url('admin/reports') ?>" class="btn btn-warning text-white">
                <i class="fas fa-chart-line me-2"></i> View Reports
            </a>
        </div>
    </div>
</div>

<script>
    // Initialize DataTables
    $(document).ready(function () {
        $('.table').DataTable({
            pageLength: 5,
            lengthChange: false,
            searching: false,
            info: false
        });
    });
</script>