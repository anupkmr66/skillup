<!-- Teachers Management View -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chalkboard-teacher me-2"></i>Teachers
                </h5>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addTeacherModal">
                    <i class="fas fa-plus me-2"></i>Add Teacher
                </button>
            </div>
            <div class="card-body">
                <?php if (empty($teachers)): ?>
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-chalkboard-teacher fa-4x mb-3 opacity-50"></i>
                        <p class="h5">No teachers added yet.</p>
                        <p>Add teachers to assign them to batches.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Teacher</th>
                                    <th>Contact</th>
                                    <th>Qualification</th>
                                    <th>Active Batches</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($teachers as $teacher): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div
                                                    class="avatar-sm me-2 bg-light rounded-circle d-flex align-items-center justify-content-center text-primary fw-bold">
                                                    <?= strtoupper(substr($teacher['first_name'], 0, 1)) ?>
                                                </div>
                                                <div>
                                                    <div class="fw-bold">
                                                        <?= e($teacher['first_name'] . ' ' . $teacher['last_name']) ?></div>
                                                    <small class="text-muted">Username: <?= e($teacher['username']) ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="small">
                                                <i class="fas fa-envelope me-1 text-muted"></i> <?= e($teacher['email']) ?><br>
                                                <i class="fas fa-phone me-1 text-muted"></i> <?= e($teacher['phone']) ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="small">
                                                <?= e($teacher['qualification']) ?><br>
                                                <span class="text-muted"><?= e($teacher['specialization']) ?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info rounded-pill">
                                                <?= $teacher['active_batches'] ?> Batches
                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="badge bg-<?= $teacher['status'] === 'active' ? 'success' : 'secondary' ?>">
                                                <?= ucfirst($teacher['status']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <button type="button" class="btn btn-outline-primary"
                                                    onclick='editTeacher(<?= json_encode($teacher) ?>)' title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-outline-danger"
                                                    onclick="deleteTeacher(<?= $teacher['id'] ?>)" title="Delete">
                                                    <i class="fas fa-trash"></i>
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
</div>

<!-- Add Teacher Modal -->
<div class="modal fade" id="addTeacherModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Teacher</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addTeacherForm">
                    <input type="hidden" name="institute_id" value="<?= $institute['id'] ?>">

                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">First Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="first_name" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Last Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="last_name" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" required>
                        <div class="form-text">Will be used for login. Password will be 'teacher@123'</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="phone" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Qualification</label>
                        <input type="text" class="form-control" name="qualification"
                            placeholder="e.g. MSc Computer Science">
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">Specialization</label>
                            <input type="text" class="form-control" name="specialization"
                                placeholder="e.g. Java, Python">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Experience</label>
                            <input type="text" class="form-control" name="experience" placeholder="e.g. 5 Years">
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Create Teacher</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Teacher Modal -->
<div class="modal fade" id="editTeacherModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Teacher</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editTeacherForm">
                    <input type="hidden" name="teacher_id" id="edit_teacher_id">

                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">First Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="first_name" id="edit_first_name" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Last Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="last_name" id="edit_last_name" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="phone" id="edit_phone" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Qualification</label>
                        <input type="text" class="form-control" name="qualification" id="edit_qualification">
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">Specialization</label>
                            <input type="text" class="form-control" name="specialization" id="edit_specialization">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Experience</label>
                            <input type="text" class="form-control" name="experience" id="edit_experience">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" id="edit_status">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Update Details</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('addTeacherForm').addEventListener('submit', function (e) {
        e.preventDefault();
        submitForm(this, '<?= url('api/teacher/create') ?>');
    });

    document.getElementById('editTeacherForm').addEventListener('submit', function (e) {
        e.preventDefault();
        submitForm(this, '<?= url('api/teacher/update') ?>');
    });

    function submitForm(form, url) {
        const formData = new FormData(form);

        // Add button loader
        const btn = form.querySelector('button[type="submit"]');
        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';

        fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-Token': '<?= CSRF::getToken() ?>'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.credentials) {
                        alert(`Teacher created!\nUsername: ${data.credentials.username}\nPassword: ${data.credentials.password}`);
                    } else {
                        alert(data.message);
                    }
                    location.reload();
                } else {
                    alert(data.message);
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                }
            })
            .catch(err => {
                console.error(err);
                alert('An error occurred');
                btn.disabled = false;
                btn.innerHTML = originalText;
            });
    }

    function editTeacher(teacher) {
        document.getElementById('edit_teacher_id').value = teacher.id;
        document.getElementById('edit_first_name').value = teacher.first_name;
        document.getElementById('edit_last_name').value = teacher.last_name;
        document.getElementById('edit_phone').value = teacher.phone;
        document.getElementById('edit_qualification').value = teacher.qualification;
        document.getElementById('edit_experience').value = teacher.experience;
        document.getElementById('edit_specialization').value = teacher.specialization;
        document.getElementById('edit_status').value = teacher.status;

        new bootstrap.Modal(document.getElementById('editTeacherModal')).show();
    }

    function deleteTeacher(id) {
        if (!confirm('Are you sure? This will deactivate the teacher account.')) return;

        const formData = new FormData();
        formData.append('id', id);

        fetch('<?= url('api/teacher/delete') ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-Token': '<?= CSRF::getToken() ?>'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message);
                }
            });
    }
</script>