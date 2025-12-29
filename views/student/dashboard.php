<!-- Student Dashboard Content -->
<div class="row">
    <!-- Welcome Card -->
    <div class="col-12 mb-4">
        <div class="card bg-gradient text-white" style="background: linear-gradient(135deg, #667eea, #764ba2);">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-1">Welcome, <?= e($student['first_name']) ?>!</h2>
                        <p class="mb-0 opacity-75">
                            <i class="fas fa-id-card me-2"></i>Student ID: <?= e($student['student_id']) ?>
                        </p>
                    </div>
                    <div class="text-end">
                        <i class="fas fa-user-graduate fa-4x opacity-50"></i>
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
            <h3><?= count($courses) ?></h3>
            <p>Enrolled Courses</p>
        </div>
        <div class="stat-icon">
            <i class="fas fa-book text-primary"></i>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <h3><?= formatCurrency($feeStatus['total_fee'] ?? 0) ?></h3>
            <p>Total Fees</p>
        </div>
        <div class="stat-icon">
            <i class="fas fa-rupee-sign text-success"></i>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <h3><?= formatCurrency($feeStatus['paid_amount'] ?? 0) ?></h3>
            <p>Paid Amount</p>
        </div>
        <div class="stat-icon">
            <i class="fas fa-check-circle text-success"></i>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <h3><?= formatCurrency($feeStatus['due_amount'] ?? 0) ?></h3>
            <p>Due Amount</p>
        </div>
        <div class="stat-icon">
            <i class="fas fa-clock text-danger"></i>
        </div>
    </div>
</div>

<div class="row">
    <!-- Enrolled Courses -->
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-graduation-cap me-2"></i>My Courses
                </h5>
            </div>
            <div class="card-body">
                <?php if (empty($courses)): ?>
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-inbox fa-3x mb-3 opacity-50"></i>
                        <p>No courses enrolled yet</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Course Name</th>
                                    <th>Batch</th>
                                    <th>Duration</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($courses as $course): ?>
                                    <tr>
                                        <td><?= e($course['course_name']) ?></td>
                                        <td><?= e($course['batch_name'] ?? 'Not assigned') ?></td>
                                        <td><?= e($course['duration']) ?> months</td>
                                        <td>
                                            <span
                                                class="badge badge-<?= $course['status'] === 'ongoing' ? 'success' : 'info' ?>">
                                                <?= ucfirst($course['status']) ?>
                                            </span>
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

    <!-- Quick Links -->
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-link me-2"></i>Quick Access
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="<?= url('student/profile') ?>" class="btn btn-outline-primary">
                        <i class="fas fa-user me-2"></i>My Profile
                    </a>
                    <a href="<?= url('student/fees') ?>" class="btn btn-outline-success">
                        <i class="fas fa-money-bill me-2"></i>Fee Details
                    </a>
                    <a href="<?= url('student/results') ?>" class="btn btn-outline-info">
                        <i class="fas fa-chart-bar me-2"></i>My Results
                    </a>
                    <a href="<?= url('student/certificates') ?>" class="btn btn-outline-warning">
                        <i class="fas fa-certificate me-2"></i>Certificates
                    </a>
                    <a href="<?= url('student/materials') ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-book-open me-2"></i>Study Materials
                    </a>
                </div>
            </div>
        </div>

        <!-- Profile Card -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>Profile Info
                </h6>
            </div>
            <div class="card-body">
                <p class="mb-2 small">
                    <strong>Institute:</strong><br>
                    <?= e($student['institute_name']) ?>
                </p>
                <p class="mb-2 small">
                    <strong>Franchise:</strong><br>
                    <?= e($student['franchise_name']) ?>
                </p>
                <p class="mb-0 small">
                    <strong>Enrollment Date:</strong><br>
                    <?= formatDate($student['enrollment_date']) ?>
                </p>
            </div>
        </div>
    </div>
</div>