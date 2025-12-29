<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h4 class="mb-0"><i class="fas fa-file-alt text-primary me-2"></i>Exam Management</h4>
        </div>
        <div class="col-md-6 text-md-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addExamModal">
                <i class="fas fa-plus me-2"></i>Schedule New Exam
            </button>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="examsTable">
                    <thead class="bg-light">
                        <tr>
                            <th>Exam Name</th>
                            <th>Course/Batch</th>
                            <th>Date & Time</th>
                            <th>Duration</th>
                            <th>Marks</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($exams) && !empty($exams)): ?>
                            <?php foreach ($exams as $exam): ?>
                                <tr>
                                    <td>
                                        <div class="fw-bold"><?= e($exam['exam_name']) ?></div>
                                        <div class="small text-muted"><?= e($exam['exam_code']) ?></div>
                                    </td>
                                    <td>
                                        <div><?= e($exam['course_name']) ?></div>
                                        <div class="small text-muted"><?= e($exam['batch_name'] ?? 'All Batches') ?></div>
                                    </td>
                                    <td>
                                        <div><?= date('d M Y', strtotime($exam['exam_date'])) ?></div>
                                        <div class="small text-muted"><?= date('h:i A', strtotime($exam['exam_time'])) ?></div>
                                    </td>
                                    <td><?= $exam['duration'] ?> mins</td>
                                    <td>
                                        <div>Total: <?= $exam['total_marks'] ?></div>
                                        <div class="small text-muted">Pass: <?= $exam['pass_marks'] ?></div>
                                    </td>
                                    <td>
                                        <?php
                                        $statusClass = match ($exam['status']) {
                                            'scheduled' => 'info',
                                            'ongoing' => 'primary',
                                            'completed' => 'success',
                                            'cancelled' => 'danger',
                                            default => 'secondary'
                                        };
                                        ?>
                                        <span class="badge bg-<?= $statusClass ?>"><?= ucfirst($exam['status']) ?></span>
                                    </td>
                                    <td>
                                        <a href="<?= url('institute/exam/results?id=' . $exam['id']) ?>"
                                            class="btn btn-sm btn-outline-success" title="Manage Results">
                                            <i class="fas fa-poll-h"></i>
                                        </a>
                                        <button class="btn btn-sm btn-outline-primary btn-edit-exam"
                                            data-id="<?= $exam['id'] ?>" data-name="<?= e($exam['exam_name']) ?>"
                                            data-code="<?= e($exam['exam_code']) ?>" data-course="<?= $exam['course_id'] ?>"
                                            data-batch="<?= $exam['batch_id'] ?>" data-date="<?= $exam['exam_date'] ?>"
                                            data-time="<?= $exam['exam_time'] ?>" data-duration="<?= $exam['duration'] ?>"
                                            data-total="<?= $exam['total_marks'] ?>" data-pass="<?= $exam['pass_marks'] ?>"
                                            data-status="<?= $exam['status'] ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger btn-delete-exam"
                                            data-id="<?= $exam['id'] ?>">
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

