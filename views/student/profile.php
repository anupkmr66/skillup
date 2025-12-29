<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-user me-2"></i>My Profile
        </h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3 text-center mb-4">
                <?php if ($student['photo']): ?>
                    <img src="<?= url('storage/uploads/students/' . $student['photo']) ?>"
                        class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;"
                        alt="Student Photo">
                <?php else: ?>
                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                        style="width: 150px; height: 150px;">
                        <i class="fas fa-user fa-4x text-muted"></i>
                    </div>
                <?php endif; ?>
                <h5><?= e($student['first_name'] . ' ' . $student['last_name']) ?></h5>
                <p class="text-muted"><?= e($student['student_id']) ?></p>
            </div>

            <div class="col-md-9">
                <h6 class="mb-3">Personal Information</h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Email</label>
                        <p class="mb-0"><?= e($student['email'] ?? 'Not provided') ?></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Phone</label>
                        <p class="mb-0"><?= e($student['phone']) ?></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Gender</label>
                        <p class="mb-0"><?= ucfirst($student['gender']) ?></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Date of Birth</label>
                        <p class="mb-0"><?= formatDate($student['dob']) ?></p>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="text-muted small">Address</label>
                        <p class="mb-0"><?= e($student['address']) ?></p>
                    </div>
                </div>

                <hr>

                <h6 class="mb-3">Guardian Information</h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Guardian Name</label>
                        <p class="mb-0"><?= e($student['guardian_name']) ?></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Guardian Phone</label>
                        <p class="mb-0"><?= e($student['guardian_phone']) ?></p>
                    </div>
                </div>

                <hr>

                <h6 class="mb-3">Institute Information</h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Institute Name</label>
                        <p class="mb-0"><?= e($student['institute_name']) ?></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Enrollment Date</label>
                        <p class="mb-0"><?= formatDate($student['enrollment_date']) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>