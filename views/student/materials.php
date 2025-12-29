<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-book-open me-2"></i>Study Materials
        </h5>
    </div>
    <div class="card-body">
        <?php if (empty($materials)): ?>
            <div class="text-center py-5 text-muted">
                <i class="fas fa-folder-open fa-4x mb-3 opacity-50"></i>
                <p>No study materials available yet</p>
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($materials as $material): ?>
                    <div class="col-md-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-start">
                                    <div class="me-3">
                                        <?php
                                        $iconClass = 'file';
                                        if ($material['file_type'] === 'pdf')
                                            $iconClass = 'file-pdf text-danger';
                                        elseif (in_array($material['file_type'], ['doc', 'docx']))
                                            $iconClass = 'file-word text-primary';
                                        elseif (in_array($material['file_type'], ['ppt', 'pptx']))
                                            $iconClass = 'file-powerpoint text-warning';
                                        elseif (in_array($material['file_type'], ['mp4', 'avi']))
                                            $iconClass = 'file-video text-info';
                                        ?>
                                        <i class="fas fa-<?= $iconClass ?> fa-3x"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="card-title mb-1"><?= e($material['title']) ?></h6>
                                        <p class="card-text small text-muted mb-2">
                                            <?= e($material['description'] ?? 'No description') ?>
                                        </p>
                                        <p class="card-text">
                                            <small class="text-muted">
                                                <i class="fas fa-book me-1"></i><?= e($material['course_name']) ?><br>
                                                <i class="fas fa-calendar me-1"></i><?= formatDate($material['created_at']) ?>
                                            </small>
                                        </p>
                                        <a href="<?= uploadUrl('materials/' . $material['file_path']) ?>"
                                            class="btn btn-sm btn-primary" target="_blank" download>
                                            <i class="fas fa-download me-1"></i>Download
                                        </a>
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