<!-- Add Exam Modal -->
<div class="modal fade" id="addExamModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Schedule New Exam</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addExamForm">
                <div class="modal-body">
                    <?= CSRF::field() ?>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Exam Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="exam_name"
                                placeholder="e.g. Mid-Term Assessment" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Exam Code</label>
                            <input type="text" class="form-control" name="exam_code"
                                placeholder="Auto-generated if empty">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Course <span class="text-danger">*</span></label>
                            <select class="form-select" name="course_id" id="course_select" required>
                                <option value="">Select Course</option>
                                <?php foreach ($courses as $course): ?>
                                    <option value="<?= $course['id'] ?>"><?= e($course['course_name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Batch <span class="text-danger">*</span></label>
                            <select class="form-select" name="batch_id" id="batch_select" required>
                                <option value="">Select Batch</option>
                                <?php foreach ($batches as $batch): ?>
                                    <option value="<?= $batch['id'] ?>" data-course="<?= $batch['course_id'] ?>">
                                        <?= e($batch['batch_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="exam_date" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Time <span class="text-danger">*</span></label>
                            <input type="time" class="form-control" name="exam_time" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Duration (mins) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="duration" value="60" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Total Marks <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="total_marks" value="100" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Pass Marks <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="pass_marks" value="40" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Schedule Exam</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Exam Modal -->
<div class="modal fade" id="editExamModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Exam</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editExamForm">
                <div class="modal-body">
                    <?= CSRF::field() ?>
                    <input type="hidden" name="exam_id" id="edit_exam_id">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Exam Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="exam_name" id="edit_exam_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Exam Code</label>
                            <input type="text" class="form-control" name="exam_code" id="edit_exam_code">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Course</label>
                            <input type="text" class="form-control" id="edit_course_name" readonly>
                            <input type="hidden" name="course_id" id="edit_course_id">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Batch</label>
                            <select class="form-select" name="batch_id" id="edit_batch_id" required>
                                <option value="">Select Batch</option>
                                <?php foreach ($batches as $batch): ?>
                                    <option value="<?= $batch['id'] ?>" data-course="<?= $batch['course_id'] ?>">
                                        <?= e($batch['batch_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="exam_date" id="edit_exam_date" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Time <span class="text-danger">*</span></label>
                            <input type="time" class="form-control" name="exam_time" id="edit_exam_time" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Duration (mins) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="duration" id="edit_duration" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Total Marks <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="total_marks" id="edit_total_marks" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Pass Marks <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="pass_marks" id="edit_pass_marks" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" id="edit_status">
                            <option value="scheduled">Scheduled</option>
                            <option value="ongoing">Ongoing</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Exam</button>
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
            $('#examsTable').DataTable({
                responsive: true,
                order: [[2, 'desc']] // Sort by Date
            });
        }

        // Dynamic Batch Filtering for Add Form
        $('#course_select').change(function () {
            const courseId = $(this).val();
            const batchSelect = $('#batch_select');

            batchSelect.find('option').hide();
            batchSelect.find('option[value=""]').show();
            batchSelect.val('');

            if (courseId) {
                batchSelect.find(`option[data-course="${courseId}"]`).show();
            } else {
                batchSelect.find('option').show();
            }
        });

        // Add Exam
        $('#addExamForm').submit(function (e) {
            e.preventDefault();
            const formData = new FormData(this);

            $.ajax({
                url: '<?= url('api/exam/create') ?>',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.success) {
                        Swal.fire('Success', 'Exam scheduled successfully', 'success')
                            .then(() => location.reload());
                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                },
                error: function () {
                    Swal.fire('Error', 'Failed to schedule exam', 'error');
                }
            });
        });

        // Edit Exam Click
        $('.btn-edit-exam').click(function () {
            const btn = $(this);
            const courseText = btn.closest('tr').find('td:nth-child(2) div:first').text();

            $('#edit_exam_id').val(btn.data('id'));
            $('#edit_exam_name').val(btn.data('name'));
            $('#edit_exam_code').val(btn.data('code'));
            $('#edit_course_id').val(btn.data('course'));
            $('#edit_course_name').val(courseText);

            // Filter batches for edit form based on course
            const courseId = btn.data('course');
            $('#edit_batch_id option').hide();
            $(`#edit_batch_id option[data-course="${courseId}"]`).show();
            $('#edit_batch_id').val(btn.data('batch'));

            $('#edit_exam_date').val(btn.data('date'));
            $('#edit_exam_time').val(btn.data('time'));
            $('#edit_duration').val(btn.data('duration'));
            $('#edit_total_marks').val(btn.data('total'));
            $('#edit_pass_marks').val(btn.data('pass'));
            $('#edit_status').val(btn.data('status'));

            $('#editExamModal').modal('show');
        });

        // Update Exam
        $('#editExamForm').submit(function (e) {
            e.preventDefault();
            const formData = new FormData(this);

            $.ajax({
                url: '<?= url('api/exam/update') ?>',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.success) {
                        Swal.fire('Success', 'Exam updated successfully', 'success')
                            .then(() => location.reload());
                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                },
                error: function () {
                    Swal.fire('Error', 'Failed to update exam', 'error');
                }
            });
        });

        // Delete Exam
        $('.btn-delete-exam').click(function () {
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
                        url: '<?= url('api/exam/delete') ?>',
                        type: 'POST',
                        data: {
                            id: id,
                            csrf_token: '<?= CSRF::getToken() ?>'
                        },
                        success: function (response) {
                            if (response.success) {
                                Swal.fire('Deleted!', 'Exam has been deleted.', 'success')
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