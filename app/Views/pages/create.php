<?= $this->extend('main/master') ?>
<?= $this->section('content') ?>
<?= $this->include('main/navbar') ?>

<div class="container-fluid py-4 px-4">

    <!-- Page Title (same style as dashboard page) -->
    <div class="text-center mb-4">
        <h2 class="fw-bold text-white">
            <i class="bi bi-person-plus-fill me-2"></i> Add Record
        </h2>
        <p class="text-white-50 mb-0">Enter employee details below.</p>
        <hr class="border-white opacity-25">
    </div>

    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">

            <div class="form-card">

                <!-- Soft Header (dashboard style) -->
                <div class="form-card-header px-4 py-3 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-3 d-flex align-items-center justify-content-center"
                            style="width:38px;height:38px;background:rgba(13,110,253,.15);">
                            <i class="bi bi-clipboard2-plus-fill text-primary"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-uppercase text-secondary small mb-0">Employee Information</div>
                            <div class="text-secondary" style="font-size:12px;">Add a new employee record</div>
                        </div>
                    </div>

                    <a href="<?= base_url('dashboard') ?>" class="btn btn-outline-primary btn-sm rounded-pill fw-semibold">
                        Back →
                    </a>
                </div>

                <!-- Body -->
                <div class="p-4">
                    <form method="post" action="<?= site_url('save-record') ?>">
                        <?= csrf_field() ?>

                        <!-- Row 1 -->
                        <div class="row g-3">
                            <div class="col-12 col-md-3">
                                <label class="form-label-soft">First Name</label>
                                <input type="text" name="first_name" class="form-control form-modern" placeholder="First name" required>
                            </div>

                            <div class="col-12 col-md-3">
                                <label class="form-label-soft">Middle Name</label>
                                <input type="text" name="middle_name" class="form-control form-modern" placeholder="Middle name">
                            </div>

                            <div class="col-12 col-md-3">
                                <label class="form-label-soft">Last Name</label>
                                <input type="text" name="last_name" class="form-control form-modern" placeholder="Last name" required>
                            </div>

                            <div class="col-12 col-md-3">
                                <label class="form-label-soft">Ext.</label>
                                <input type="text" name="ext" class="form-control form-modern" placeholder="Jr, Sr, III">
                            </div>
                        </div>

                        <!-- Row 2 -->
                        <div class="row g-3 mt-1">
                            <div class="col-12 col-md-4">
                                <label class="form-label-soft">Birthdate</label>
                                <input type="date" name="birthdate" class="form-control form-modern" required>
                            </div>

                            <div class="col-12 col-md-4">
                                <label class="form-label-soft">Gender</label>
                                <select name="gender" class="form-select form-modern" required>
                                    <option value="" selected disabled>Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>

                            <div class="col-12 col-md-4">
                                <label class="form-label-soft">Rate</label>
                                <input type="text" name="rate" class="form-control form-modern" placeholder="Rate">
                            </div>
                        </div>

                        <!-- Row 3 -->
                        <div class="row g-3 mt-1">
                            <div class="col-12 col-md-6">
                                <label class="form-label-soft">Department</label>
                                <input type="text" name="department" class="form-control form-modern" placeholder="Department" required>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label-soft">Designation</label>
                                <input type="text" name="designation" class="form-control form-modern" placeholder="Designation" required>
                            </div>
                        </div>

                        <!-- Row 4 -->
                        <div class="row g-3 mt-1">
                            <div class="col-12 col-md-6">
                                <label class="form-label-soft">Educational Attainment</label>
                                <input type="text" name="department" class="form-control form-modern" placeholder="Education" required>
                            </div>


                            <div class="col-12 col-md-6">
                                <label class="form-label-soft">Eligibility</label>
                                <input type="text" name="eligibility" class="form-control form-modern" placeholder="Eligibility">
                            </div>
                        </div>

                        <!-- Row 5 -->
                        <div class="row g-3 mt-1">
                            <div class="col-12 col-md-6">
                                <label class="form-label-soft">Date of Appointment</label>
                                <input type="date" name="date_appointment" class="form-control form-modern">
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label-soft">Service Duration</label>
                                <input type="text" name="service_duration" class="form-control form-modern" placeholder="e.g., 3 years">
                            </div>
                        </div>

                        <!-- Remarks -->
                        <div class="mt-3">
                            <label class="form-label-soft">Remarks</label>
                            <textarea name="remarks" rows="6" class="form-control form-modern" placeholder="Write remarks..."></textarea>
                        </div>

                        <!-- Buttons (dashboard style: right side) -->
                        <div class="d-flex gap-2 justify-content-end mt-4">
                            <button type="reset" class="btn btn-light btn-pill">Clear</button>
                            <button type="submit" class="btn btn-primary btn-pill">
                                <i class="bi bi-check2-circle me-1"></i> Submit
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>

</div>

<?= $this->endSection() ?>