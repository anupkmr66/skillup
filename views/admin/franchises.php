<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-network-wired me-2"></i>Manage Franchises
        </h5>
    </div>
    <div class="card-body">

        <ul class="nav nav-tabs mb-4" id="franchiseTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="active-tab" data-bs-toggle="tab" data-bs-target="#active"
                    type="button" role="tab">Active Franchises</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button"
                    role="tab">Pending Inquiries</button>
            </li>
        </ul>

        <div class="tab-content" id="franchiseTabsContent">
            <!-- Active Franchises Tab -->
            <div class="tab-pane fade show active" id="active" role="tabpanel">
                <div class="mb-3">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFranchiseModal">
                        <i class="fas fa-plus me-2"></i>Add New Franchise
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table" id="franchisesTable">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Franchise Name</th>
                                <th>Contact Person</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($franchises as $franchise): ?>
                                <tr>
                                    <td><strong><?= e($franchise['franchise_code']) ?></strong></td>
                                    <td><?= e($franchise['franchise_name']) ?></td>
                                    <td><?= e($franchise['owner_name']) ?></td>
                                    <td><?= e($franchise['email']) ?></td>
                                    <td><?= e($franchise['phone']) ?></td>
                                    <td><?= e($franchise['city'] . ', ' . $franchise['state']) ?></td>
                                    <td>
                                        <span
                                            class="badge badge-<?= $franchise['status'] === 'active' ? 'success' : 'danger' ?>">
                                            <?= ucfirst($franchise['status']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?= url('admin/franchise/certificate?id=' . $franchise['id']) ?>"
                                                target="_blank" class="btn btn-info text-white" title="View Certificate">
                                                <i class="fas fa-certificate"></i>
                                            </a>
                                            <button class="btn btn-warning edit-franchise-btn"
                                                data-id="<?= $franchise['id'] ?>"
                                                data-name="<?= e($franchise['franchise_name']) ?>"
                                                data-owner="<?= e($franchise['owner_name']) ?>"
                                                data-email="<?= e($franchise['email']) ?>"
                                                data-phone="<?= e($franchise['phone']) ?>"
                                                data-address="<?= e($franchise['address']) ?>"
                                                data-city="<?= e($franchise['city']) ?>"
                                                data-state="<?= e($franchise['state']) ?>"
                                                data-pincode="<?= e($franchise['pincode']) ?>"
                                                data-commission="<?= e($franchise['commission_rate']) ?>"
                                                data-bs-toggle="modal" data-bs-target="#editFranchiseModal" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="<?= url('admin/franchises/delete') ?>" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this franchise?');">
                                                <?= CSRF::field() ?>
                                                <input type="hidden" name="id" value="<?= $franchise['id'] ?>">
                                                <button type="submit" class="btn btn-danger" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pending Inquiries Tab -->
            <div class="tab-pane fade" id="pending" role="tabpanel">

                <h6 class="text-primary mb-3"><i class="fas fa-list me-2"></i>Inquiry List</h6>

                <?php if (empty($pendingInquiries)): ?>
                    <div class="alert alert-info">No franchise inquiries found.</div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover border" id="inquiriesTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>City/State</th>
                                    <th>Contact</th>
                                    <th>Message</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pendingInquiries as $inquiry): ?>
                                    <tr class="<?= $inquiry['status'] === 'converted' ? 'table-light' : '' ?>">
                                        <td><?= formatDate($inquiry['created_at']) ?></td>
                                        <td class="fw-bold">
                                            <?= e($inquiry['name']) ?>
                                            <?php if ($inquiry['status'] === 'converted'): ?>
                                                <span class="badge bg-success ms-2" style="font-size: 0.7em;">Approved</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= e($inquiry['city']) ?>, <?= e($inquiry['state']) ?></td>
                                        <td>
                                            <div class="small">
                                                <i class="fas fa-envelope me-1"></i> <?= e($inquiry['email']) ?><br>
                                                <i class="fas fa-phone me-1"></i> <?= e($inquiry['phone']) ?>
                                            </div>
                                        </td>
                                        <td><small><?= e(substr($inquiry['message'], 0, 50)) ?>...</small></td>
                                        <td>
                                            <?php if ($inquiry['status'] === 'converted'): ?>
                                                <button class="btn btn-secondary btn-sm" disabled title="Already Converted">
                                                    <i class="fas fa-lock me-1"></i>Approved
                                                </button>
                                            <?php else: ?>
                                                <button class="btn btn-outline-primary btn-sm approve-inquiry-btn"
                                                    data-id="<?= $inquiry['id'] ?>" data-name="<?= e($inquiry['name']) ?>"
                                                    data-email="<?= e($inquiry['email']) ?>"
                                                    data-phone="<?= e($inquiry['phone']) ?>" data-city="<?= e($inquiry['city']) ?>"
                                                    data-state="<?= e($inquiry['state']) ?>" data-bs-toggle="modal"
                                                    data-bs-target="#addFranchiseModal">
                                                    <i class="fas fa-user-plus me-1"></i>Convert
                                                </button>
                                            <?php endif; ?>
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

