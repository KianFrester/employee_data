<?= $this->extend('main/master') ?>
<?= $this->section('content') ?>
<?= $this->include('main/navbar') ?>

<div class="container-fluid my-4 px-4">

    <!-- ===== DASHBOARD TITLE ===== -->
    <div class="mb-4 text-center">
        <h2 class="fw-bold text-white">
            Hello <span style="color: #7CFC00;"><?= esc($username) ?></span>, welcome to Dashboard
        </h2>
        <hr style="border-color: #16166c;">
    </div>



    <!-- ===== CARDS (2 per row) ===== -->
    <div class="row g-4">


        <!-- GENDER CARD -->
        <div class="col-12 col-lg-6">
            <div class="card card-dash">
                <!-- Header -->
                <div class="card-dash-header px-4 py-3 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-3 d-flex align-items-center justify-content-center"
                            style="width:38px;height:38px;background:rgba(13,110,253,.15);">
                            <span class="text-primary fw-bold">👤</span>
                        </div>
                        <div>
                            <div class="fw-bold text-uppercase text-secondary small mb-0">Gender</div>
                            <div class="text-secondary" style="font-size:12px;">Employee breakdown</div>
                        </div>
                    </div>

                    <a class="btn btn-outline-primary btn-sm rounded-pill fw-semibold"
                        href="#"
                        data-bs-toggle="modal"
                        data-bs-target="#genderModal">
                        View Details →
                    </a>
                </div>

                <!-- Body -->
                <div class="card-body px-4 py-4">
                    <div class="row g-3">

                        <!-- Male -->
                        <div class="col-12 col-md-6">
                            <div class="stat-tile d-flex gap-3 align-items-start">
                                <div class="rounded-4 bg-primary bg-opacity-10 d-flex align-items-center justify-content-center"
                                    style="width:46px;height:46px;">
                                    <span class="text-primary fw-bold">👤</span>
                                </div>
                                <div>
                                    <div class="text-uppercase text-secondary small fw-semibold">Male</div>
                                    <div class="fw-bold" style="font-size:40px; line-height:1;"><?= esc($maleCount) ?></div>
                                    <div class="text-secondary small">Employees</div>
                                </div>
                            </div>
                        </div>

                        <!-- Female -->
                        <div class="col-12 col-md-6">
                            <div class="stat-tile d-flex gap-3 align-items-start">
                                <div class="rounded-4 bg-danger bg-opacity-10 d-flex align-items-center justify-content-center"
                                    style="width:46px;height:46px;">
                                    <span class="text-danger fw-bold">👤</span>
                                </div>
                                <div>
                                    <div class="text-uppercase text-secondary small fw-semibold">Female</div>
                                    <div class="fw-bold" style="font-size:40px; line-height:1;"><?= esc($femaleCount) ?></div>
                                    <div class="text-secondary small">Employees</div>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>
            </div>
        </div>

        <!-- ELIGIBILITY CARD -->
        <div class="col-12 col-lg-6">
            <div class="card card-dash">
                <!-- Header -->
                <div class="card-dash-header px-4 py-3 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-3 d-flex align-items-center justify-content-center"
                            style="width:38px;height:38px;background:rgba(13,110,253,.15);">
                            <i class="bi bi-card-checklist text-primary"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-uppercase text-secondary small mb-0">Eligibility</div>
                            <div class="text-secondary" style="font-size:12px;">Employee categories</div>
                        </div>
                    </div>

                    <a class="btn btn-outline-primary btn-sm rounded-pill fw-semibold"
                        href="#"
                        data-bs-toggle="modal"
                        data-bs-target="#eligibilityModal">
                        View Details →
                    </a>
                </div>

                <!-- Body -->
                <div class="card-body px-4 py-4">
                    <div class="row g-3">
                        <?php foreach ($eligibility_counts as $label => $value): ?>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="stat-tile d-flex gap-3 align-items-start">
                                    <div class="rounded-4 bg-primary bg-opacity-10 d-flex align-items-center justify-content-center"
                                        style="width:46px;height:46px;">
                                        <span class="text-primary fw-bold"><?= esc(substr($label, 0, 1)) ?></span>
                                    </div>

                                    <div>
                                        <div class="text-uppercase text-secondary small fw-semibold"><?= esc($label) ?></div>
                                        <div class="fw-bold" style="font-size:34px; line-height:1;"><?= esc($value) ?></div>
                                        <div class="text-secondary small">Qualified</div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>


        <!-- AGE CARD -->
        <div class="col-12 col-lg-6">
            <div class="card card-dash">
                <!-- Header -->
                <div class="card-dash-header px-4 py-3 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-3 d-flex align-items-center justify-content-center"
                            style="width:38px;height:38px;background:rgba(13,110,253,.15);">
                            <i class="bi bi-calendar-date text-primary"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-uppercase text-secondary small mb-0">Age</div>
                            <div class="text-secondary" style="font-size:12px;">Age distribution</div>
                        </div>
                    </div>

                    <a class="btn btn-outline-primary btn-sm rounded-pill fw-semibold"
                        href="#"
                        data-bs-toggle="modal"
                        data-bs-target="#ageModal">
                        View Details →
                    </a>
                </div>

                <!-- Body -->
                <div class="card-body px-4 py-4">
                    <div class="row g-3">
                        <?php foreach ($ageGroups as $age => $count): ?>
                            <div class="col-12 col-md-4 col-lg">
                                <div class="stat-tile text-center">
                                    <div class="text-uppercase text-secondary small fw-semibold mb-2"><?= esc($age) ?></div>
                                    <div class="fw-bold" style="font-size:34px; line-height:1;">
                                        <?= esc($count) ?>
                                    </div>
                                    <div class="text-secondary small mt-1">People</div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>


        <!-- EDUCATION CARD -->
        <div class="col-12 col-lg-6">
            <div class="card card-dash">
                <!-- Header -->
                <div class="card-dash-header px-4 py-3 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-3 d-flex align-items-center justify-content-center"
                            style="width:38px;height:38px;background:rgba(13,110,253,.15);">
                            <i class="bi bi-book text-primary"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-uppercase text-secondary small mb-0">Educational Attainment</div>
                            <div class="text-secondary" style="font-size:12px;">Highest level achieved</div>
                        </div>
                    </div>

                    <a class="btn btn-outline-primary btn-sm rounded-pill fw-semibold"
                        href="#"
                        data-bs-toggle="modal"
                        data-bs-target="#educationModal">
                        View Details →
                    </a>
                </div>

                <!-- Body -->
                <div class="card-body px-4 py-4">
                    <div class="row g-3">
                        <?php foreach (['ELEM', 'HS', 'COLLEGE', 'VOC', 'GRAD'] as $edu): ?>
                            <div class="col-12 col-md-4 col-lg">
                                <div class="stat-tile text-center">
                                    <div class="text-uppercase text-secondary small fw-semibold mb-2"><?= esc($edu) ?></div>
                                    <div class="fw-bold" style="font-size:34px; line-height:1;">10</div>
                                    <div class="text-secondary small mt-1">People</div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="card card-dash">
                <div class="card-dash-header px-4 py-3 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-3 d-flex align-items-center justify-content-center"
                            style="width:38px;height:38px;background:rgba(13,110,253,.15);">
                            <i class="bi bi-briefcase text-primary"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-uppercase text-secondary small mb-0">Employment Status</div>
                            <div class="text-secondary" style="font-size:12px;">Current employment status</div>
                        </div>
                    </div>

                    <a class="btn btn-outline-primary btn-sm rounded-pill fw-semibold"
                        href="#"
                        data-bs-toggle="modal"
                        data-bs-target="#employmentModal">
                        View Details →
                    </a>
                </div>

                <div class="card-body px-4 py-4">
                    <div class="row g-3">
                        <?php foreach (['Employed', 'Unemployed', 'Retired'] as $emp): ?>
                            <div class="col-12 col-md-4 col-lg">
                                <div class="stat-tile text-center">
                                    <div class="text-uppercase text-secondary small fw-semibold mb-2"><?= esc($emp) ?></div>
                                    <div class="fw-bold" style="font-size:34px; line-height:1;">10</div>
                                    <div class="text-secondary small mt-1">People</div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>


        <!-- ===== MODALS ===== -->

        <!-- Gender Modal -->
        <div class="modal fade" id="genderModal" tabindex="-1" aria-labelledby="genderModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 80vw;">
                <div class="modal-content rounded-4 shadow">

                    <!-- HEADER -->
                    <div class="modal-header text-white" style="background-color:#16166c;">
                        <h5 class="modal-title fw-bold" id="genderModalLabel">
                            <i class="bi bi-gender-ambiguous me-2"></i>Gender Records
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- BODY -->
                    <div class="modal-body">

                        <!-- FILTERS -->
                        <div class="d-flex justify-content-end mb-3 gap-3 flex-wrap">

                            <div>
                                <label class="form-label fw-bold me-2">Filter Gender:</label>
                                <select id="genderFilter" class="form-select d-inline-block w-auto">
                                    <option value="All" selected>All</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>

                            <div>
                                <label class="form-label fw-bold me-2">Search:</label>
                                <input type="text" id="genderSearch" class="form-control d-inline-block w-auto" placeholder="Search...">
                            </div>

                        </div>

                        <!-- TABLE -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle text-center" id="genderTable">

                                <thead style="background-color:#16166c; color:#fff;">
                                    <tr>
                                        <th>Last Name</th>
                                        <th>First Name</th>
                                        <th>Middle Name</th>
                                        <th>Ext</th>
                                        <th>Department</th>
                                        <th>Designation</th>
                                        <th>Gender</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php if (!empty($gender_records)): ?>
                                        <?php foreach ($gender_records as $rec): ?>
                                            <tr>
                                                <td><?= esc($rec['last_name'] ?? '') ?></td>
                                                <td><?= esc($rec['first_name'] ?? '') ?></td>
                                                <td><?= esc($rec['middle_name'] ?? '') ?></td>
                                                <td><?= esc($rec['extensions'] ?? '') ?></td>

                                                <!-- 🔥 MULTIPLE SERVICE RECORDS (HTML ALLOWED) -->
                                                <td><?= $rec['department'] ?? '' ?></td>
                                                <td><?= $rec['designation'] ?? '' ?></td>

                                                <td><?= esc($rec['gender'] ?? '') ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-muted">No records found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>

                            </table>
                        </div>
                    </div>

                    <!-- FOOTER -->
                    <div class="modal-footer">
                        <button class="btn btn-success rounded-pill" id="printGenderTable">
                            <i class="bi bi-printer me-1"></i>Print
                        </button>
                        <button class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">
                            Close
                        </button>
                    </div>

                </div>
            </div>
        </div>


        <!-- Eligibility Modal -->
        <div class="modal fade" id="eligibilityModal" tabindex="-1" aria-labelledby="eligibilityModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 80vw;">
                <div class="modal-content rounded-4">
                    <div class="modal-header text-white" style="background-color: #16166c;">
                        <h5 class="modal-title fw-bold" id="eligibilityModalLabel">Eligibility Records</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex justify-content-end mb-3 gap-2">
                            <div>
                                <label for="eligibilityFilter" class="form-label fw-bold me-2">Filter Eligibility:</label>
                                <select id="eligibilityFilter" class="form-select w-auto d-inline-block">
                                    <option value="All" selected>All</option>
                                    <option value="PRO">PRO</option>
                                    <option value="NON PRO">NON PRO</option>
                                    <option value="PRC">PRC</option>
                                    <option value="NON">NON</option>
                                </select>
                            </div>
                            <div>
                                <label for="eligibilitySearch" class="form-label fw-bold me-2">Search:</label>
                                <input type="text" id="eligibilitySearch" class="form-control w-auto d-inline-block" placeholder="Search...">
                            </div>
                        </div>
                        <table class="table table-bordered table-striped text-center" id="eligibilityTable">
                            <thead style="background-color: #16166c; color: #fff;">
                                <tr>
                                    <th>Last Name</th>
                                    <th>First Name</th>
                                    <th>Middle Name</th>
                                    <th>Ext</th>
                                    <th>Department</th>
                                    <th>Designation</th>
                                    <th>Eligibility</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($eligibility_records)): ?>
                                    <?php foreach ($eligibility_records as $rec): ?>
                                        <tr>
                                            <td><?= esc($rec['last_name'] ?? '') ?></td>
                                            <td><?= esc($rec['first_name'] ?? '') ?></td>
                                            <td><?= esc($rec['middle_name'] ?? '') ?></td>
                                            <td><?= esc($rec['extensions'] ?? '') ?></td>

                                            <!-- 🔥 MULTIPLE SERVICE RECORDS (HTML ALLOWED) -->
                                            <td><?= $rec['department'] ?? '' ?></td>
                                            <td><?= $rec['designation'] ?? '' ?></td>
                                            <td><?= esc($rec['eligibility']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7">No records found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-success rounded-pill" id="printEligibilityTable">Print</button>
                        <button class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Age Modal -->

        <div class="modal fade" id="ageModal" tabindex="-1" aria-labelledby="ageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 80vw;">
                <div class="modal-content rounded-4">
                    <div class="modal-header text-white" style="background-color: #16166c;">
                        <h5 class="modal-title fw-bold" id="ageModalLabel">Age Records</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex justify-content-end mb-3 gap-2">
                            <div>
                                <label for="ageFilter" class="form-label fw-bold me-2">Filter Age:</label>
                                <select id="ageFilter" class="form-select w-auto d-inline-block">
                                    <option value="All" selected>All</option>
                                    <option value="18-30">18-30</option>
                                    <option value="31-40">31-40</option>
                                    <option value="41-50">41-50</option>
                                    <option value="51-60">51-60</option>
                                    <option value="60+">60+</option>
                                </select>
                            </div>
                            <div>
                                <label for="ageSearch" class="form-label fw-bold me-2">Search:</label>
                                <input type="text" id="ageSearch" class="form-control w-auto d-inline-block" placeholder="Search...">
                            </div>
                        </div>
                        <table class="table table-bordered table-striped text-center" id="ageTable">
                            <thead style="background-color: #16166c; color: #fff;">
                                <tr>
                                    <th>Last Name</th>
                                    <th>First Name</th>
                                    <th>Middle Name</th>
                                    <th>Ext</th>
                                    <th>Department</th>
                                    <th>Designation</th>
                                    <th>Age</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($age_records)): ?>
                                    <?php foreach ($age_records as $rec): ?>
                                        <tr>
                                            <td><?= esc($rec['last_name'] ?? '') ?></td>
                                            <td><?= esc($rec['first_name'] ?? '') ?></td>
                                            <td><?= esc($rec['middle_name'] ?? '') ?></td>
                                            <td><?= esc($rec['extensions'] ?? '') ?></td>

                                            <!-- 🔥 MULTIPLE SERVICE RECORDS (HTML ALLOWED) -->
                                            <td><?= $rec['department'] ?? '' ?></td>
                                            <td><?= $rec['designation'] ?? '' ?></td>

                                            <!-- age count -->
                                            <td><?= esc($rec['age']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7">No records found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success rounded-pill" id="printEducationalAttainmentTable">
                            <i class="bi bi-printer me-1"></i>Print
                        </button>
                        <button class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Education Modal -->
        <div class="modal fade" id="educationModal" tabindex="-1" aria-labelledby="educationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 80vw;">
                <div class="modal-content rounded-4">
                    <div class="modal-header text-white" style="background-color: #16166c;">
                        <h5 class="modal-title fw-bold" id="educationModalLabel">Educational Attainment Records</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex justify-content-end mb-3 gap-2">
                            <div>
                                <label for="educationFilter" class="form-label fw-bold me-2">Filter Education:</label>
                                <select id="educationFilter" class="form-select w-auto d-inline-block">
                                    <option value="All" selected>All</option>
                                    <option value="ELEM">ELEMENTARY</option>
                                    <option value="HS">HIGH SCHOOL</option>
                                    <option value="COLLEGE">COLLEGE</option>
                                    <option value="VOC">VOCATIONAL</option>
                                    <option value="GRAD">GRADUATE</option>
                                </select>
                            </div>
                            <div>
                                <label for="educationSearch" class="form-label fw-bold me-2">Search:</label>
                                <input type="text" id="educationSearch" class="form-control w-auto d-inline-block" placeholder="Search...">
                            </div>
                        </div>
                        <table class="table table-bordered table-striped text-center" id="educationTable">
                            <thead style="background-color: #16166c; color: #fff;">
                                <tr>
                                    <th>Last Name</th>
                                    <th>First Name</th>
                                    <th>Middle Name</th>
                                    <th>Extensions</th>
                                    <th>Department</th>
                                    <th>Designation</th>
                                    <th>Educational Attainment</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($education_records)): ?>
                                    <?php foreach ($education_records as $rec): ?>
                                        <tr>
                                            <td><?= esc($rec['last_name'] ?? '') ?></td>
                                            <td><?= esc($rec['first_name'] ?? '') ?></td>
                                            <td><?= esc($rec['middle_name'] ?? '') ?></td>
                                            <td><?= esc($rec['extensions'] ?? '') ?></td>

                                            <!-- 🔥 MULTIPLE SERVICE RECORDS (HTML ALLOWED) -->
                                            <td><?= $rec['department'] ?? '' ?></td>
                                            <td><?= $rec['designation'] ?? '' ?></td>

                                            <td><?= esc($rec['educational_attainment']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7">No records found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success rounded-pill" id="printAgeTable">
                            <i class="bi bi-printer me-1"></i>Print
                        </button>
                        <button class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ========================= -->
        <!-- EMPLOYMENT STATUS MODAL -->
        <!-- ========================= -->
        <div class="modal fade" id="employmentModal" tabindex="-1" aria-labelledby="employmentModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 80vw;">
                <div class="modal-content rounded-4">
                    <div class="modal-header text-white" style="background-color: #16166c;">
                        <h5 class="modal-title fw-bold" id="employmentModalLabel">Employment Status Records</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <!-- Filter + Search (same layout as education modal) -->
                        <div class="d-flex justify-content-end mb-3 gap-2">
                            <div>
                                <label for="employmentFilter" class="form-label fw-bold me-2">Filter Status:</label>
                                <select id="employmentFilter" class="form-select w-auto d-inline-block">
                                    <option value="All" selected>All</option>
                                    <option value="Employed">Employed</option>
                                    <option value="Unemployed">Unemployed</option>
                                    <option value="Retired">Retired</option>
                                </select>
                            </div>

                            <div>
                                <label for="employmentSearch" class="form-label fw-bold me-2">Search:</label>
                                <input type="text" id="employmentSearch" class="form-control w-auto d-inline-block" placeholder="Search...">
                            </div>
                        </div>

                        <!-- Table -->
                        <table class="table table-bordered table-striped text-center" id="employmentTable">
                            <thead style="background-color: #16166c; color: #fff;">
                                <tr>
                                    <th>Last Name</th>
                                    <th>First Name</th>
                                    <th>Middle Name</th>
                                    <th>Ext</th>
                                    <th>Department</th>
                                    <th>Designation</th>
                                    <th>Employment Status</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php if (!empty($employment_records)): ?>
                                    <?php foreach ($employment_records as $rec): ?>
                                        <tr>
                                            <td><?= esc($rec['last_name'] ?? '') ?></td>
                                            <td><?= esc($rec['first_name'] ?? '') ?></td>
                                            <td><?= esc($rec['middle_name'] ?? '') ?></td>
                                            <td><?= esc($rec['extensions'] ?? '') ?></td>

                                            <!-- allow HTML if your department/designation contains multiple records -->
                                            <td><?= $rec['department'] ?? '' ?></td>
                                            <td><?= $rec['designation'] ?? '' ?></td>

                                            <td><?= esc($rec['employment_status'] ?? '') ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7">No records found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-success rounded-pill" id="printEmploymentTable">
                            <i class="bi bi-printer me-1"></i>Print
                        </button>
                        <button class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>


        <!-- JS Search and Filters -->
        <script src="<?= base_url('js/gender_search.js') ?>"></script>
        <script src="<?= base_url('js/eligibility_search.js') ?>"></script>
        <script src="<?= base_url('js/age_search.js') ?>"></script>
        <script src="<?= base_url('js/educational_attainment.js') ?>"></script>
        <script src="<?= base_url('js/dashboard_gender_modal.js') ?>"></script>
        <script src="<?= base_url('js/print_gender_table.js') ?>"></script>
        <script src="<?= base_url('js/print_eligibility_table.js') ?>"></script>
        <script src="<?= base_url('js/print_age_table.js') ?>"></script>
        <script src="<?= base_url('js/print_educational_attainment_table.js') ?>"></script>
        <script src="<?= base_url('js/print_employment_status_table.js') ?>"></script>

        <?= $this->endSection(); ?>