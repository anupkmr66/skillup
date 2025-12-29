<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-building me-2"></i>Manage Students
        </h5>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                <i class="fas fa-plus me-2"></i>Add New Student
            </button>
        </div>

        <div class="table-responsive">
            <table class="table" id="studentsTable">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Institute</th>
                        <th>Enrollment Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?= e($student['student_id']) ?></td>
                            <td><?= e($student['first_name'] . ' ' . $student['last_name']) ?></td>
                            <td><?= e($student['email']) ?></td>
                            <td><?= e($student['phone']) ?></td>
                            <td><?= e($student['institute_name']) ?></td>
                            <td><?= formatDate($student['enrollment_date']) ?></td>
                            <td>
                                <span class="badge badge-<?= $student['status'] === 'active' ? 'success' : 'danger' ?>">
                                    <?= ucfirst($student['status']) ?>
                                </span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-info btn-view-student" data-id="<?= $student['id'] ?>"
                                        data-student-id="<?= $student['student_id'] ?>" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-warning btn-edit-student" data-id="<?= $student['id'] ?>"
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger btn-delete-student" data-id="<?= $student['id'] ?>"
                                        data-name="<?= e($student['first_name'] . ' ' . $student['last_name']) ?>"
                                        title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Student Modal -->
<div class="modal fade" id="addStudentModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-user-plus me-2"></i>Add New Student
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addStudentForm" method="POST" enctype="multipart/form-data">
                <?= CSRF::field() ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">First Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="first_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Last Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="last_name" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" name="phone" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Gender <span class="text-danger">*</span></label>
                            <select class="form-select" name="gender" required>
                                <option value="">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date of Birth <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="dob" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Address <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="address" rows="2" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Institute <span class="text-danger">*</span></label>
                        <select class="form-select" name="institute_id" required>
                            <option value="">Select Institute</option>
                            <?php foreach ($institutes as $institute): ?>
                                <option value="<?= $institute['id'] ?>"><?= e($institute['institute_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Guardian Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="guardian_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Guardian Phone <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" name="guardian_phone" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Student Photo</label>
                        <input type="file" class="form-control" name="photo" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Save Student
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Student Modal -->
<div class="modal fade" id="viewStudentModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-user me-2"></i>Student Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="studentDetailsContent">
                <div class="text-center">
                    <div class="spinner-border"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Student Modal -->
<div class="modal fade" id="editStudentModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editStudentForm" method="POST" enctype="multipart/form-data">
                <?= CSRF::field() ?>
                <input type="hidden" name="student_id" id="edit_student_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">First Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="first_name" id="edit_first_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Last Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="last_name" id="edit_last_name" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="edit_email">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" name="phone" id="edit_phone" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Gender <span class="text-danger">*</span></label>
                            <select class="form-select" name="gender" id="edit_gender" required>
                                <option value="">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date of Birth <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="dob" id="edit_dob" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="address" id="edit_address" rows="2" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Guardian Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="guardian_name" id="edit_guardian_name"
                                required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Guardian Phone <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" name="guardian_phone" id="edit_guardian_phone"
                                required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update Student
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Ensure this runs after jQuery is loaded
    window.addEventListener('DOMContentLoaded', function () {
        if (typeof jQuery === 'undefined') {
            console.error('jQuery not loaded!');
            return;
        }

        console.log('Admin students page script loaded, jQuery available');

        // Use event delegation for better reliability
        $(document).on('submit', '#addStudentForm', function (e) {
            e.preventDefault();
            e.stopPropagation();
            console.log('Form submit intercepted');

            const formData = new FormData(this);
            const apiUrl = '<?= url('api/student/create') ?>';
            console.log('Posting to:', apiUrl);

            $.ajax({
                url: apiUrl,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log('Success response:', response);
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message || 'Student created successfully',
                            timer: 2000
                        }).then(() => location.reload());
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'Failed to create student'
                        });
                    }
                },
                error: function (xhr) {
                    console.log('Error response:', xhr);
                    const response = xhr.responseJSON;
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response?.message || 'An error occurred'
                    });
                }
            });
        });

        // Handle Delete Student
        $(document).on('click', '.btn-delete-student', function () {
            const id = $(this).data('id');
            const name = $(this).data('name');

            Swal.fire({
                title: 'Confirm Delete',
                text: `Are you sure you want to delete ${name}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData();
                    formData.append('student_id', id);
                    formData.append('csrf_token', '<?= CSRF::getToken() ?>');

                    $.ajax({
                        url: '<?= url('api/student/delete') ?>',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            if (response.success) {
                                Swal.fire('Deleted!', response.message, 'success')
                                    .then(() => location.reload());
                            } else {
                                Swal.fire('Error', response.message, 'error');
                            }
                        },
                        error: function () {
                            Swal.fire('Error', 'Failed to delete student', 'error');
                        }
                    });
                }
            });
        });

        // Handle Edit Student
        $(document).on('click', '.btn-edit-student', function () {
            const id = $(this).data('id');
            $('#editStudentModal').modal('show');

            $.ajax({
                url: '<?= url('api/student/get') ?>?id=' + id,
                type: 'GET',
                success: function (response) {
                    if (response.success && response.data) {
                        const s = response.data;
                        $('#edit_student_id').val(s.id);
                        $('#edit_first_name').val(s.first_name);
                        $('#edit_last_name').val(s.last_name);
                        $('#edit_email').val(s.email || '');
                        $('#edit_phone').val(s.phone);
                        $('#edit_gender').val(s.gender);
                        $('#edit_dob').val(s.dob);
                        $('#edit_address').val(s.address);
                        $('#edit_guardian_name').val(s.guardian_name);
                        $('#edit_guardian_phone').val(s.guardian_phone);
                    } else {
                        Swal.fire('Error', 'Failed to load student data', 'error');
                        $('#editStudentModal').modal('hide');
                    }
                },
                error: function () {
                    Swal.fire('Error', 'Failed to load student data', 'error');
                    $('#editStudentModal').modal('hide');
                }
            });
        });

        // Handle Edit Form Submission
        $(document).on('submit', '#editStudentForm', function (e) {
            e.preventDefault();
            e.stopPropagation();

            const formData = new FormData(this);

            $.ajax({
                url: '<?= url('api/student/update') ?>',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Updated!',
                            text: response.message || 'Student updated successfully',
                            timer: 2000
                        }).then(() => location.reload());
                    } else {
                        Swal.fire('Error', response.message || 'Failed to update student', 'error');
                    }
                },
                error: function (xhr) {
                    const response = xhr.responseJSON;
                    Swal.fire('Error', response?.message || 'An error occurred', 'error');
                }
            });
        });

        // Handle View Student
        $(document).on('click', '.btn-view-student', function () {
            const id = $(this).data('id');
            $('#viewStudentModal').modal('show');
            $('#studentDetailsContent').html('<div class="text-center"><div class="spinner-border"></div></div>');

            $.ajax({
                url: '<?= url('api/student/get') ?>?id=' + id,
                type: 'GET',
                success: function (response) {
                    if (response.success && response.data) {
                        const s = response.data;
                        const html = `
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <strong>Student ID:</strong> ${s.student_id || 'N/A'}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Name:</strong> ${s.first_name} ${s.last_name}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Email:</strong> ${s.email || 'N/A'}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Phone:</strong> ${s.phone}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Gender:</strong> ${s.gender ? s.gender.charAt(0).toUpperCase() + s.gender.slice(1) : 'N/A'}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Date of Birth:</strong> ${s.dob || 'N/A'}
                            </div>
                            <div class="col-12 mb-3">
                                <strong>Address:</strong><br>${s.address || 'N/A'}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Guardian Name:</strong> ${s.guardian_name || 'N/A'}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Guardian Phone:</strong> ${s.guardian_phone || 'N/A'}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Institute:</strong> ${s.institute_name || 'N/A'}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Enrollment Date:</strong> ${s.enrollment_date || 'N/A'}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Status:</strong> <span class="badge badge-${s.status === 'active' ? 'success' : 'danger'}">${s.status ? s.status.charAt(0).toUpperCase() + s.status.slice(1) : 'N/A'}</span>
                            </div>
                        </div>
                    `;
                        $('#studentDetailsContent').html(html);
                    } else {
                        $('#studentDetailsContent').html('<p class="text-danger">Failed to load student details</p>');
                    }
                },
                error: function () {
                    $('#studentDetailsContent').html('<p class="text-danger">Error loading student details</p>');
                }
            });
        });

        // Initialize DataTable
        if (typeof $.fn.DataTable !== 'undefined') {
            $('#studentsTable').DataTable({
                pageLength: 10,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                order: [[5, 'desc']]
            });
        }
    });
</script>