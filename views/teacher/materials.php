<!-- Teacher Materials View -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-book-open me-2"></i>Study Materials
                </h5>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#uploadModal">
                    <i class="fas fa-upload me-2"></i>Upload Material
                </button>
            </div>
            <div class="card-body">
                <?php if (empty($materials)): ?>
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-cloud-upload-alt fa-4x mb-3 opacity-50"></i>
                        <p class="h5">No materials uploaded yet.</p>
                        <p>Share notes, assignments, and resources with your students.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Title</th>
                                    <th>Course / Batch</th>
                                    <th>Type</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($materials as $material): ?>
                                    <tr>
                                        <td>
                                            <div class="fw-bold"><?= e($material['title']) ?></div>
                                            <small class="text-muted text-truncate"
                                                style="max-width: 250px; display: inline-block;">
                                                <?= e($material['description']) ?>
                                            </small>
                                        </td>
                                        <td>
                                            <div class="fw-bold"><?= e($material['course_name']) ?></div>
                                            <?php if (!empty($material['batch_name'])): ?>
                                                <small class="text-info">
                                                    <i class="fas fa-users me-1"></i><?= e($material['batch_name']) ?>
                                                </small>
                                            <?php else: ?>
                                                <small class="text-secondary">All Batches</small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark border">
                                                <?= strtoupper($material['file_type']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?= formatDate($material['created_at']) ?>
                                        </td>
                                        <td>
                                            <a href="<?= uploadUrl('materials/' . $material['file_path']) ?>"
                                                class="btn btn-sm btn-outline-primary" download target="_blank">
                                                <i class="fas fa-download"></i>
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

<!-- Upload Material Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Study Material</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="uploadForm" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?= CSRF::getToken() ?>">

                    <div class="mb-3">
                        <label class="form-label">Batch <span class="text-danger">*</span></label>
                        <select class="form-select" id="batchSelect" name="batch_id" required>
                            <option value="">Select Batch</option>
                            <?php foreach ($batches as $batch): ?>
                                <option value="<?= $batch['id'] ?>" data-course-id="<?= $batch['course_id'] ?>">
                                    <?= e($batch['batch_name']) ?> (<?= e($batch['course_name']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <input type="hidden" name="course_id" id="courseIdField">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="title" required
                            placeholder="e.g. Chapter 1 Notes">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="2"
                            placeholder="Brief description..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">File <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="file" required
                            accept=".pdf,.doc,.docx,.ppt,.pptx,.mp4,.avi">
                        <div class="form-text">Allowed: PDF, DOC, PPT, Video (Max 10MB)</div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary" id="uploadBtn">
                            <i class="fas fa-cloud-upload-alt me-2"></i>Upload
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Handle Batch Selection to set Course ID
    document.getElementById('batchSelect').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const courseId = selectedOption.getAttribute('data-course-id');
        document.getElementById('courseIdField').value = courseId || '';
    });

    // Handle Form Submit
    document.getElementById('uploadForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const btn = document.getElementById('uploadBtn');
        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Uploading...';

        const formData = new FormData(this);

        fetch('<?= url('api/material/upload') ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-Token': '<?= CSRF::getToken() ?>'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Material uploaded successfully');
                    location.reload();
                } else {
                    alert(data.message || 'Upload failed');
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                }
            })
            .catch(err => {
                console.error(err);
                alert('An error occurred during upload');
                btn.disabled = false;
                btn.innerHTML = originalText;
            });
    });
</script>