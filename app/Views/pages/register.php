<?php echo $this->extend('main/master'); ?>
<?php echo $this->section('content'); ?>

<head>
    <title>Register Page</title>
</head>

<div class="container">
    <div class="row justify-content-center align-items-center vh-100">
        <div class="col-11 col-sm-8 col-md-6 col-lg-5 col-xl-4">
            <div class="card shadow-lg">
                <div class="card-body p-4">

                    <!-- Logo -->
                    <div class="text-center mb-4">
                        <img src="<?= base_url('assets/images/bolinao_logo.png'); ?>"
                            alt="Logo"
                            class="img-fluid"
                            style="max-width: 220px;">
                    </div>

                    <form method="post" action="<?= base_url('/register'); ?>">
                        <?= csrf_field() ?>

                        <div class="mb-2">
                            <label class="form-label">Username</label>
                            <input name="username" type="text" class="form-control" placeholder="Enter username" required>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Password</label>
                            <input name="password" type="password" class="form-control" placeholder="Enter password" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input name="confirm_password" type="password" class="form-control" placeholder="Re-enter password" required>
                        </div>

                        <!-- Register Button -->
                        <div class="d-grid mb-2">
                            <button type="submit"
                                class="btn w-100"
                                style="background-color: #108f23; color: #fff; border: 1px solid #108f23;"
                                onmouseover="this.style.backgroundColor='#0e7a1b'; this.style.borderColor='#0e7a1b';"
                                onmouseout="this.style.backgroundColor='#108f23'; this.style.borderColor='#108f23';">
                                Register
                            </button>

                            <?php if (session()->getFlashdata('error')): ?>
                                <div class="alert alert-danger mt-2">
                                    <?= session()->getFlashdata('error') ?>
                                </div>
                            <?php endif; ?>

                            <?php if (session()->getFlashdata('success')): ?>
                                <div class="alert alert-success mb-2">
                                    <?= session()->getFlashdata('success') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Divider -->
                        <div class="text-center mb-2">
                            <small class="text-muted">Already have an account?</small>
                        </div>

                        <!-- Login Button -->
                        <div class="d-grid">
                            <a href="<?= base_url('/'); ?>"
                                class="btn btn-outline-success w-100"
                                style="color: #16166c; border-color: #16166c;"
                                onmouseover="this.style.backgroundColor='#16166c'; this.style.color='#fff';"
                                onmouseout="this.style.backgroundColor=''; this.style.color='#16166c';">
                                Login
                            </a>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>