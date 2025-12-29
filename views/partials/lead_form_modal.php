<!-- Lead Generation Modal -->
<div class="modal fade" id="leadFormModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-light border-0">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-rocket text-primary me-2"></i>Start Your Journey
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="leadForm">
                    <?= CSRF::field() ?>
                    <input type="hidden" name="course_id" value="<?= $course['id'] ?>">

                    <!-- Progress Bar -->
                    <div class="progress mb-4" style="height: 5px;">
                        <div class="progress-bar bg-primary" id="leadProgressBar" role="progressbar" style="width: 33%">
                        </div>
                    </div>

                    <!-- Step 1: Basics -->
                    <div class="form-step" id="step1">
                        <div class="mb-3">
                            <label class="form-label text-muted small text-uppercase fw-bold">Full Name</label>
                            <input type="text" class="form-control form-control-lg" name="name" id="leadName"
                                placeholder="John Doe" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-muted small text-uppercase fw-bold">Phone Number</label>
                            <input type="tel" class="form-control form-control-lg" name="phone" id="leadPhone"
                                placeholder="+91 98765 43210" required>
                        </div>
                        <div class="d-grid">
                            <button type="button" class="btn btn-primary btn-lg" onclick="nextStep(2)">
                                Next <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Step 2: Contact -->
                    <div class="form-step d-none" id="step2">
                        <div class="mb-3">
                            <label class="form-label text-muted small text-uppercase fw-bold">Email Address</label>
                            <input type="email" class="form-control form-control-lg" name="email" id="leadEmail"
                                placeholder="john@example.com">
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-muted small text-uppercase fw-bold">City</label>
                            <input type="text" class="form-control form-control-lg" name="city" id="leadCity"
                                placeholder="Your City">
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-light flex-grow-1" onclick="nextStep(1)">Back</button>
                            <button type="button" class="btn btn-primary flex-grow-1"
                                onclick="nextStep(3)">Next</button>
                        </div>
                    </div>

                    <!-- Step 3: Details -->
                    <div class="form-step d-none" id="step3">
                        <div class="mb-3">
                            <label class="form-label text-muted small text-uppercase fw-bold">Qualification</label>
                            <select class="form-select form-select-lg" name="education">
                                <option value="">Select Qualification</option>
                                <option value="School Student">School Student</option>
                                <option value="Undergraduate">Undergraduate</option>
                                <option value="Graduate">Graduate</option>
                                <option value="Working Professional">Working Professional</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-muted small text-uppercase fw-bold">Message (Optional)</label>
                            <textarea class="form-control" name="message" rows="2"
                                placeholder="Any specific questions?"></textarea>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-light flex-grow-1" onclick="nextStep(2)">Back</button>
                            <button type="submit" class="btn btn-success flex-grow-1 fw-bold">Submit
                                Application</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function nextStep(step) {
        // Simple validation for step 1
        if (step === 2) {
            if (!document.getElementById('leadName').value || !document.getElementById('leadPhone').value) {
                alert('Please fill in your Name and Phone Number');
                return;
            }
        }

        document.querySelectorAll('.form-step').forEach(el => el.classList.add('d-none'));
        document.getElementById('step' + step).classList.remove('d-none');

        // Update progress
        var progress = step * 33.33;
        document.getElementById('leadProgressBar').style.width = progress + '%';
    }

    document.getElementById('leadForm').addEventListener('submit', function (e) {
        e.preventDefault();
        var btn = this.querySelector('button[type="submit"]');
        var originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
        btn.disabled = true;

        var formData = new FormData(this);

        fetch('<?= url("api/lead/submit") ?>', {
            method: 'POST',
            body: formData,
            credentials: 'include' // Ensure session cookies are sent
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    btn.innerHTML = '<i class="fas fa-check"></i> Sent!';
                    btn.classList.remove('btn-success');
                    btn.classList.add('btn-dark');
                    setTimeout(() => {
                        var modal = bootstrap.Modal.getInstance(document.getElementById('leadFormModal'));
                        modal.hide();
                        alert(data.message); // Ideally replace with a nice toast
                        document.getElementById('leadForm').reset();
                        nextStep(1); // Reset to step 1
                        btn.disabled = false;
                        btn.innerHTML = originalText;
                        btn.classList.add('btn-success');
                        btn.classList.remove('btn-dark');
                    }, 1000);
                } else {
                    alert(data.message);
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Something went wrong. Please try again.');
                btn.disabled = false;
                btn.innerHTML = originalText;
            });
    });
</script>