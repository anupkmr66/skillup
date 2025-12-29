<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-cog me-2"></i>System Settings
        </h5>
    </div>
    <div class="card-body">
        <form method="POST" action="<?= url('admin/settings') ?>">
            <?= CSRF::field() ?>

            <h6 class="mb-3">General Settings</h6>
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Institute Name</label>
                    <input type="text" class="form-control" name="institute_name" value="SkillUp Computer Institute">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Contact Email</label>
                    <input type="email" class="form-control" name="contact_email" value="info@skillup.com">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Contact Phone</label>
                    <input type="tel" class="form-control" name="contact_phone" value="+91-9876543210">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Website URL</label>
                    <input type="url" class="form-control" name="website_url" value="https://skillup.com">
                </div>
            </div>

            <h6 class="mb-3">Franchise Settings</h6>
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Default Commission Rate (%)</label>
                    <input type="number" class="form-control" name="commission_rate" value="10" min="0" max="100"
                        step="0.1">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Minimum Withdrawal Amount</label>
                    <input type="number" class="form-control" name="min_withdrawal" value="500" min="0">
                </div>
            </div>

            <h6 class="mb-3">Fee Settings</h6>
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Default Payment Due Days</label>
                    <input type="number" class="form-control" name="payment_due_days" value="30" min="1">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Late Fee Percentage (%)</label>
                    <input type="number" class="form-control" name="late_fee_percentage" value="5" min="0" max="100"
                        step="0.1">
                </div>
            </div>

            <h6 class="mb-3">Email Notifications</h6>
            <div class="mb-4">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="email_new_enrollment"
                        name="email_new_enrollment" checked>
                    <label class="form-check-label" for="email_new_enrollment">
                        Send email on new student enrollment
                    </label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="email_fee_payment" name="email_fee_payment"
                        checked>
                    <label class="form-check-label" for="email_fee_payment">
                        Send email on fee payment
                    </label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="email_certificate" name="email_certificate"
                        checked>
                    <label class="form-check-label" for="email_certificate">
                        Send email when certificate is issued
                    </label>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Save Settings
                </button>
                <button type="reset" class="btn btn-secondary">
                    <i class="fas fa-undo me-2"></i>Reset
                </button>
            </div>
        </form>
    </div>
</div>