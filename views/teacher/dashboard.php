<!-- Teacher Dashboard Content -->
<div class="row">
    <!-- Welcome Card -->
    <div class="col-12 mb-4">
        <div class="card bg-gradient text-white" style="background: linear-gradient(135deg, #667eea, #764ba2);">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-1">Welcome, Teacher!</h2>
                        <p class="mb-0 opacity-75">
                            <i class="fas fa-chalkboard-teacher me-2"></i>Manage your batches and materials
                        </p>
                    </div>
                    <div class="text-end">
                        <i class="fas fa-user-tie fa-4x opacity-50"></i>
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
            <h3><?= count($batches) ?></h3>
            <p>My Batches</p>
        </div>
        <div class="stat-icon">
            <i class="fas fa-users text-primary"></i>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <h3><?= array_sum(array_column($batches, 'student_count')) ?></h3>
            <p>Total Students</p>
        </div>
        <div class="stat-icon">
            <i class="fas fa-user-graduate text-success"></i>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <h3>-</h3>
            <p>Classes Today</p>
        </div>
        <div class="stat-icon">
            <i class="fas fa-calendar-day text-info"></i>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <h3>-</h3>
            <p>Materials Shared</p>
        </div>
        <div class="stat-icon">
            <i class="fas fa-book-open text-warning"></i>
        </div>
    </div>
</div>

<!-- My Batches -->
<div class="row">
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-users me-2"></i>My Active Batches
                </h5>
            </div>
            <div class="card-body">
                <?php if (empty($batches)): ?>
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-inbox fa-3x mb-3 opacity-50"></i>
                        <p>No batches assigned yet</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Batch Name</th>
                                    <th>Course</th>
                                    <th>Institute</th>
                                    <th>Students</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($batches as $batch): ?>
                                    <tr>
                                        <td><?= e($batch['batch_name']) ?></td>
                                        <td><?= e($batch['course_name']) ?></td>
                                        <td><?= e($batch['institute_name']) ?></td>
                                        <td>
                                            <span class="badge bg-primary"><?= $batch['student_count'] ?></span>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <button class="btn btn-info" title="View Students">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn btn-success" title="Take Attendance">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </div>
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

    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-tasks me-2"></i>Quick Actions
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="<?= url('teacher/batches') ?>" class="btn btn-outline-primary">
                        <i class="fas fa-users me-2"></i>View All Batches
                    </a>
                    <a href="<?= url('teacher/materials') ?>" class="btn btn-outline-success">
                        <i class="fas fa-upload me-2"></i>Upload Material
                    </a>
                    <button class="btn btn-outline-info">
                        <i class="fas fa-calendar-check me-2"></i>Mark Attendance
                    </button>
                </div>
            </div>
        </div>

        <!-- Today's Schedule -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-calendar-alt me-2"></i>Today's Schedule
                </h6>
            </div>
            <div class="card-body">
                <div class="text-center text-muted py-3">
                    <i class="fas fa-calendar-times fa-2x mb-2 opacity-50"></i>
                    <p class="small mb-0">No classes scheduled for today</p>
                </div>
            </div>
        </div>
    </div>
</div>