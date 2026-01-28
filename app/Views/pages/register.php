<?= $this->extend('main/master'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid vh-100 d-flex justify-content-center align-items-center">
    <div class="col-11 col-sm-8 col-md-6 col-lg-5 col-xl-4">
        <div class="card shadow-lg rounded-4 position-relative">

            <!-- Back Button (Upper Left) -->
            <a href="<?= base_url('dashboard'); ?>"
               class="btn btn-light rounded-pill position-absolute"
               style="top: 15px; left: 15px;">
                <i class="bi bi-arrow-left"></i>
            </a>

            <!-- Header / Logo -->
            <div class="card-header text-center rounded-top-4 border-0 pt-4">
                <img src="<?= base_url('assets/images/bolinao_logo.png'); ?>"
                    alt="Logo"
                    class="img-fluid"
                    style="max-width: 180px; margin-bottom: 15px;">
            </div>

            <!-- Card Body -->
            <div class="card-body p-4">
                <form method="post" action="<?= base_url('/register'); ?>">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Username</label>
                        <input name="username" type="text" class="form-control form-control-lg" placeholder="Enter username" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Password</label>
                        <input name="password" type="password" class="form-control form-control-lg" placeholder="Enter password" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Confirm Password</label>
                        <input name="confirm_password" type="password" class="form-control form-control-lg" placeholder="Re-enter password" required>
                    </div>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger mt-2"><?= session()->getFlashdata('error') ?></div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success mt-2"><?= session()->getFlashdata('success') ?></div>
                    <?php endif; ?>

                    <!-- Register Button -->
                    <div class="d-grid">
                        <button type="submit"
                            class="btn btn-lg text-white fw-bold"
                            style="background-color: #108f23; border: 1px solid #108f23; transition: 0.3s;"
                            onmouseover="this.style.backgroundColor='#0e7a1b'; this.style.borderColor='#0e7a1b';"
                            onmouseout="this.style.backgroundColor='#108f23'; this.style.borderColor='#108f23';">
                            Register
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
