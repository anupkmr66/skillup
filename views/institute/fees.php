<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-money-bill-wave me-2"></i>Fees Management
        </h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="feesTable">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Student Name</th>
                        <th>Course</th>
                        <th>Total Fee</th>
                        <th>Discount</th>
                        <th>Paid Amount</th>
                        <th>Due Amount</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($fees) && !empty($fees)): ?>
                        <?php foreach ($fees as $fee): ?>
                            <tr>
                                <td><?= e($fee['student_id']) ?></td>
                                <td><?= e($fee['first_name'] . ' ' . $fee['last_name']) ?></td>
                                <td><?= e($fee['course_name']) ?></td>
                                <td>₹<?= number_format($fee['total_fee'], 2) ?></td>
                                <td>₹<?= number_format($fee['discount_amount'] ?? 0, 2) ?></td>
                                <td>₹<?= number_format($fee['paid_amount'], 2) ?></td>
                                <td>₹<?= number_format($fee['due_amount'], 2) ?></td>
                                <td><?= formatDate($fee['due_date']) ?></td>
                                <td>
                                    <span class="badge badge-<?=
                                        $fee['status'] === 'paid' ? 'success' :
                                        ($fee['status'] === 'partial' ? 'warning' : 'danger')
                                        ?>">
                                        <?= ucfirst($fee['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-primary btn-collect-payment" data-id="<?= $fee['id'] ?>"
                                            data-student="<?= e($fee['first_name'] . ' ' . $fee['last_name']) ?>"
                                            data-due="<?= $fee['due_amount'] ?>" title="Collect Payment">
                                            <i class="fas fa-dollar-sign"></i>
                                        </button>
                                        <button class="btn btn-warning btn-apply-discount" data-id="<?= $fee['id'] ?>"
                                            data-student="<?= e($fee['first_name'] . ' ' . $fee['last_name']) ?>"
                                            title="Apply Discount">
                                            <i class="fas fa-percent"></i>
                                        </button>
                                        <button class="btn btn-info btn-view-fee" data-id="<?= $fee['id'] ?>"
                                            title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
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

<!-- View Fee Details Modal -->
<div class="modal fade" id="viewFeeModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-file-invoice me-2"></i>Fee Details</h5>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-dark btn-print-statement"><i class="fas fa-print me-2"></i>Print
                    Statement</button>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('DOMContentLoaded', function () {
        if (typeof jQuery === 'undefined') {
            console.error('jQuery not loaded!');
            return;
        }

        console.log('Institute fees page loaded');

        // Collect Payment
        $(document).on('click', '.btn-collect-payment', function () {
            const feeId = $(this).data('id');
            const studentName = $(this).data('student');
            const dueAmount = parseFloat($(this).data('due'));

            Swal.fire({
                title: 'Collect Payment',
                html: `
                <p><strong>Student:</strong> ${studentName}</p>
                <p><strong>Due Amount:</strong> ₹${dueAmount.toFixed(2)}</p>
                <input type="number" id="payment_amount" class="swal2-input" placeholder="Amount" min="0" max="${dueAmount}" step="0.01" required>
                <select id="payment_method" class="swal2-input" required>
                    <option value="">Select Payment Method</option>
                    <option value="cash">Cash</option>
                    <option value="card">Card</option>
                    <option value="upi">UPI</option>
                    <option value="bank_transfer">Bank Transfer</option>
                </select>
                <input type="text" id="transaction_id" class="swal2-input" placeholder="Transaction ID (Optional)">
                <textarea id="remarks" class="swal2-textarea" placeholder="Remarks (Optional)"></textarea>
            `,
                showCancelButton: true,
                confirmButtonText: 'Collect Payment',
                preConfirm: () => {
                    const amount = document.getElementById('payment_amount').value;
                    const method = document.getElementById('payment_method').value;
                    if (!amount || !method) {
                        Swal.showValidationMessage('Please fill required fields');
                        return false;
                    }
                    if (parseFloat(amount) > dueAmount) {
                        Swal.showValidationMessage('Amount cannot exceed due amount');
                        return false;
                    }
                    return {
                        amount,
                        method,
                        transaction_id: document.getElementById('transaction_id').value,
                        remarks: document.getElementById('remarks').value
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData();
                    formData.append('fee_id', feeId);
                    formData.append('amount', result.value.amount);
                    formData.append('payment_method', result.value.method);
                    formData.append('transaction_id', result.value.transaction_id);
                    formData.append('remarks', result.value.remarks);
                    formData.append('csrf_token', '<?= CSRF::getToken() ?>');

                    $.ajax({
                        url: '<?= url('api/payment/create') ?>',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Payment Collected!',
                                    text: `Receipt: ${response.receipt_number}`,
                                    timer: 3000
                                }).then(() => location.reload());
                            } else {
                                Swal.fire('Error', response.message, 'error');
                            }
                        },
                        error: function (xhr) {
                            const response = xhr.responseJSON;
                            Swal.fire('Error', response?.message || 'Failed to collect payment', 'error');
                        }
                    });
                }
            });
        });

        // Apply Discount
        $(document).on('click', '.btn-apply-discount', function () {
            const feeId = $(this).data('id');
            const studentName = $(this).data('student');

            Swal.fire({
                title: 'Apply Discount',
                text: `For ${studentName}`,
                input: 'number',
                inputPlaceholder: 'Enter discount amount',
                inputAttributes: {
                    min: '0',
                    step: '0.01'
                },
                showCancelButton: true,
                confirmButtonText: 'Apply',
                showLoaderOnConfirm: true,
                preConfirm: (amount) => {
                    if (!amount) {
                        Swal.showValidationMessage('Please enter an amount');
                    }
                    return amount;
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?= url('api/fee/discount') ?>',
                        type: 'POST',
                        data: {
                            fee_id: feeId,
                            discount_amount: result.value,
                            csrf_token: '<?= CSRF::getToken() ?>'
                        },
                        success: function (response) {
                            if (response.success) {
                                Swal.fire('Success', response.message, 'success').then(() => location.reload());
                            } else {
                                Swal.fire('Error', response.message, 'error');
                            }
                        },
                        error: function () {
                            Swal.fire('Error', 'Failed to apply discount', 'error');
                        }
                    });
                }
            });
        });

        // View Fee Details
        $(document).on('click', '.btn-view-fee', function () {
            const feeId = $(this).data('id');
            $('#viewFeeModal').modal('show');
            $('#feeDetailsContent').html('<div class="text-center"><div class="spinner-border"></div></div>');
            $('.btn-print-statement').hide().data('id', feeId);

            $.ajax({
                url: '<?= url('api/fee/get') ?>?id=' + feeId,
                type: 'GET',
                success: function (response) {
                    if (response.success && response.data) {
                        const f = response.data;
                        $('.btn-print-statement').show(); // Show print statement button

                        let html = `
                        <div class="row mb-3">
                            <div class="col-md-6"><strong>Student:</strong> ${f.student_name}</div>
                            <div class="col-md-6"><strong>Course:</strong> ${f.course_name}</div>
                            <div class="col-md-6"><strong>Total Fee:</strong> ₹${parseFloat(f.total_fee).toFixed(2)}</div>
                            <div class="col-md-6"><strong>Discount:</strong> ₹${parseFloat(f.discount_amount || 0).toFixed(2)}</div>
                            <div class="col-md-6"><strong>Paid:</strong> ₹${parseFloat(f.paid_amount).toFixed(2)}</div>
                            <div class="col-md-6"><strong>Due:</strong> ₹${parseFloat(f.due_amount).toFixed(2)}</div>
                            <div class="col-md-6"><strong>Status:</strong> <span class="badge badge-${f.status === 'paid' ? 'success' : (f.status === 'partial' ? 'warning' : 'danger')}">${f.status.toUpperCase()}</span></div>
                        </div>
                        <hr>
                        <h6>Payment History</h6>
                    `;

                        if (f.payments && f.payments.length > 0) {
                            html += '<table class="table table-sm"><thead><tr><th>Date</th><th>Amount</th><th>Method</th><th>Receipt</th><th>Action</th></tr></thead><tbody>';
                            f.payments.forEach(p => {
                                html += `<tr>
                                <td>${p.payment_date}</td>
                                <td>₹${parseFloat(p.amount).toFixed(2)}</td>
                                <td>${p.payment_method.toUpperCase()}</td>
                                <td>${p.receipt_number}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-dark btn-print-receipt" data-id="${p.id}" title="Print Receipt">
                                        <i class="fas fa-print"></i>
                                    </button>
                                </td>
                            </tr>`;
                            });
                            html += '</tbody></table>';
                        } else {
                            html += '<p class="text-muted">No payments recorded yet.</p>';
                        }

                        $('#feeDetailsContent').html(html);
                    } else {
                        $('#feeDetailsContent').html('<p class="text-danger">Failed to load fee details</p>');
                    }
                },
                error: function () {
                    $('#feeDetailsContent').html('<p class="text-danger">Error loading details</p>');
                }
            });
        });

        // Print Statement
        $(document).on('click', '.btn-print-statement', function () {
            const feeId = $(this).data('id');
            const url = '<?= url('institute/fees/print-statement') ?>?fee_id=' + feeId;
            window.open(url, 'FeeStatement', 'width=900,height=800');
        });

        // Print Receipt (Delegate event as it is dynamically added)
        $(document).on('click', '.btn-print-receipt', function () {
            const paymentId = $(this).data('id');
            const url = '<?= url('institute/fees/print-receipt') ?>?payment_id=' + paymentId;
            window.open(url, 'PaymentReceipt', 'width=800,height=600');
        });

        // Initialize DataTable
        if (typeof $.fn.DataTable !== 'undefined') {
            $('#feesTable').DataTable({
                pageLength: 10,
                order: [[6, 'desc']] // Order by due date
            });
        }
    });
</script>