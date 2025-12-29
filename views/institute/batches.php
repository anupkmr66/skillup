<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h4 class="mb-0"><i class="fas fa-clock text-primary me-2"></i>Batch Management</h4>
        </div>
        <div class="col-md-6 text-md-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBatchModal">
                <i class="fas fa-plus me-2"></i>Create New Batch
            </button>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="batchesTable">
                    <thead class="bg-light">
                        <tr>
                            <th>Batch Name</th>
                            <th>Course</th>
                            <th>Teacher</th>
                            <th>Timing</th>
                            <th>Dates</th>
                            <th>Students</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($batches) && !empty($batches)): ?>
                            <?php foreach ($batches as $batch): ?>
                                <tr>
                                    <td>
                                        <div class="fw-bold"><?= e($batch['batch_name']) ?></div>
                                    </td>
                                    <td><?= e($batch['course_name']) ?></td>
                                    <td>
                                        <?php if (!empty($batch['teacher_id'])): ?>
                                            <?php
                                            $teacherName = 'Unknown';
                                            foreach ($teachers as $t) {
                                                if ($t['user_id'] == $batch['teacher_id']) {
                                                    $teacherName = $t['first_name'] . ' ' . $t['last_name'];
                                                    break;
                                                }
                                            }
                                            echo e($teacherName);
                                            ?>
                                        <?php else: ?>
                                            <span class="text-muted fst-italic">Unassigned</span>
                                        <?php endif; ?>
                                    </td>

                                    <td><i class="far fa-clock me-1 text-muted"></i> <?= e($batch['timing']) ?></td>
                                    <td>
                                        <div class="small">
                                            <div>Start: <?= date('d M Y', strtotime($batch['start_date'])) ?></div>
                                            <?php if ($batch['end_date']): ?>
                                                <div class="text-muted">End: <?= date('d M Y', strtotime($batch['end_date'])) ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info text-dark">
                                            <?= $batch['student_count'] ?> / <?= $batch['max_students'] ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php
                                        $statusClass = match ($batch['status']) {
                                            'active' => 'success',
                                            'completed' => 'primary',
                                            'inactive' => 'secondary',
                                            default => 'secondary'
                                        };
                                        ?>
                                        <span class="badge bg-<?= $statusClass ?>"><?= ucfirst($batch['status']) ?></span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary btn-edit-batch"
                                            data-id="<?= $batch['id'] ?>" data-name="<?= e($batch['batch_name']) ?>"
                                            data-course="<?= $batch['course_id'] ?>" data-start="<?= $batch['start_date'] ?>"
                                            data-end="<?= $batch['end_date'] ?>" data-timing="<?= e($batch['timing']) ?>"
                                            data-teacher="<?= $batch['teacher_id'] ?>" data-max="<?= $batch['max_students'] ?>"
                                            data-status="<?= $batch['status'] ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger btn-delete-batch"
                                            data-id="<?= $batch['id'] ?>">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Batch Modal -->
