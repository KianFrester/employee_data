<?= $this->extend('main/master'); ?>
<?= $this->section('content'); ?>
<?= $this->include('main/navbar'); ?>

<div class="container-fluid my-5 px-4">

    <!-- Page Title -->
    <div class="text-center mb-4">
        <h2 class="fw-bold text-white"><i class="bi bi-search px-2"></i>Search Records</h2>
        <hr class="border-light">
    </div>

    <!-- Search & Filter -->
    <div class="row g-3 align-items-center mb-4 justify-content-center">

        <!-- Search Bar -->
        <div class="col-md-6">
            <div class="position-relative">
                <input
                    type="text"
                    id="tableSearch"
                    class="form-control form-control-lg rounded-pill shadow-sm pe-5"
                    placeholder="Search records...">
                <button
                    type="button"
                    id="clearSearch"
                    class="btn position-absolute top-50 end-0 translate-middle-y me-3 p-0 border-0 bg-transparent"
                    aria-label="Clear search">
                    <i class="bi bi-x-circle-fill text-secondary fs-5"></i>
                </button>
            </div>
        </div>

        <!-- Column Filter Dropdown -->
        <div class="col-12 col-md-4 col-lg-3 mb-3 mb-md-0">
            <div class="dropdown w-100">
                <button
                    class="btn btn-light btn-lg w-100 rounded-pill shadow-sm text-primary dropdown-toggle text-truncate"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                    style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    <i class="bi bi-funnel-fill text-primary me-2"></i>
                    Filter Columns
                </button>

                <ul class="dropdown-menu w-100 p-3 shadow rounded-4" style="max-height: 400px; overflow-y: auto;">
                    <?php
                    $columns = [
                        'Last Name',
                        'First Name',
                        'Middle Name',
                        'Extensions',
                        'Birthdate',
                        'Gender',
                        'Department',
                        'Educational Attainment',
                        'Designation',
                        'Rate',
                        'Eligibility',
                        'Date of Appointment',
                        'Service Duration',
                        'Remarks'
                    ];
                    foreach ($columns as $index => $col): ?>
                        <li class="mb-2">
                            <div class="form-check d-flex align-items-center">
                                <input class="form-check-input me-2 column-check" type="checkbox" value="<?= $index ?>" checked>
                                <label class="form-check-label flex-grow-1"><?= $col ?></label>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card shadow-lg rounded-4 w-100">
        <div class="card-header bg-primary text-white fw-bold d-flex justify-content-between align-items-center rounded-top-4">
            <span>Employee Records</span>
            <button class="btn btn-light btn-sm" onclick="printTable()" title="Print Table">
                <i class="bi bi-printer-fill text-primary"></i>
            </button>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center align-middle" id="searchTable">
                    <thead class="table-primary">
                        <tr>
                            <?php foreach ($columns as $col): ?>
                                <th><?= $col ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($records)): ?>
                            <?php foreach ($records as $rec): ?>
                                <tr>
                                    <td><?= esc($rec['last_name']) ?></td>
                                    <td><?= esc($rec['first_name']) ?></td>
                                    <td><?= esc($rec['middle_name']) ?></td>
                                    <td><?= esc($rec['extensions']) ?></td>
                                    <td><?= esc($rec['birthdate']) ?></td>
                                    <td><?= esc($rec['gender']) ?></td>
                                    <td><?= esc($rec['department']) ?></td>
                                    <td><?= esc($rec['educational_attainment']) ?></td>
                                    <td><?= esc($rec['designation']) ?></td>
                                    <td><?= esc($rec['rate']) ?></td>
                                    <td><?= esc($rec['eligibility']) ?></td>
                                    <td><?= esc($rec['date_of_appointment']) ?></td>
                                    <td><?= esc($rec['service_duration']) ?></td>
                                    <td><?= esc($rec['remarks']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="<?= count($columns) ?>">No records found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script src="<?= base_url('js/main_search.js') ?>"></script>
<script src="<?= base_url('js/print_table.js') ?>"></script>

<?= $this->endSection(); ?>