<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-school me-2"></i>My Institutes
        </h5>
    </div>
    <div class="card-body">
        <?php if (empty($institutes)): ?>
            <div class="text-center py-5 text-muted">
                <i class="fas fa-building fa-4x mb-3 opacity-50"></i>
                <p>No institutes under your franchise yet</p>
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($institutes as $institute): ?>
                    <div class="col-md-6 mb-3">
                        <div class="card border h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="card-title">
                                            <i class="fas fa-school text-primary me-2"></i>
                                            <?= e($institute['institute_name']) ?>
                                        </h6>
                                        <p class="card-text small text-muted mb-2">
                                            <i class="fas fa-user me-1"></i><?= e($institute['contact_person']) ?><br>
                                            <i class="fas fa-phone me-1"></i><?= e($institute['phone']) ?><br>
                                            <i
                                                class="fas fa-map-marker-alt me-1"></i><?= e($institute['city'] . ', ' . $institute['state']) ?>
                                        </p>
                                    </div>
                                    <span
                                        class="badge badge-<?= $institute['status'] === 'active' ? 'success' : 'secondary' ?>">
                                        <?= ucfirst($institute['status']) ?>
                                    </span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between text-center">
                                    <div>
                                        <h6 class="mb-0">-</h6>
                                        <small class="text-muted">Students</small>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">-</h6>
                                        <small class="text-muted">Batches</small>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">-</h6>
                                        <small class="text-muted">Revenue</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>