<!-- Add Franchise Modal -->
<div class="modal fade" id="addFranchiseModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-building me-2"></i>Add New Franchise
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addFranchiseForm" method="POST" action="<?= url('admin/franchises/create') ?>">
                <?= CSRF::field() ?>
                <!-- Hidden Inquiry ID -->
                <input type="hidden" name="inquiry_id" id="inquiry_id">

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Franchise Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="franchise_name" id="franchise_name" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Contact Person <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="contact_person" id="contact_person" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" id="email" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" name="phone" id="phone" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Commission Rate (%)</label>
                            <input type="number" class="form-control" name="commission_rate" value="10" min="0"
                                max="100" step="0.1">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Address <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="address" id="address" rows="2" required></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">City <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="city" id="city" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">State <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="state" id="state" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Pincode <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="pincode" id="pincode" required>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <small>A franchise code will be auto-generated upon creation.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Create Franchise
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Franchise Modal -->
<div class="modal fade" id="editFranchiseModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-edit me-2"></i>Edit Franchise
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editFranchiseForm" method="POST" action="<?= url('admin/franchises/update') ?>">
                <?= CSRF::field() ?>
                <input type="hidden" name="id" id="edit_id">

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Franchise Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="franchise_name" id="edit_franchise_name" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Contact Person <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="contact_person" id="edit_contact_person"
                                required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" id="edit_email" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" name="phone" id="edit_phone" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Commission Rate (%)</label>
                            <input type="number" class="form-control" name="commission_rate" id="edit_commission_rate"
                                min="0" max="100" step="0.1">
                        </div>
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('#franchisesTable').DataTable({
            pageLength: 10,
            order: [[0, 'desc']]
        });

        // Handle Approve Button Click
        $('.approve-inquiry-btn').click(function () {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var email = $(this).data('email');
            var phone = $(this).data('phone');
            var city = $(this).data('city');
            var state = $(this).data('state');

            // Pre-fill modal fields
            $('#inquiry_id').val(id);
            $('#contact_person').val(name);
            $('#email').val(email);
            $('#phone').val(phone);
            $('#city').val(city);
            $('#state').val(state);

            // Suggest a Franchise Name
            $('#franchise_name').val('SkillUp - ' + city);
        });

        // Handle Edit Button Click
        $('.edit-franchise-btn').click(function () {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var owner = $(this).data('owner');
            var email = $(this).data('email');
            var phone = $(this).data('phone');
            var address = $(this).data('address');
            var city = $(this).data('city');
            var state = $(this).data('state');
            var pincode = $(this).data('pincode');
            var commission = $(this).data('commission');

            $('#edit_id').val(id);
            $('#edit_franchise_name').val(name);
            $('#edit_contact_person').val(owner);
            $('#edit_email').val(email);
            $('#edit_phone').val(phone);
            $('#edit_address').val(address);
            $('#edit_city').val(city);
            $('#edit_state').val(state);
            $('#edit_pincode').val(pincode);
            $('#edit_commission_rate').val(commission);
        });

        // Clear modal when closed (optional, but good for UX)
        $('#addFranchiseModal').on('hidden.bs.modal', function () {
            $('#addFranchiseForm')[0].reset();
            $('#inquiry_id').val('');
        });
    });

</script>