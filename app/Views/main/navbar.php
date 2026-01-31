<?php $path = service('uri')->getPath(); ?>

<nav class="navbar navbar-expand-lg navbar-dark shadow-sm sticky-top navbar-app">
    <div class="container-fluid px-3 px-lg-4">

        <!-- TOP ROW -->
        <div class="navbar-top">

            <!-- BRAND -->
            <a class="navbar-brand fw-bold text-white"
                href="<?= base_url('dashboard') ?>">

                <img src="<?= base_url('assets/images/bolinao_logo.png') ?>"
                    width="32" height="32" alt="Logo">

                <span class="brand-title">
                    Employee Data Tracking System
                </span>
            </a>

            <!-- TOGGLER -->
            <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

        </div>

        <!-- COLLAPSE -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2 pt-3 pt-lg-0">

                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 <?= ($path === '' || $path === 'dashboard') ? 'active' : '' ?>"
                        href="<?= base_url('dashboard') ?>">
                        <i class="bi bi-bar-chart-line-fill"></i>
                        Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 <?= ($path === 'search_records') ? 'active' : '' ?>"
                        href="<?= base_url('search_records') ?>">
                        <i class="bi bi-search"></i>
                        Search
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 <?= ($path === 'create') ? 'active' : '' ?>"
                        href="<?= base_url('create') ?>">
                        <i class="bi bi-pencil-square"></i>
                        Create
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 <?= ($path === 'register') ? 'active' : '' ?>"
                        href="<?= base_url('register') ?>">
                        <i class="bi bi-pencil-fill"></i>
                        Register
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 <?= ($path === 'change_password') ? 'active' : '' ?>"
                        href="<?= base_url('change_password') ?>">
                        <i class="bi bi-key-fill"></i>
                        Change Password
                    </a>
                </li>

                <li class="nav-item d-lg-none my-2">
                    <hr class="dropdown-divider">
                </li>

                <li class="nav-item">
                    <a class="btn btn-logout w-100 w-lg-auto text-white fw-semibold px-4 rounded-pill d-flex align-items-center justify-content-center gap-2"
                        href="<?= base_url('logout') ?>">
                        <i class="bi bi-box-arrow-left"></i>
                        Logout
                    </a>
                </li>

            </ul>
        </div>

    </div>
</nav>