<div class="modal fade" id="addBatchModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New Batch</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addBatchForm">
                <div class="modal-body">
                    <?= CSRF::field() ?>
                    <div class="mb-3">
                        <label class="form-label">Batch Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="batch_name" placeholder="e.g. Morning Web Dev"
                            required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Course <span class="text-danger">*</span></label>
                        <select class="form-select" name="course_id" required>
                            <option value="">Select Course</option>
                            <?php foreach ($courses as $course): ?>
                                <option value="<?= $course['id'] ?>"><?= e($course['course_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Assign Teacher</label>
                        <select class="form-select" name="teacher_id">
                            <option value="">Select Teacher (Optional)</option>
                            <?php foreach ($teachers as $teacher): ?>
                                <option value="<?= $teacher['user_id'] ?>">
                                    <?= e($teacher['first_name'] . ' ' . $teacher['last_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Start Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="start_date" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">End Date</label>
                            <input type="date" class="form-control" name="end_date">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Timing <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="timing" placeholder="e.g. 09:00 AM - 11:00 AM"
                                required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Max Students</label>
                            <input type="number" class="form-control" name="max_students" value="30" min="1">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Batch</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Batch Modal -->
<div class="modal fade" id="editBatchModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Batch</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editBatchForm">
                <div class="modal-body">
                    <?= CSRF::field() ?>
                    <input type="hidden" name="batch_id" id="edit_batch_id">
                    <div class="mb-3">
                        <label class="form-label">Batch Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="batch_name" id="edit_batch_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Course <span class="text-danger">*</span></label>
                        <select class="form-select" name="course_id" id="edit_course_id" required>
                            <option value="">Select Course</option>
                            <?php foreach ($courses as $course): ?>
                                <option value="<?= $course['id'] ?>"><?= e($course['course_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Assign Teacher</label>
                        <select class="form-select" name="teacher_id" id="edit_teacher_id">
                            <option value="">Select Teacher (Optional)</option>
                            <?php foreach ($teachers as $teacher): ?>
                                <option value="<?= $teacher['user_id'] ?>"><?= e($teacher['first_name'] . ' ' . $teacher['last_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Start Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="start_date" id="edit_start_date" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">End Date</label>
                            <input type="date" class="form-control" name="end_date" id="edit_end_date">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Timing <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="timing" id="edit_timing" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Max Students</label>
                            <input type="number" class="form-control" name="max_students" id="edit_max_students"
                                min="1">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" id="edit_status">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Batch</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    window.addEventListener('DOMContentLoaded', function () {
        if (typeof jQuery === 'undefined') {
            console.error('jQuery not loaded!');
            return;
        }

        // Initialize DataTable
        if (typeof $.fn.DataTable !== 'undefined') {
            $('#batchesTable').DataTable({
                responsive: true,
                order: [[5, 'asc']] // Sort by status by default (roughly)
            });
        }

        // Add Batch
        $('#addBatchForm').submit(function (e) {
            e.preventDefault();
            const formData = new FormData(this);

            $.ajax({
                url: '<?= url('api/batch/create') ?>',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.success) {
                        Swal.fire('Success', 'Batch created successfully', 'success')
                            .then(() => location.reload());
                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                },
                error: function () {
                    Swal.fire('Error', 'Failed to create batch', 'error');
                }
            });
        });

        // Edit Batch Click
        $('.btn-edit-batch').click(function () {
            const btn = $(this);
            $('#edit_batch_id').val(btn.data('id'));
            $('#edit_batch_name').val(btn.data('name'));
            $('#edit_course_id').val(btn.data('course'));
            $('#edit_teacher_id').val(btn.data('teacher'));
            $('#edit_start_date').val(btn.data('start'));
            $('#edit_end_date').val(btn.data('end'));
            $('#edit_timing').val(btn.data('timing'));
            $('#edit_max_students').val(btn.data('max'));
            $('#edit_status').val(btn.data('status'));

            $('#editBatchModal').modal('show');
        });

        // Update Batch
        $('#editBatchForm').submit(function (e) {
            e.preventDefault();
            const formData = new FormData(this);

            $.ajax({
                url: '<?= url('api/batch/update') ?>',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.success) {
                        Swal.fire('Success', 'Batch updated successfully', 'success')
                            .then(() => location.reload());
                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                },
                error: function () {
                    Swal.fire('Error', 'Failed to update batch', 'error');
                }
            });
        });

        // Delete Batch
        $('.btn-delete-batch').click(function () {
            const id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?= url('api/batch/delete') ?>',
                        type: 'POST',
                        data: {
                            id: id,
                            csrf_token: '<?= CSRF::getToken() ?>'
                        },
                        success: function (response) {
                            if (response.success) {
                                Swal.fire('Deleted!', 'Batch has been deleted.', 'success')
                                    .then(() => location.reload());
                            } else {
                                Swal.fire('Error', response.message, 'error');
                            }
                        }
                    });
                }
            });
        });
    });
</script>