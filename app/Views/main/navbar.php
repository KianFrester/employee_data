<?= $this->extend('main/master'); ?>
<?= $this->section('content'); ?>

<nav class="navbar navbar-expand-lg shadow-sm py-3" style="background-color: #16166c;">
    <div class="container-fluid px-4">

        <!-- Brand -->
        <a class="navbar-brand d-flex align-items-center gap-2 fw-bold text-white"
            href="<?= base_url('dashboard') ?>">
            <img src="<?= base_url('assets/images/bolinao_logo.png') ?>"
                width="32" height="32"
                alt="Logo">
            Employee Data Tracking System
        </a>

        <!-- Mobile toggle -->
        <button class="navbar-toggler border-0" type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
        </button>

        <!-- Links -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3 mt-3 mt-lg-0">

                <li class="nav-item">
                    <a class="nav-link text-white fw-semibold px-3 d-flex align-items-center gap-2"
                        href="<?= base_url('dashboard') ?>">
                        <i class="bi bi-bar-chart-line-fill"></i>
                        Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white fw-semibold px-3 d-flex align-items-center gap-2"
                        href="<?= base_url('search') ?>">
                        <i class="bi bi-search"></i>
                        Search
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white fw-semibold px-3"
                        href="<?= base_url('create') ?>">
                        <i class="bi bi-pencil-square"></i>
                        Create
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white fw-semibold px-3"
                        href="<?= base_url('register') ?>">
                        <i class="bi bi-pencil-fill"></i>
                        Register
                    </a>
                </li>

                <!-- Logout Button -->
                <li class="nav-item">
                    <a class="btn text-white fw-semibold px-4 rounded-pill"
                        style="background-color: #ff4d4f; border: 1px solid #ff4d4f;"
                        href="<?= base_url('logout') ?>">
                        <i class="bi bi-box-arrow-left"></i>
                        Logout
                    </a>
                </li>

            </ul>
        </div>

    </div>
</nav>

<?= $this->endSection(); ?>
