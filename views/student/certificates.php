<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-certificate me-2"></i>My Certificates
        </h5>
    </div>
    <div class="card-body">
        <?php if (empty($certificates)): ?>
            <div class="text-center py-5 text-muted">
                <i class="fas fa-award fa-4x mb-3 opacity-50"></i>
                <p>No certificates issued yet</p>
                <small>Certificates will be available upon course completion</small>
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($certificates as $certificate): ?>
                    <div class="col-md-6 mb-4">
                        <div class="card border-primary h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5 class="card-title text-primary">
                                            <i class="fas fa-award me-2"></i><?= e($certificate['course_name']) ?>
                                        </h5>
                                        <p class="card-text">
                                            <small class="text-muted">
                                                <i class="fas fa-calendar me-1"></i>
                                                Issued: <?= formatDate($certificate['issue_date']) ?>
                                            </small>
                                        </p>
                                    </div>
                                    <span
                                        class="badge badge-<?= $certificate['status'] === STATUS_ACTIVE ? 'success' : 'secondary' ?>">
                                        <?= $certificate['status'] === STATUS_ACTIVE ? 'Active' : 'Revoked' ?>
                                    </span>
                                </div>

                                <hr>

                                <div class="mb-3">
                                    <p class="mb-1">
                                        <strong>Certificate Number:</strong><br>
                                        <code class="text-primary"><?= e($certificate['certificate_number']) ?></code>
                                    </p>
                                </div>

                                <div class="d-grid gap-2">
                                    <a href="<?= url('student/certificate/download?id=' . $certificate['id']) ?>"
                                        class="btn btn-primary" target="_blank">
                                        <i class="fas fa-download me-2"></i>Download Certificate
                                    </a>
                                    <a href="<?= url('verify-certificate') ?>?cert=<?= e($certificate['certificate_number']) ?>"
                                        class="btn btn-outline-secondary" target="_blank">
                                        <i class="fas fa-check-circle me-2"></i>Verify Online
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>