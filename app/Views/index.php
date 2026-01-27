<?= $this->extend('main/master'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid vh-100 d-flex justify-content-center align-items-center">
    <div class="col-11 col-sm-8 col-md-6 col-lg-5 col-xl-4">
        <div class="card shadow-lg rounded-4">
            <!-- Header / Logo -->
            <div class="card-header text-center rounded-top-4 border-0"> <!-- Remove border -->
                <img src="<?= base_url('assets/images/bolinao_logo.png'); ?>"
                    alt="Logo"
                    class="img-fluid"
                    style="max-width: 180px; margin-bottom: 15px;">
            </div>

            <!-- Card Body -->
            <div class="card-body p-4">
                <form method="post" action="<?= base_url('/'); ?>">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Username</label>
                        <input name="username" type="text" class="form-control form-control-lg" placeholder="Enter username" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Password</label>
                        <input name="password" type="password" class="form-control form-control-lg" placeholder="Enter password" required>
                    </div>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger mt-2"><?= session()->getFlashdata('error') ?></div>
                    <?php endif; ?>

                    <!-- Login Button -->
                    <div class="d-grid mb-3">
                        <button type="submit"
                            class="btn btn-lg text-white fw-bold"
                            style="background-color: #16166c; border: 1px solid #16166c; transition: 0.3s;"
                            onmouseover="this.style.backgroundColor='#0f1255'; this.style.borderColor='#0f1255';"
                            onmouseout="this.style.backgroundColor='#16166c'; this.style.borderColor='#16166c';">
                            Login
                        </button>
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>