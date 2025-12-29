<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h4 class="mb-0"><i class="fas fa-calendar-check text-primary me-2"></i>Attendance Management</h4>
        </div>
        <div class="col-md-6 text-end">
            <a href="<?= url('institute/attendance/report') ?>" class="btn btn-outline-primary">
                <i class="fas fa-table me-2"></i>Attendance Register
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Select Details</h5>
                </div>
                <div class="card-body">
                    <form id="loadStudentsForm">
                        <div class="mb-3">
                            <label class="form-label">Select Batch</label>
                            <select class="form-select" name="batch_id" id="batch_id" required>
                                <option value="">Choose Batch...</option>
                                <?php foreach ($batches as $batch): ?>
                                    <option value="<?= $batch['id'] ?>"><?= e($batch['batch_name']) ?>
                                        (<?= e($batch['timing']) ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Date</label>
                            <input type="date" class="form-control" name="date" id="date" value="<?= date('Y-m-d') ?>"
                                required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-users me-2"></i>Load Students
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm" id="attendanceCard" style="display: none;">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Mark Attendance</h5>
                    <div class="small text-muted" id="selectedDateDisplay"></div>
                </div>
                <div class="card-body">
                    <form id="attendanceForm">
                        <?= CSRF::field() ?>
                        <input type="hidden" name="batch_id" id="form_batch_id">
                        <input type="hidden" name="date" id="form_date">

                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Student Name</th>
                                        <th>ID</th>
                                        <th>Status</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody id="studentsList">
                                    <!-- Students will be loaded here -->
                                </tbody>
                            </table>
                        </div>

                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-2"></i>Save Attendance
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('DOMContentLoaded', function () {

        // Load Students
        $('#loadStudentsForm').submit(function (e) {
            e.preventDefault();
            const batchId = $('#batch_id').val();
            const date = $('#date').val();

            if (!batchId || !date) {
                Swal.fire('Error', 'Please select batch and date', 'error');
                return;
            }

            // Show loading state
            const btn = $(this).find('button[type="submit"]');
            const originalText = btn.html();
            btn.html('<i class="fas fa-spinner fa-spin me-2"></i>Loading...').prop('disabled', true);

            // Fetch students for the batch
            // We'll use a new API endpoint or modify an existing one. 
            // Since we didn't create a specific endpoint for "get students for batch", 
            // let's use the 'institute/students' logic but maybe we need an API.
            // Actually, let's create a quick API endpoint for fetching students of a batch on the fly, 
            // or we can use the existing `InstituteController` to return JSON if requested? 
            // No, let's use `getStudent` approach but for batch. 
            // Wait, I don't have an endpoint for this.
            // I should probably add one or handle it.
            // Let's assume there is one or I will add it to ApiController.
            // I will add `getBatchStudents` to ApiController.

            $.ajax({
                url: '<?= url('api/batch/students') ?>', // Need to add this route!
                type: 'GET',
                data: { batch_id: batchId, date: date },
                success: function (response) {
                    if (response.success) {
                        $('#attendanceCard').show();
                        $('#form_batch_id').val(batchId);
                        $('#form_date').val(date);
                        $('#selectedDateDisplay').text(new Date(date).toDateString());

                        const tbody = $('#studentsList');
                        tbody.empty();

                        if (response.data.length === 0) {
                            tbody.html('<tr><td colspan="4" class="text-center text-muted">No students found in this batch</td></tr>');
                        } else {
                            response.data.forEach(student => {
                                let statusHtml = `
                                <div class="btn-group" role="group">
                                    <input type="radio" class="btn-check" name="students[${student.id}]" id="p_${student.id}" value="present" ${student.attendance === 'present' || !student.attendance ? 'checked' : ''}>
                                    <label class="btn btn-outline-success btn-sm" for="p_${student.id}">P</label>

                                    <input type="radio" class="btn-check" name="students[${student.id}]" id="a_${student.id}" value="absent" ${student.attendance === 'absent' ? 'checked' : ''}>
                                    <label class="btn btn-outline-danger btn-sm" for="a_${student.id}">A</label>

                                    <input type="radio" class="btn-check" name="students[${student.id}]" id="l_${student.id}" value="late" ${student.attendance === 'late' ? 'checked' : ''}>
                                    <label class="btn btn-outline-warning btn-sm" for="l_${student.id}">L</label>
                                    
                                    <input type="radio" class="btn-check" name="students[${student.id}]" id="lv_${student.id}" value="leave" ${student.attendance === 'leave' ? 'checked' : ''}>
                                    <label class="btn btn-outline-info btn-sm" for="lv_${student.id}">Lev</label>
                                </div>
                            `;

                                tbody.append(`
                                <tr>
                                    <td>
                                        <div class="fw-bold">${student.first_name} ${student.last_name}</div>
                                    </td>
                                    <td>${student.student_id}</td>
                                    <td>${statusHtml}</td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm" placeholder="Optional" value="${student.remarks || ''}">
                                    </td>
                                </tr>
                            `);
                            });
                        }
                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                },
                error: function () {
                    Swal.fire('Error', 'Failed to fetch students', 'error');
                },
                complete: function () {
                    btn.html(originalText).prop('disabled', false);
                }
            });
        });

        // Submit Attendance
        $('#attendanceForm').submit(function (e) {
            e.preventDefault();
            const formData = new FormData(this);

            $.ajax({
                url: '<?= url('api/attendance/record') ?>',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.success) {
                        Swal.fire('Success', 'Attendance recorded successfully', 'success');
                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                },
                error: function () {
                    Swal.fire('Error', 'Failed to record attendance', 'error');
                }
            });
        });
    });
</script>