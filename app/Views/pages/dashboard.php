<?= $this->extend('main/master') ?>
<?= $this->section('content') ?>
<?= $this->include('main/navbar'); ?>

<div class="container-fluid my-4 px-4">

    <!-- ===== DASHBOARD TITLE ===== -->
    <div class="mb-4 text-center">
        <h2 class="fw-bold text-white"><i class="bi bi-bar-chart-line-fill px-2 text-white"></i>Dashboard</h2>
        <hr>
    </div>

    <!-- ===== CARDS (2 per row) ===== -->
    <div class="row g-4"> 
        <!-- GENDER CARD -->
        <div class="col-md-6">
            <div class="card shadow rounded-4">
                <div class="card-header bg-primary text-white text-center fw-bold fs-5 rounded-top-4">
                    <i class="bi bi-gender-neuter px-2"></i>GENDER
                </div>
                <div class="card-body text-center">
                    <div class="row">
                        <div class="col">
                            <h6 class="fw-bold">MALE</h6>
                            <div class="bg-info text-white fs-3 fw-bold py-4 rounded">Total Employees: 10</div>
                        </div>
                        <div class="col">
                            <h6 class="fw-bold">FEMALE</h6>
                            <div class="text-white fs-2 fw-bold py-3 rounded" style="background:#ff1493;">Total Employees: 5</div>
                        </div>
                    </div>
                    <a href="#" class="d-block mt-3 fw-bold text-primary" data-bs-toggle="modal" data-bs-target="#genderModal">VIEW ALL</a>
                </div>
            </div>
        </div>

        <!-- ELIGIBILITY CARD -->
        <div class="col-md-6">
            <div class="card shadow rounded-4">
                <div class="card-header bg-primary text-white text-center fw-bold fs-5 rounded-top-4">
                    <i class="bi bi-card-checklist px-2"></i>
                    ELIGIBILITY
                </div>
                <div class="card-body text-center">
                    <div class="row">
                        <div class="col">
                            <h6 class="fw-bold">PRO</h6>
                            <div class="bg-info text-white fs-4 fw-bold py-4 rounded">10</div>
                        </div>
                        <div class="col">
                            <h6 class="fw-bold">NONPRO</h6>
                            <div class="bg-info text-white fs-4 fw-bold py-4 rounded">10</div>
                        </div>
                        <div class="col">
                            <h6 class="fw-bold">PRC</h6>
                            <div class="bg-info text-white fs-4 fw-bold py-4 rounded">10</div>
                        </div>
                        <div class="col">
                            <h6 class="fw-bold">NON</h6>
                            <div class="bg-info text-white fs-4 fw-bold py-4 rounded">10</div>
                        </div>
                    </div>
                    <a href="#" class="d-block mt-3 fw-bold text-primary" data-bs-toggle="modal" data-bs-target="#eligibilityModal">VIEW ALL</a>
                </div>
            </div>
        </div>

        <!-- AGE CARD -->
        <div class="col-md-6">
            <div class="card shadow rounded-4">
                <div class="card-header bg-primary text-white text-center fw-bold fs-5 rounded-top-4">
                    <i class="bi bi-calendar-date px-2"></i>
                    AGE
                </div>
                <div class="card-body text-center">
                    <div class="row row-cols-5 g-2">
                        <?php foreach (['18-30', '31-40', '41-50', '51-60', '60+'] as $age): ?>
                            <div class="col">
                                <small class="fw-bold"><?= $age ?></small>
                                <div class="bg-info text-white fw-bold py-4 rounded">10</div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <a href="#" class="d-block mt-3 fw-bold text-primary" data-bs-toggle="modal" data-bs-target="#ageModal">VIEW ALL</a>
                </div>
            </div>
        </div>

        <!-- EDUCATION CARD -->
        <div class="col-md-6">
            <div class="card shadow rounded-4">
                <div class="card-header bg-primary text-white text-center fw-bold fs-5 rounded-top-4">
                    <i class="bi bi-book px-2"></i>
                    EDUCATIONAL ATTAINMENT
                </div>
                <div class="card-body text-center">
                    <div class="row row-cols-5 g-2">
                        <?php foreach (['ELEM', 'HS', 'COLLEGE', 'VOC', 'GRAD'] as $edu): ?>
                            <div class="col">
                                <small class="fw-bold"><?= $edu ?></small>
                                <div class="bg-info text-white fw-bold py-4 rounded">10</div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <a href="#" class="d-block mt-3 fw-bold text-primary" data-bs-toggle="modal" data-bs-target="#educationModal">VIEW ALL</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ===== MODALS ===== -->

<!-- Gender Modal -->
<div class="modal fade" id="genderModal" tabindex="-1" aria-labelledby="genderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 80vw;">
        <div class="modal-content rounded-4">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="genderModalLabel">Gender Records</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <!-- Filter and Search -->
                <div class="d-flex justify-content-end mb-3 gap-2">
                    <!-- Gender Filter -->
                    <div>
                        <label for="genderFilter" class="form-label fw-bold me-2">Filter Gender:</label>
                        <select id="genderFilter" class="form-select w-auto d-inline-block">
                            <option value="All" selected>All</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>

                    <!-- Search Bar -->
                    <div>
                        <label for="genderSearch" class="form-label fw-bold me-2">Search:</label>
                        <input type="text" id="genderSearch" class="form-control w-auto d-inline-block" placeholder="Search...">
                    </div>
                </div>

                <!-- Table -->
                <table class="table table-bordered table-striped text-center" id="genderTable">
                    <thead class="table-primary">
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
                                    <td><?= esc($rec['last_name']) ?></td>
                                    <td><?= esc($rec['first_name']) ?></td>
                                    <td><?= esc($rec['middle_name']) ?></td>
                                    <td><?= esc($rec['ext']) ?></td>
                                    <td><?= esc($rec['department']) ?></td>
                                    <td><?= esc($rec['designation']) ?></td>
                                    <td><?= esc($rec['gender']) ?></td>
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
                <button class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- Eligibility Modal -->
