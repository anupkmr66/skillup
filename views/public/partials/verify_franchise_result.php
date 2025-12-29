<?php
// views/public/partials/verify_franchise_result.php
?>
<div class="card border-0 shadow-lg text-center animate__animated animate__fadeIn">
    <div class="card-header bg-success text-white py-3">
        <h4 class="mb-0"><i class="fas fa-check-circle me-2"></i>Verified Franchise Partner</h4>
    </div>
    <div class="card-body p-5">
        <div class="mb-4">
            <img src="<?= url('public/assets/images/certificate_seal.png') ?>" alt="Verified Seal"
                style="width: 100px; opacity: 0.8;">
        </div>

        <h2 class="text-primary fw-bold mb-2"><?= e($cert['franchise_name']) ?></h2>
        <p class="text-muted fs-5">Authorized Training Center</p>

        <hr class="my-4 w-50 mx-auto">

        <div class="row justify-content-center text-start">
            <div class="col-md-8">
                <table class="table table-borderless">
                    <tr>
                        <td class="text-secondary text-end w-50 pe-3">Certificate Number:</td>
                        <td class="fw-bold fs-5"><?= e($cert['certificate_number']) ?></td>
                    </tr>
                    <tr>
                        <td class="text-secondary text-end pe-3">Franchise Owner:</td>
                        <td class="fw-bold"><?= e($cert['owner_name']) ?></td>
                    </tr>
                    <tr>
                        <td class="text-secondary text-end pe-3">Location:</td>
                        <td class="fw-bold"><?= e($cert['city'] . ', ' . $cert['state']) ?></td>
                    </tr>
                    <tr>
                        <td class="text-secondary text-end pe-3">Authorized Since:</td>
                        <td class="fw-bold"><?= date('F d, Y', strtotime($cert['issue_date'])) ?></td>
                    </tr>
                    <tr>
                        <td class="text-secondary text-end pe-3">Status:</td>
                        <td>
                            <?php if ($cert['status'] === 'active'): ?>
                                <span class="badge bg-success rounded-pill px-3">Active Partner</span>
                            <?php else: ?>
                                <span class="badge bg-danger rounded-pill px-3">Revoked</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="alert alert-info mt-4 mb-0">
            <i class="fas fa-info-circle me-2"></i>
            This center is officially authorized to conduct training and issue SkillUp certifications.
        </div>
    </div>
</div>