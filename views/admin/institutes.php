<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-school me-2"></i>Manage Institutes
        </h5>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addInstituteModal">
                <i class="fas fa-plus me-2"></i>Add New Institute
            </button>
        </div>

        <div class="table-responsive">
            <table class="table" id="institutesTable">
                <thead>
                    <tr>
                        <th>Institute Name</th>
                        <th>Franchise</th>
                        <th>Contact Person</th>
                        <th>Phone</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($institutes as $institute): ?>
                        <tr>
                            <td><?= e($institute['institute_name']) ?></td>
                            <td><?= e($institute['franchise_name']) ?></td>
                            <td><?= e($institute['contact_person']) ?></td>
                            <td><?= e($institute['phone']) ?></td>
                            <td><?= e($institute['city'] . ', ' . $institute['state']) ?></td>
                            <td>
                                <span class="badge badge-<?= $institute['status'] === 'active' ? 'success' : 'danger' ?>">
                                    <?= ucfirst($institute['status']) ?>
                                </span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-info view-btn" title="View" 
                                        data-bs-toggle="modal" data-bs-target="#viewInstituteModal"
                                        data-institute='<?= json_encode($institute, JSON_HEX_APOS) ?>'>
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-warning edit-btn" title="Edit" 
                                        data-bs-toggle="modal" data-bs-target="#editInstituteModal"
                                        data-institute='<?= json_encode($institute, JSON_HEX_APOS) ?>'>
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger delete-btn" title="Delete" 
                                        data-bs-toggle="modal" data-bs-target="#deleteInstituteModal"
                                        data-id="<?= $institute['id'] ?>" data-name="<?= e($institute['institute_name']) ?>">
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

<!-- Add Institute Modal -->
<div class="modal fade" id="addInstituteModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Institute</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= url('admin/institutes/create') ?>" method="POST" enctype="multipart/form-data">
                <?= CSRF::field() ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Institute Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="institute_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Franchise <span class="text-danger">*</span></label>
                            <select class="form-select" name="franchise_id" required>
                                <option value="">Select Franchise</option>
                                <?php
                                // Fetch active franchises for dropdown
                                $db = Database::getInstance();
                                $franchises = $db->fetchAll("SELECT id, franchise_name, city FROM franchises WHERE status = 'active'");
                                foreach ($franchises as $f):
                                    ?>
                                    <option value="<?= $f['id'] ?>"><?= e($f['franchise_name']) ?> (<?= e($f['city']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Contact Person <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="contact_person" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" name="phone" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="password" required minlength="6">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Address <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="address" rows="2" required></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">City <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="city" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">State <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="state" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Pincode <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="pincode" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Institute</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Institute Modal -->
<div class="modal fade" id="viewInstituteModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Institute Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">Institute Name</th>
                        <td id="view_institute_name"></td>
                    </tr>
                    <tr>
                        <th>Franchise</th>
                        <td id="view_franchise_name"></td>
                    </tr>
                    <tr>
                        <th>Code</th>
                        <td id="view_institute_code"></td>
                    </tr>
                    <tr>
                         <th>Email</th>
                         <td id="view_email"></td>
                    </tr>
                    <tr>
                        <th>Contact Person</th>
                        <td id="view_contact_person"></td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td id="view_phone"></td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td id="view_address"></td>
                    </tr>
                     <tr>
                        <th>Location</th>
                        <td id="view_location"></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td id="view_status"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Edit Institute Modal -->
<div class="modal fade" id="editInstituteModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Institute</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= url('admin/institutes/update') ?>" method="POST">
                <?= CSRF::field() ?>
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Institute Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="institute_name" id="edit_institute_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Franchise <span class="text-danger">*</span></label>
                            <select class="form-select" name="franchise_id" id="edit_franchise_id" required>
                                <option value="">Select Franchise</option>
                                <?php foreach ($franchises as $f): ?>
                                        <option value="<?= $f['id'] ?>"><?= e($f['franchise_name']) ?> (<?= e($f['city']) ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Contact Person <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="contact_person" id="edit_contact_person" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" name="phone" id="edit_phone" required>
                        </div>
                    </div>

                     <div class="mb-3">
                        <label class="form-label">Change Password (Leave blank to keep current)</label>
                        <input type="password" class="form-control" name="password" minlength="6">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Address <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="address" id="edit_address" rows="2" required></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">City <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="city" id="edit_city" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">State <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="state" id="edit_state" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Pincode <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="pincode" id="edit_pincode" required>
                        </div>
                    </div>

                    <div class="mb-3">
                         <label class="form-label">Status</label>
                         <select class="form-select" name="status" id="edit_status">
                             <option value="active">Active</option>
                             <option value="inactive">Inactive</option>
                         </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Institute</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Institute Modal -->
<div class="modal fade" id="deleteInstituteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Institute</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= url('admin/institutes/delete') ?>" method="POST">
                <?= CSRF::field() ?>
                <input type="hidden" name="id" id="delete_id">
                <div class="modal-body">
                    <p>Are you sure you want to delete <strong id="delete_institute_name"></strong>?</p>
                    <p class="text-danger"><small>This action cannot be undone. All associated data will be removed.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#institutesTable').DataTable({
            pageLength: 10,
            order: [[0, 'asc']]
        });

        // View Institute
        $('.view-btn').click(function() {
            const data = $(this).data('institute');
            $('#view_institute_name').text(data.institute_name);
            $('#view_franchise_name').text(data.franchise_name || '-');
            $('#view_institute_code').text(data.institute_code);
            $('#view_email').text(data.email);
            $('#view_contact_person').text(data.contact_person);
            $('#view_phone').text(data.phone);
            $('#view_address').text(data.address);
            $('#view_location').text(data.city + ', ' + data.state + ' - ' + data.pincode);
            $('#view_status').html(`<span class="badge badge-${data.status === 'active' ? 'success' : 'danger'}">${data.status.toUpperCase()}</span>`);
        });

        // Edit Institute
        $('.edit-btn').click(function() {
            const data = $(this).data('institute');
            $('#edit_id').val(data.id);
            $('#edit_institute_name').val(data.institute_name);
            $('#edit_franchise_id').val(data.franchise_id);
            $('#edit_contact_person').val(data.contact_person);
            $('#edit_phone').val(data.phone);
            $('#edit_address').val(data.address);
            $('#edit_city').val(data.city);
            $('#edit_state').val(data.state);
            $('#edit_pincode').val(data.pincode);
            $('#edit_status').val(data.status);
        });

        // Delete Institute
        $('.delete-btn').click(function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            $('#delete_id').val(id);
            $('#delete_institute_name').text(name);
        });
    });
</script>