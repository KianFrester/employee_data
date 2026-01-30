<?= $this->extend('main/master') ?>
<?= $this->section('content') ?>
<?= $this->include('main/navbar') ?>

<div class="container-fluid py-4 px-4">

    <!-- Page Title -->
    <div class="text-center mb-4">
        <h2 class="fw-bold text-white">
            <i class="bi bi-person-plus-fill me-2"></i> Register Account
        </h2>
        <p class="text-white-50 mb-0">Create a new account to access the system.</p>
        <hr class="border-white opacity-25">
    </div>

    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-6">

            <div class="card card-dash">
                <!-- Header -->
                <div class="card-dash-header px-4 py-3 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-3 d-flex align-items-center justify-content-center"
                            style="width:38px;height:38px;background:rgba(13,110,253,.15);">
                            <i class="bi bi-person-badge-fill text-primary"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-uppercase text-secondary small mb-0">Account Setup</div>
                            <div class="text-secondary" style="font-size:12px;">Register a new user</div>
                        </div>
                    </div>

                    <span class="badge rounded-pill text-bg-light border">
                        <i class="bi bi-info-circle me-1"></i> Use a strong password
                    </span>
                </div>

                <!-- Body -->
                <div class="card-body px-4 py-4">

                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success rounded-4">
                            <i class="bi bi-check-circle me-2"></i>
                            <?= esc(session()->getFlashdata('success')) ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger rounded-4">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <?= esc(session()->getFlashdata('error')) ?>
                        </div>
                    <?php endif; ?>

                    <!-- Form -->
                    <form method="post" action="<?= base_url('/register'); ?>" class="needs-validation" novalidate>
                        <?= csrf_field() ?>

                        <!-- Username -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Username</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-person"></i></span>
                                <input name="username" type="text" class="form-control" placeholder="Enter username" required>
                                <div class="invalid-feedback">Please enter a username.</div>
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-lock"></i></span>
                                <input name="password" type="password" class="form-control" id="reg_password" minlength="8" placeholder="Enter password" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePw('reg_password', this)">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <div class="invalid-feedback">Password must be at least 8 characters.</div>
                            </div>
                            <div class="form-text">
                                Use at least <b>8 characters</b>, mix letters, numbers, and symbols.
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Confirm Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-check2-circle"></i></span>
                                <input name="confirm_password" type="password" class="form-control" id="reg_confirm_password" minlength="8" placeholder="Re-enter password" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePw('reg_confirm_password', this)">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <div class="invalid-feedback">Please confirm your password.</div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2 justify-content-end mt-4">
                            <a href="<?= base_url('dashboard') ?>" class="btn btn-light rounded-pill px-4">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-success rounded-pill px-4 fw-semibold">
                                <i class="bi bi-person-plus me-1"></i> Register
                            </button>
                        </div>
                    </form>

                </div>
            </div>

            <!-- Tips Card -->
            <div class="card border-0 shadow-sm rounded-4 mt-3">
                <div class="card-body px-4 py-3">
                    <div class="d-flex gap-3">
                        <div class="rounded-4 bg-primary bg-opacity-10 d-flex align-items-center justify-content-center"
                            style="width:44px;height:44px;">
                            <i class="bi bi-lightbulb text-primary"></i>
                        </div>
                        <div>
                            <div class="fw-bold">Registration Tips</div>
                            <div class="text-secondary small">
                                Choose a unique username. Avoid simple passwords like <code>123456</code>. Use a mix of uppercase, lowercase, numbers, and symbols.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    // show/hide password
    function togglePw(id, btn) {
        const el = document.getElementById(id);
        if (!el) return;

        const icon = btn.querySelector("i");
        if (el.type === "password") {
            el.type = "text";
            if (icon) icon.className = "bi bi-eye-slash";
        } else {
            el.type = "password";
            if (icon) icon.className = "bi bi-eye";
        }
    }

    // bootstrap validation
    (function() {
        'use strict'
        const forms = document.querySelectorAll('.needs-validation')
        Array.from(forms).forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })();
</script>

<?= $this->endSection() ?>
