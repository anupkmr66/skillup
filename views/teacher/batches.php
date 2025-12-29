<!-- Teacher Batches View -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-users me-2"></i>My Batches
                </h5>
                <div class="input-group" style="width: 250px;">
                    <input type="text" id="searchBatches" class="form-control form-control-sm"
                        placeholder="Search batches...">
                    <button class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <?php if (empty($batches)): ?>
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-chalkboard-teacher fa-4x mb-3 opacity-50"></i>
                        <p class="h5">No batches assigned yet.</p>
                        <p>Contact your institute administrator for assignments.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Batch Name</th>
                                    <th>Course</th>
                                    <th>Institute</th>
                                    <th>Timing</th>
                                    <th>Students</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($batches as $batch): ?>
                                    <tr>
                                        <td>
                                            <div class="fw-bold"><?= e($batch['batch_name']) ?></div>
                                            <small class="text-muted">
                                                Start: <?= formatDate($batch['start_date']) ?>
                                            </small>
                                        </td>
                                        <td><?= e($batch['course_name']) ?></td>
                                        <td><?= e($batch['institute_name']) ?></td>
                                        <td>
                                            <i class="far fa-clock me-1"></i>
                                            <?= e($batch['timing']) ?>
                                        </td>
                                        <td>
                                            <span class="badge bg-info rounded-pill">
                                                <i class="fas fa-user-graduate me-1"></i>
                                                <?= $batch['student_count'] ?? 0 ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="badge bg-<?= $batch['status'] === 'active' ? 'success' : 'secondary' ?>">
                                                <?= ucfirst($batch['status']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <button type="button" class="btn btn-outline-primary"
                                                    onclick="viewStudents('<?= $batch['id'] ?>', '<?= e($batch['batch_name']) ?>')"
                                                    title="View Students">
                                                    <i class="fas fa-users"></i>
                                                </button>
                                                <button type="button" class="btn btn-outline-success"
                                                    onclick="markAttendance('<?= $batch['id'] ?>', '<?= e($batch['batch_name']) ?>')"
                                                    title="Mark Attendance">
                                                    <i class="fas fa-clipboard-check"></i>
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

<!-- View Students Modal -->
<div class="modal fade" id="studentsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Students - <span id="modalBatchName"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="studentsLoader" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status"></div>
                </div>
                <div id="studentsList" class="d-none">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Contact</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="studentsTableBody"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mark Attendance Modal -->
<div class="modal fade" id="attendanceModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Mark Attendance - <span id="attBatchName"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="attendanceForm">
                    <input type="hidden" name="batch_id" id="attBatchId">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Date</label>
                            <input type="date" name="date" class="form-control" value="<?= date('Y-m-d') ?>" required>
                        </div>
                    </div>

                    <div id="attLoader" class="text-center py-4">
                        <div class="spinner-border text-primary" role="status"></div>
                    </div>

                    <div id="attList" class="d-none">
                        <div class="table-responsive">
                            <table class="table table-sm align-middle">
                                <thead>
                                    <tr>
                                        <th>Student</th>
                                        <th class="text-center">Present</th>
                                        <th class="text-center">Absent</th>
                                        <th class="text-center">Late</th>
                                    </tr>
                                </thead>
                                <tbody id="attTableBody"></tbody>
                            </table>
                        </div>

                        <div class="d-grid mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Save Attendance
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function viewStudents(batchId, batchName) {
        document.getElementById('modalBatchName').textContent = batchName;
        const modal = new bootstrap.Modal(document.getElementById('studentsModal'));
        modal.show();

        document.getElementById('studentsLoader').classList.remove('d-none');
        document.getElementById('studentsList').classList.add('d-none');

        fetch(`<?= url('api/batch/students') ?>?batch_id=${batchId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('studentsLoader').classList.add('d-none');

                if (data.success) {
                    const tbody = document.getElementById('studentsTableBody');
                    tbody.innerHTML = '';

                    if (data.data.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="4" class="text-center text-muted">No students enrolled</td></tr>';
                    } else {
                        document.getElementById('studentsList').classList.remove('d-none');
                        data.data.forEach(student => {
                            tbody.innerHTML += `
                            <tr>
                                <td>${student.student_id}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-2 bg-light rounded-circle d-flex align-items-center justify-content-center text-primary fw-bold">
                                            ${student.first_name.charAt(0)}
                                        </div>
                                        <div>
                                            <div>${student.first_name} ${student.last_name}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <small class="d-block"><i class="fas fa-phone me-1"></i>${student.phone || '-'}</small>
                                </td>
                                <td>
                                    <span class="badge bg-success">Active</span>
                                </td>
                            </tr>
                        `;
                        });
                    }
                } else {
                    alert(data.message);
                }
            })
            .catch(err => {
                console.error(err);
                document.getElementById('studentsLoader').classList.add('d-none');
                alert('Failed to load students');
            });
    }

    function markAttendance(batchId, batchName) {
        document.getElementById('attBatchName').textContent = batchName;
        document.getElementById('attBatchId').value = batchId;
        const modal = new bootstrap.Modal(document.getElementById('attendanceModal'));
        modal.show();

        document.getElementById('attLoader').classList.remove('d-none');
        document.getElementById('attList').classList.add('d-none');

        fetch(`<?= url('api/batch/students') ?>?batch_id=${batchId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('attLoader').classList.add('d-none');

                if (data.success) {
                    const tbody = document.getElementById('attTableBody');
                    tbody.innerHTML = '';

                    if (data.data.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="4" class="text-center text-muted">No students to mark attendance for</td></tr>';
                    } else {
                        document.getElementById('attList').classList.remove('d-none');
                        data.data.forEach(student => {
                            tbody.innerHTML += `
                            <tr>
                                <td>
                                    <div class="fw-bold">${student.first_name} ${student.last_name}</div>
                                    <small class="text-muted">${student.student_id}</small>
                                </td>
                                <td class="text-center">
                                    <div class="form-check d-inline-block">
                                        <input class="form-check-input" type="radio" name="students[${student.id}]" value="present" checked>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="form-check d-inline-block">
                                        <input class="form-check-input" type="radio" name="students[${student.id}]" value="absent">
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="form-check d-inline-block">
                                        <input class="form-check-input" type="radio" name="students[${student.id}]" value="late">
                                    </div>
                                </td>
                            </tr>
                        `;
                        });
                    }
                }
            });
    }

    document.getElementById('attendanceForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch('<?= url('api/attendance/record') ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-Token': '<?= CSRF::getToken() ?>'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Attendance recorded successfully');
                    bootstrap.Modal.getInstance(document.getElementById('attendanceModal')).hide();
                } else {
                    alert(data.message || 'Error recording attendance');
                }
            })
            .catch(err => {
                console.error(err);
                alert('An error occurred');
            });
    });

    // Search functionality
    document.getElementById('searchBatches').addEventListener('keyup', function () {
        const searchText = this.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            row.style.display = text.includes(searchText) ? '' : 'none';
        });
    });
</script>