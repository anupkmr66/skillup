<?php
// views/admin/leads.php
?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">
            <i class="fas fa-bullhorn me-2"></i>Inquiries & Leads
        </h5>
        <button class="btn btn-sm btn-success">
            <i class="fas fa-file-export me-2"></i>Export CSV
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="leadsTable" class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>Interested Course</th>
                        <th>Qualification</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($leads)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3"></i>
                                    <p>No inquiries found yet.</p>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($leads as $lead): ?>
                            <tr>
                                <td><?= date('M d, Y', strtotime($lead['created_at'])) ?></td>
                                <td class="fw-bold"><?= e($lead['name']) ?></td>
                                <td>
                                    <div><i class="fas fa-phone small text-muted me-1"></i> <?= e($lead['phone']) ?></div>
                                    <div class="small text-muted"><i class="fas fa-envelope small me-1"></i>
                                        <?= e($lead['email']) ?></div>
                                </td>
                                <td>
                                    <?php if ($lead['course_name']): ?>
                                        <span class="badge bg-info bg-opacity-10 text-info"><?= e($lead['course_name']) ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">General Inquiry</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= e($lead['education'] ?: '-') ?></td>
                                <td>
                                    <?php
                                    $statusClass = match ($lead['status']) {
                                        'new' => 'bg-primary',
                                        'contacted' => 'bg-warning text-dark',
                                        'enrolled' => 'bg-success',
                                        'closed' => 'bg-secondary',
                                        default => 'bg-light text-dark'
                                    };
                                    ?>
                                    <span class="badge <?= $statusClass ?>"><?= ucfirst($lead['status']) ?></span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-info text-white view-lead-btn"
                                            data-lead='<?= json_encode($lead, JSON_HEX_APOS | JSON_HEX_QUOT) ?>'
                                            title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <a href="tel:<?= e($lead['phone']) ?>" class="btn btn-success" title="Call Now">
                                            <i class="fas fa-phone"></i>
                                        </a>
                                        <!-- Potential delete or edit buttons actions here -->
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- View Lead Modal -->
<div class="modal fade" id="viewLeadModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Lead Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <div class="avatar-circle bg-primary text-white mx-auto mb-3"
                        style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-size: 24px;">
                        <span id="view_lead_initial"></span>
                    </div>
                    <h5 id="view_lead_name" class="mb-0"></h5>
                </div>

                <table class="table table-borderless">
                    <tr>
                        <td class="text-muted" width="40%">Phone:</td>
                        <td class="fw-bold" id="view_lead_phone"></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Email:</td>
                        <td class="fw-bold" id="view_lead_email"></td>
                    </tr>
                    <tr>
                        <td class="text-muted">City:</td>
                        <td id="view_lead_city"></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Education:</td>
                        <td id="view_lead_education"></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Course Interest:</td>
                        <td id="view_lead_course"></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Message:</td>
                        <td id="view_lead_message" class="bg-light p-2 rounded"></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Received On:</td>
                        <td id="view_lead_date"></td>
                    </tr>
                </table>

                <div class="d-grid mt-3 gap-2">
                    <button class="btn btn-primary"><i class="fas fa-check me-2"></i>Mark as Contacted</button>
                    <!-- Add Convert to Student button in future -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        if (typeof $.fn.DataTable !== 'undefined') {
            $('#leadsTable').DataTable({
                order: [[0, 'desc']],
                pageLength: 10,
                language: {
                    emptyTable: "No data available in table"
                }
            });
        }

        $(document).on('click', '.view-lead-btn', function () {
            var lead = $(this).data('lead');
            $('#view_lead_name').text(lead.name);
            $('#view_lead_initial').text(lead.name.charAt(0));
            $('#view_lead_phone').text(lead.phone);
            $('#view_lead_email').text(lead.email || 'N/A');
            $('#view_lead_city').text(lead.city || 'N/A');
            $('#view_lead_education').text(lead.education || 'N/A');
            $('#view_lead_course').text(lead.course_name || 'General');
            $('#view_lead_message').text(lead.message || 'No message');
            $('#view_lead_date').text(new Date(lead.created_at).toLocaleDateString());

            $('#viewLeadModal').modal('show');
        });
    });
</script>