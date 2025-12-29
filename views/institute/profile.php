<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h4 class="mb-0"><i class="fas fa-user-cog text-primary me-2"></i>Institute Profile</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Edit Profile</h5>
                </div>
                <div class="card-body">
                    <form id="profileForm">
                        <?= CSRF::field() ?>
                        <input type="hidden" name="institute_id" value="<?= $institute['id'] ?>">

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Institute Name</label>
                                <input type="text" class="form-control" value="<?= e($institute['institute_name']) ?>"
                                    readonly disabled>
                                <small class="text-muted">Contact Super Admin to change institute name</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Institute Code</label>
                                <input type="text" class="form-control" value="<?= e($institute['institute_code']) ?>"
                                    readonly disabled>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Franchise</label>
                            <input type="text" class="form-control" value="<?= e($institute['franchise_name']) ?>"
                                readonly disabled>
                        </div>

                        <div class="row align-items-center mb-4">
                            <div class="col-auto">
                                <?php if (!empty($institute['logo'])): ?>
                                    <img src="<?= asset('uploads/logos/' . $institute['logo']) ?>" alt="Institute Logo"
                                        class="img-thumbnail" style="width: 100px; height: 100px; object-fit: contain;">
                                <?php else: ?>
                                    <div class="bg-light d-flex align-items-center justify-content-center rounded"
                                        style="width: 100px; height: 100px; border: 2px dashed #ccc;">
                                        <i class="fas fa-image text-muted fa-2x"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col">
                                <label class="form-label fw-bold">Institute Logo</label>
                                <input type="file" class="form-control" name="logo" accept="image/*">
                                <div class="form-text">Recommended size: 200x200px. Max size: 2MB.</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Contact Person <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="contact_person"
                                    value="<?= e($institute['contact_person']) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="phone"
                                    value="<?= e($institute['phone']) ?>" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Email Address</label>
                                <input type="email" class="form-control" value="<?= e($institute['email']) ?>" readonly
                                    disabled>
                                <small class="text-muted">Email cannot be changed directly</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Login Username</label>
                                <input type="text" class="form-control"
                                    value="<?= e($institute['user_email'] ?? 'N/A') ?>" readonly disabled>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Address <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="address" rows="3"
                                required><?= e($institute['address']) ?></textarea>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">City</label>
                                <input type="text" class="form-control" name="city"
                                    value="<?= e($institute['city']) ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">State</label>
                                <input type="text" class="form-control" name="state"
                                    value="<?= e($institute['state']) ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Pincode</label>
                                <input type="text" class="form-control" name="pincode"
                                    value="<?= e($institute['pincode']) ?>">
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Profile
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
        $('#profileForm').submit(function (e) {
            e.preventDefault();
            const formData = new FormData(this);

            // Show loading
            const btn = $(this).find('button[type="submit"]');
            const originalText = btn.html();
            btn.html('<i class="fas fa-spinner fa-spin me-2"></i>Saving...').prop('disabled', true);

            $.ajax({
                url: '<?= url('api/institute/update') ?>',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.success) {
                        Swal.fire('Success', 'Profile updated successfully', 'success')
                            .then(() => location.reload());
                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                },
                error: function () {
                    Swal.fire('Error', 'Failed to update profile', 'error');
                },
                complete: function () {
                    btn.html(originalText).prop('disabled', false);
                }
            });
        });
    });
</script>