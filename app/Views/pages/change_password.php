<?= $this->extend('main/master') ?>
<?= $this->section('content') ?>
<?= $this->include('main/navbar') ?>

<div class="container-fluid py-4 px-4">

    <!-- Page Title -->
    <div class="text-center mb-4">
        <h2 class="fw-bold text-white">
            <i class="bi bi-key-fill me-2"></i> Change Password
        </h2>
        <p class="text-white-50 mb-0">Update your account password securely.</p>
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
                            <i class="bi bi-shield-lock-fill text-primary"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-uppercase text-secondary small mb-0">Security</div>
                            <div class="text-secondary" style="font-size:12px;">Change your password</div>
                        </div>
                    </div>

                    <span class="badge rounded-pill text-bg-light border">
                        <i class="bi bi-info-circle me-1"></i> Strong password recommended
                    </span>
                </div>

                <!-- Body -->
                <div class="card-body px-4 py-4">

                    <!-- Optional Alert Placeholder -->
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
                    <form action="<?= base_url('change_password') ?>" method="post" class="needs-validation" novalidate>
                        <?= csrf_field() ?>

                        <!-- Current Password -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Current Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control" name="current_password" id="current_password" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePw('current_password', this)">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <div class="invalid-feedback">Please enter your current password.</div>
                            </div>
                        </div>

                        <!-- New Password -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">New Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-shield-lock"></i></span>
                                <input type="password" class="form-control" name="new_password" id="new_password" minlength="8" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePw('new_password', this)">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <div class="invalid-feedback">New password must be at least 8 characters.</div>
                            </div>
                            <div class="form-text">
                                Use at least <b>8 characters</b>, mix letters, numbers, and symbols.
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Confirm New Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-check2-circle"></i></span>
                                <input type="password" class="form-control" name="confirm_password" id="confirm_password" minlength="8" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePw('confirm_password', this)">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <div class="invalid-feedback">Please confirm your new password.</div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2 justify-content-end mt-4">
                            <a href="<?= base_url('dashboard') ?>" class="btn btn-light rounded-pill px-4">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold">
                                <i class="bi bi-save2 me-1"></i> Update Password
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
                            <div class="fw-bold">Password Tips</div>
                            <div class="text-secondary small">
                                Don’t reuse old passwords. Avoid using your name, birthdate, or easy patterns like <code>123456</code>.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold text-success">
                    <i class="bi bi-check-circle-fill me-2"></i>Password Updated
                </h5>
            </div>
            <div class="modal-body text-center">
                <p class="mb-0">
                    Your password has been changed successfully.<br>
                    You will be redirected to the login page.
                </p>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn btn-success rounded-pill px-4" id="confirmRedirect">
                    OK
                </button>
            </div>
        </div>
    </div>
</div>

<?php if (session()->getFlashdata('password_changed')): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = new bootstrap.Modal(document.getElementById('successModal'));
            modal.show();

            // Click OK to redirect
            document.getElementById('confirmRedirect').addEventListener('click', () => {
                window.location.href = "<?= base_url('logout') ?>";
            });
        });
    </script>
<?php endif; ?>


<script src="<?= base_url('js/change_password.js') ?>"></script>

<?= $this->endSection(); ?>