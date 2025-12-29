<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h4 class="mb-0">
                <i class="fas fa-poll-h text-primary me-2"></i>Exam Results
            </h4>
            <div class="text-muted mt-1">
                <?= e($exam['exam_name']) ?> (<?= e($exam['exam_code']) ?>)
            </div>
        </div>
        <div class="col-md-6 text-end">
            <a href="<?= url('institute/exams') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Exams
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-center gap-3">
                        <span class="badge bg-<?= $exam['status'] === 'completed' ? 'success' : 'info' ?>">
                            <?= ucfirst($exam['status']) ?>
                        </span>
                        <div>
                            <strong>Batch:</strong> <?= e($exam['batch_name'] ?? 'All') ?> |
                            <strong>Date:</strong> <?= date('d M Y', strtotime($exam['exam_date'])) ?> |
                            <strong>Marks:</strong> <?= $exam['total_marks'] ?> (Pass: <?= $exam['pass_marks'] ?>)
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <?php if ($exam['status'] !== 'completed'): ?>
                        <button class="btn btn-success" id="btnSaveResults">
                            <i class="fas fa-save me-2"></i>Save Results
                        </button>
                        <button class="btn btn-primary ms-2" id="btnMarkCompleted">
                            <i class="fas fa-check-circle me-2"></i>Finalize & Complete
                        </button>
                    <?php else: ?>
                        <div class="alert alert-success d-inline-block mb-0 py-1 px-3">
                            <i class="fas fa-check-circle me-2"></i>Exam Completed
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <form id="resultsForm">
                <?= CSRF::field() ?>
                <input type="hidden" name="exam_id" value="<?= $exam['id'] ?>">
                <input type="hidden" name="mark_completed" id="markCompletedInput" value="false">

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th>Student</th>
                                <th>Student ID</th>
                                <th style="width: 150px;">Marks Obtained</th>
                                <th style="width: 100px;">Status</th>
                                <th>Remarks</th>
                                <th style="width: 150px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="studentsList">
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="spinner-border text-primary"></div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    window.addEventListener('DOMContentLoaded', function () {
        const examId = <?= $exam['id'] ?>;
        const totalMarks = <?= $exam['total_marks'] ?>;
        const passMarks = <?= $exam['pass_marks'] ?>;
        const isCompleted = <?= $exam['status'] === 'completed' ? 'true' : 'false' ?>;

        loadStudents();

        function loadStudents() {
            $.ajax({
                url: '<?= url('api/exam/results') ?>',
                type: 'GET',
                data: { exam_id: examId },
                success: function (response) {
                    if (response.success) {
                        renderStudents(response.data);
                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                }
            });
        }

        function renderStudents(students) {
            const tbody = $('#studentsList');
            tbody.empty();

            if (students.length === 0) {
                tbody.html('<tr><td colspan="7" class="text-center py-4">No students found in this batch</td></tr>');
                return;
            }

            students.forEach((s, index) => {
                const marks = s.marks_obtained !== null ? s.marks_obtained : '';
                const status = s.status ? s.status : '-';
                const remarks = s.remarks || '';
                const statusClass = status === 'pass' ? 'success' : (status === 'fail' ? 'danger' : 'secondary');

                let actionBtn = '';
                if (isCompleted && status === 'pass') {
                    actionBtn = `
                    <a href="<?= url('institute/certificate/download') ?>?student_id=${s.id}&exam_id=${examId}" 
                       target="_blank" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-certificate me-1"></i>Certificate
                    </a>
                `;
                }

                const readonly = isCompleted ? 'readonly disabled' : '';

                const row = `
                <tr>
                    <td>${index + 1}</td>
                    <td>
                        <div class="fw-bold">${s.first_name} ${s.last_name}</div>
                    </td>
                    <td>${s.student_id}</td>
                    <td>
                        <input type="number" class="form-control" name="marks[${s.id}]" 
                               value="${marks}" max="${totalMarks}" min="0" step="0.5" ${readonly}>
                    </td>
                    <td>
                        <span class="badge bg-${statusClass}">${status.toUpperCase()}</span>
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm" name="remarks[${s.id}]" 
                               value="${remarks}" placeholder="Optional" ${readonly}>
                    </td>
                    <td>${actionBtn}</td>
                </tr>
            `;
                tbody.append(row);
            });
        }

        $('#btnSaveResults').click(function () {
            submitResults(false);
        });

        $('#btnMarkCompleted').click(function () {
            Swal.fire({
                title: 'Finalize Exam?',
                text: "This will lock the results and generate certificates for passed students. You cannot undo this.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Finalize',
                confirmButtonColor: '#0d6efd'
            }).then((result) => {
                if (result.isConfirmed) {
                    submitResults(true);
                }
            });
        });

        function submitResults(completed) {
            $('#markCompletedInput').val(completed);
            const formData = new FormData($('#resultsForm')[0]);

            $.ajax({
                url: '<?= url('api/exam/results/update') ?>',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.success) {
                        Swal.fire('Success', response.message, 'success')
                            .then(() => location.reload());
                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                },
                error: function () {
                    Swal.fire('Error', 'Failed to save results', 'error');
                }
            });
        }
    });
</script>