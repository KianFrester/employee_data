<?php echo $this->extend('main/master'); ?>
<?php echo $this->section('content'); ?>


<head>
    <title>Home Page</title>
</head>

<div class="container">
    <div class="row justify-content-center align-items-center vh-100">
        <div class="col-11 col-sm-8 col-md-6 col-lg-5 col-xl-4">
            <div class="card shadow-lg">
                <div class="card-body p-4">

                    <!-- Logo -->
                    <div class="text-center mb-2">
                        <img src="<?= base_url('assets/images/bolinao_logo.png'); ?>"
                            alt="Logo"
                            class="img-fluid"
                            style="max-width: 250px;">
                    </div>

                    <form method="post" action="<?= base_url('/'); ?>">
                        <?= csrf_field() ?>
                        <div class="mb-2">
                            <label class="form-label">Username</label>
                            <input name="username" type="text" class="form-control" placeholder="Enter username" required>

                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input name="password" type="password" class="form-control" placeholder="Enter password" required>
                        </div>
                        <!-- <input type="text" name="isLoggedIn"> -->

                        <!-- Login Button -->
                        <div class="d-grid mb-2">
                            <button type="submit" class="btn w-100"
                                style="background-color: #16166c; color: #fff; border: 1px solid #16166c; transition: 0.3s;"
                                onmouseover="this.style.backgroundColor='#0f1255'; this.style.borderColor='#0f1255';"
                                onmouseout="this.style.backgroundColor='#16166c'; this.style.borderColor='#16166c';">
                                Login
                            </button>

                            <?php if (session()->getFlashdata('error')): ?>
                                <div class="alert alert-danger mt-2">
                                    <?= session()->getFlashdata('error') ?>
                                </div>
                            <?php endif; ?>

                        </div>


                        <!-- Divider -->
                        <div class="text-center my-2">
                            <small class="text-muted">Don’t have an account?</small>
                        </div>

                        <!-- Register Button -->
                        <div class="d-grid">
                            <a href="<?= base_url('register'); ?>"
                                class="btn w-100"
                                style="color: #198754; border: 1px solid #198754; background-color: transparent; transition: 0.3s;"
                                onmouseover="this.style.backgroundColor='#198754'; this.style.color='#fff';"
                                onmouseout="this.style.backgroundColor='transparent'; this.style.color='#198754';">
                                Register
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>