<div class="modal fade" id="eligibilityModal" tabindex="-1" aria-labelledby="eligibilityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 80vw;">
        <div class="modal-content rounded-4">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="eligibilityModalLabel">Eligibility Records</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <!-- Filter and Search -->
                <div class="d-flex justify-content-end mb-3 gap-2">
                    <!-- Eligibility Filter -->
                    <div>
                        <label for="eligibilityFilter" class="form-label fw-bold me-2">Filter Eligibility:</label>
                        <select id="eligibilityFilter" class="form-select w-auto d-inline-block">
                            <option value="All" selected>All</option>
                            <option value="PRO">PRO</option>
                            <option value="NONPRO">NONPRO</option>
                            <option value="PRC">PRC</option>
                            <option value="NON">NON</option>
                        </select>
                    </div>

                    <!-- Search Bar -->
                    <div>
                        <label for="eligibilitySearch" class="form-label fw-bold me-2">Search:</label>
                        <input type="text" id="eligibilitySearch" class="form-control w-auto d-inline-block" placeholder="Search...">
                    </div>
                </div>

                <!-- Table -->
                <table class="table table-bordered table-striped text-center" id="eligibilityTable">
                    <thead class="table-primary">
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
                                    <td><?= esc($rec['last_name']) ?></td>
                                    <td><?= esc($rec['first_name']) ?></td>
                                    <td><?= esc($rec['middle_name']) ?></td>
                                    <td><?= esc($rec['ext']) ?></td>
                                    <td><?= esc($rec['department']) ?></td>
                                    <td><?= esc($rec['designation']) ?></td>
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
                <button class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Age Modal -->
<div class="modal fade" id="ageModal" tabindex="-1" aria-labelledby="ageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 80vw;">
        <div class="modal-content rounded-4">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="ageModalLabel">Age Records</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <!-- Filter and Search -->
                <div class="d-flex justify-content-end mb-3 gap-2">
                    <!-- Age Filter -->
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

                    <!-- Search Bar -->
                    <div>
                        <label for="ageSearch" class="form-label fw-bold me-2">Search:</label>
                        <input type="text" id="ageSearch" class="form-control w-auto d-inline-block" placeholder="Search...">
                    </div>
                </div>

                <!-- Table -->
                <table class="table table-bordered table-striped text-center" id="ageTable">
                    <thead class="table-primary">
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
                                    <td><?= esc($rec['last_name']) ?></td>
                                    <td><?= esc($rec['first_name']) ?></td>
                                    <td><?= esc($rec['middle_name']) ?></td>
                                    <td><?= esc($rec['ext']) ?></td>
                                    <td><?= esc($rec['department']) ?></td>
                                    <td><?= esc($rec['designation']) ?></td>
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
                <button class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Education Modal -->
<div class="modal fade" id="educationModal" tabindex="-1" aria-labelledby="educationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 80vw;">
        <div class="modal-content rounded-4">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="educationModalLabel">Educational Attainment Records</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <!-- Filter and Search -->
                <div class="d-flex justify-content-end mb-3 gap-2">
                    <!-- Education Filter -->
                    <div>
                        <label for="educationFilter" class="form-label fw-bold me-2">Filter Education:</label>
                        <select id="educationFilter" class="form-select w-auto d-inline-block">
                            <option value="All" selected>All</option>
                            <option value="ELEM">ELEM</option>
                            <option value="HS">HS</option>
                            <option value="COLLEGE">COLLEGE</option>
                            <option value="VOC">VOC</option>
                            <option value="GRAD">GRAD</option>
                        </select>
                    </div>

                    <!-- Search Bar -->
                    <div>
                        <label for="educationSearch" class="form-label fw-bold me-2">Search:</label>
                        <input type="text" id="educationSearch" class="form-control w-auto d-inline-block" placeholder="Search...">
                    </div>
                </div>

                <!-- Table -->
                <table class="table table-bordered table-striped text-center" id="educationTable">
                    <thead class="table-primary">
                        <tr>
                            <th>Last Name</th>
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>Ext</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <th>Educational Attainment</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($education_records)): ?>
                            <?php foreach ($education_records as $rec): ?>
                                <tr>
                                    <td><?= esc($rec['last_name']) ?></td>
                                    <td><?= esc($rec['first_name']) ?></td>
                                    <td><?= esc($rec['middle_name']) ?></td>
                                    <td><?= esc($rec['ext']) ?></td>
                                    <td><?= esc($rec['department']) ?></td>
                                    <td><?= esc($rec['designation']) ?></td>
                                    <td><?= esc($rec['education']) ?></td>
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
                <button class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- JS Search and Filters -->
<script src="<?= base_url('js/gender_search.js') ?>"></script>
<script src="<?= base_url('js/eligibility_search.js') ?>"></script>
<script src="<?= base_url('js/age_search.js') ?>"></script>
<script src="<?= base_url('js/educational_attainment.js') ?>"></script>

<?= $this->endSection(); ?>