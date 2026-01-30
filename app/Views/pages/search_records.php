<?= $this->extend('main/master'); ?>
<?= $this->section('content'); ?>
<?= $this->include('main/navbar'); ?>

<div class="container-fluid my-5 px-4">

    <!-- Page Title -->
    <div class="text-center mb-4">
        <h2 class="fw-bold text-white">
            <i class="bi bi-search px-2"></i>Search Records
        </h2>
        <hr class="border-white opacity-25">
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
                    aria-expanded="false">
                    <i class="bi bi-funnel-fill text-primary me-2"></i>
                    Filter Columns
                </button>

                <ul class="dropdown-menu w-100 p-3 shadow rounded-4" style="max-height: 400px; overflow-y: auto;">
                    <?php
                    $columns = [
                        'Full Name',
                        'Birthdate',
                        'Gender',
                        'Department',
                        'Educational Attainment',
                        'Designation',
                        'Rate',
                        'Eligibility',
                        'Date of Appointment',
                        'Status',
                        'Date Ended',
                        'Remarks',
                        'Actions'
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

    <?php if (session()->getFlashdata('error')): ?>
        <div class="form-card w-100 my-3 rounded-4 shadow-sm flash-message"
            style="background-color:#dc3545; color:white; border:none;">
            <div class="px-4 py-3 d-flex align-items-center justify-content-center gap-2">
                <div class="d-flex align-items-center justify-content-center"
                    style="width:32px; height:32px; background:rgba(255,255,255,0.3); border-radius:50%;">
                    <i class="bi bi-exclamation-circle-fill"></i>
                </div>
                <div class="fw-semibold text-center">
                    <?= session()->getFlashdata('error') ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="form-card w-100 my-3 rounded-4 shadow-sm flash-message"
            style="background-color:#198754; color:white; border:none;">
            <div class="px-4 py-3 d-flex align-items-center justify-content-center gap-2">
                <div class="d-flex align-items-center justify-content-center"
                    style="width:32px; height:32px; background:rgba(255,255,255,0.3); border-radius:50%;">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <div class="fw-semibold text-center">
                    <?= session()->getFlashdata('success') ?>
                </div>
            </div>
        </div>
    <?php endif; ?>




    <!-- ===== Dashboard-style Table Card ===== -->
    <div class="form-card w-100">
        <div class="section-divider"></div>

        <!-- Soft Header -->
        <div class="form-card-header px-4 py-3 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <div class="rounded-3 d-flex align-items-center justify-content-center"
                    style="width:38px;height:38px;background:rgba(13,110,253,.15);">
                    <i class="bi bi-people-fill text-primary"></i>
                </div>

                <div>
                    <div class="fw-bold text-uppercase text-secondary small mb-0">Employee Records</div>
                    <div class="text-secondary" style="font-size:12px;">Search and manage employee information</div>
                </div>
            </div>

            <button class="btn btn-outline-primary btn-sm rounded-pill fw-semibold" onclick="printTable()" title="Print Table">
                <i class="bi bi-printer-fill me-1"></i> Print
            </button>
        </div>
        <div class="section-divider"></div>

        <!-- Table Body -->
        <div class="p-4">
            <div class="table-responsive">

                <?php
                function renderMultiLines($value)
                {
                    // Normalize
                    if ($value === null) {
                        return '<div class="multi-line-item">Currently Working</div>';
                    }

                    $value = trim((string)$value);

                    if ($value === '' || $value === '0000-00-00') {
                        return '<div class="multi-line-item">Currently Working</div>';
                    }

                    // Split multi-line values
                    $parts = array_filter(array_map('trim', explode('||', $value)));

                    $out = '';

                    foreach ($parts as $p) {

                        // ✅ Convert zero-date to "Currently Working"
                        if ($p === '0000-00-00' || $p === '') {
                            $out .= '<div class="multi-line-item">Currently Working</div>';
                        } else {
                            $out .= '<div class="multi-line-item">' . esc($p) . '</div>';
                        }
                    }

                    return $out;
                }
                ?>

                <!-- for full name -->
                <?php
                function formatFullName($rec)
                {
                    $last  = trim($rec['last_name'] ?? '');
                    $first = trim($rec['first_name'] ?? '');
                    $middle = trim($rec['middle_name'] ?? '');
                    $ext   = trim($rec['extensions'] ?? '');

                    $name = $last;

                    if ($first !== '') {
                        $name .= ', ' . $first;
                    }

                    if ($middle !== '') {
                        $name .= ' ' . $middle;
                    }

                    if ($ext !== '') {
                        $name .= ' ' . $ext;
                    }

                    return esc($name);
                }
                ?>


                <table class="table table-modern align-middle text-center table-sm" id="searchTable" style="table-layout: fixed; width: 100%;">
                    <thead>
                        <tr>
                            <?php foreach ($columns as $col): ?>
                                <th class="text-truncate" style="max-width: 120px;"><?= $col ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($records)): ?>
                            <?php foreach ($records as $rec): ?>
                                <tr>

                                    <!-- ✅ FULL NAME -->
                                    <td class="text-truncate" style="max-width: 220px;">
                                        <?= formatFullName($rec) ?>
                                    </td>

                                    <td><?= esc($rec['birthdate']) ?></td>
                                    <td><?= esc($rec['gender']) ?></td>

                                    <td class="multi-cell">
                                        <?= renderMultiLines($rec['department'] ?? '') ?>
                                    </td>

                                    <td><?= esc($rec['educational_attainment']) ?></td>

                                    <td class="multi-cell">
                                        <?= renderMultiLines($rec['designation'] ?? '') ?>
                                    </td>

                                    <td class="multi-cell">
                                        <?= renderMultiLines($rec['rate'] ?? '') ?>
                                    </td>

                                    <td><?= esc($rec['eligibility']) ?></td>

                                    <td class="multi-cell">
                                        <?= renderMultiLines($rec['date_of_appointment'] ?? '') ?>
                                    </td>

                                    <td class="multi-cell">
                                        <?= renderMultiLines($rec['status'] ?? '') ?>
                                    </td>

                                    <td class="multi-cell">
                                        <?= renderMultiLines($rec['date_ended'] ?? '') ?>
                                    </td>

                                    <td><?= esc($rec['remarks']) ?></td>

                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <button
                                                class="btn btn-sm btn-primary btn-pill"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editModal"
                                                onclick="openEditModal(<?= htmlspecialchars(json_encode($rec), ENT_QUOTES, 'UTF-8') ?>)">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>

                                            <button
                                                class="btn btn-sm btn-danger btn-pill delete-trigger"
                                                data-record-id="<?= $rec['id'] ?>">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </div>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="<?= count($columns) ?>">No records found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <script>
                    // Call this after any search/filter change
                    window.__markFilteredRows = function() {
                        const table = document.getElementById("searchTable");
                        if (!table) return;
                        const rows = Array.from(table.tBodies[0].querySelectorAll("tr"))
                            .filter(r => r.querySelectorAll("td").length > 1); // ignore "No records found"

                        rows.forEach(row => {
                            // If your existing filter hides rows using display:none or d-none
                            const hiddenByFilter =
                                row.classList.contains("d-none") || row.style.display === "none";

                            row.dataset.filtered = hiddenByFilter ? "0" : "1";
                        });
                    };
                </script>


                <!-- Pagination Controls -->
                <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-2 mt-3">
                    <div class="text-secondary small">
                        <span id="paginationInfo">Showing 0 to 0 of 0 entries</span>
                    </div>

                    <nav aria-label="Table pagination">
                        <ul class="pagination pagination-sm mb-0" id="tablePagination"></ul>
                    </nav>
                </div>


                <!-- ========================= -->
                <!-- EDIT MODAL (DYNAMIC SERVICES) -->
                <!-- ========================= -->
                <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 80vw;">
                        <div class="modal-content rounded-4 shadow">

                            <!-- Header -->
                            <div class="modal-header text-white" style="background-color:#16166c;">
                                <h5 class="modal-title fw-bold">
                                    <i class="bi bi-pencil-square me-2"></i> Edit Record
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>

                            <form id="editForm" action="<?= site_url('update_record') ?>" method="post">
                                <?= csrf_field() ?>
                                <input type="hidden" name="id" id="edit_id">

                                <div class="modal-body p-0">
                                    <div class="form-card border-0 shadow-none rounded-0">

                                        <!-- Soft Header -->
                                        <div class="form-card-header px-4 py-3 d-flex align-items-center gap-2">
                                            <div class="rounded-3 d-flex align-items-center justify-content-center"
                                                style="width:38px;height:38px;background:rgba(13,110,253,.15);">
                                                <i class="bi bi-clipboard2-check-fill text-primary"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold text-uppercase text-secondary small mb-0">
                                                    Employee & Service Information
                                                </div>
                                                <div class="text-secondary" style="font-size:12px;">
                                                    Update employee and service records
                                                </div>
                                            </div>
                                        </div>

                                        <div class="p-4">

                                            <!-- Row 1 -->
                                            <div class="row g-3">
                                                <div class="col-md-3">
                                                    <label class="form-label-soft">Last Name</label>
                                                    <input type="text" name="last_name" id="edit_last_name" class="form-control form-modern">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label-soft">First Name</label>
                                                    <input type="text" name="first_name" id="edit_first_name" class="form-control form-modern">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label-soft">Middle Name</label>
                                                    <input type="text" name="middle_name" id="edit_middle_name" class="form-control form-modern">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label-soft">Ext.</label>
                                                    <input type="text" name="extensions" id="edit_extensions" class="form-control form-modern">
                                                </div>
                                            </div>

                                            <!-- Row 2 -->
                                            <div class="row g-3 mt-1">
                                                <div class="col-md-6">
                                                    <label class="form-label-soft">Birthdate</label>
                                                    <input type="date" name="birthdate" id="edit_birthdate" class="form-control form-modern">
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label-soft">Gender</label>
                                                    <select name="gender" id="edit_gender" class="form-select form-modern">
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                    </select>
                                                </div>
                                            </div>


                                            <!-- Row 3 -->
                                            <div class="row g-3 mt-1">
                                                <div class="col-md-6">
                                                    <label class="form-label-soft">Educational Attainment</label>
                                                    <input type="text" name="educational_attainment" id="edit_educational_attainment" class="form-control form-modern">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label-soft">Eligibility</label>
                                                    <select name="eligibility" id="edit_eligibility" class="form-select form-modern">
                                                        <option value="PRO">PRO</option>
                                                        <option value="NON PRO">NON PRO</option>
                                                        <option value="PRC">PRC</option>
                                                        <option value="NON">NON</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Remarks -->
                                            <div class="mt-3">
                                                <label class="form-label-soft">Remarks</label>
                                                <textarea name="remarks" id="edit_remarks" rows="4" class="form-control form-modern"></textarea>
                                            </div>

                                            <hr class="border-secondary opacity-25 my-4">

                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <div class="fw-semibold text-secondary">
                                                    Service Information
                                                </div>

                                                <button type="button"
                                                    id="editAddServiceBtn"
                                                    class="btn btn-outline-primary btn-sm rounded-pill fw-semibold px-3">
                                                    <i class="bi bi-plus-circle me-1"></i>
                                                    Add Service
                                                </button>
                                            </div>

                                            <div id="editServiceContainer"></div>

                                            <!-- ✅ Template (hidden) -->
                                            <!-- ✅ Template (hidden) -->
                                            <template id="editServiceRowTpl">
                                                <div class="service-row mb-4">

                                                    <!-- HEADER (same vibe as Add Record) -->
                                                    <div class="form-card-header px-4 py-3 d-flex align-items-center justify-content-between rounded-4"
                                                        style="background: rgba(255,255,255,.06);">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <div class="rounded-3 d-flex align-items-center justify-content-center"
                                                                style="width:38px;height:38px;background:rgba(13,110,253,.15);">
                                                                <i class="bi bi-clipboard2-plus-fill text-primary"></i>
                                                            </div>
                                                            <div>
                                                                <div class="fw-bold text-uppercase text-secondary small mb-0">Employee's Service Information</div>
                                                                <div class="text-secondary" style="font-size:12px;">Update a service record</div>
                                                            </div>
                                                        </div>

                                                        <span class="badge rounded-pill text-bg-secondary js-service-index">Service</span>
                                                    </div>

                                                    <!-- BODY -->
                                                    <div class="border rounded-4 p-3 mt-2" style="background: rgba(255,255,255,.06);">

                                                        <!-- Department + Designation + Rate -->
                                                        <div class="row g-3 mt-1">
                                                            <div class="col-12 col-md-4">
                                                                <label class="form-label-soft">Department</label>
                                                                <select name="department[]" class="form-select form-modern js-dept" required>
                                                                    <option value="" selected disabled>Select Department</option>
                                                                    <option value="Accounting Office">Accounting Office</option>
                                                                    <option value="Administrator's Office">Administrator's Office</option>
                                                                    <option value="Agriculture Office">Agriculture Office</option>
                                                                    <option value="Assessor">Assessor</option>
                                                                    <option value="BIR">BIR</option>
                                                                    <option value="BFP">BFP</option>
                                                                    <option value="Bolinao Water Works System">Bolinao Water Works System</option>
                                                                    <option value="Budget">Budget</option>
                                                                    <option value="COA">COA</option>
                                                                    <option value="COMELEC">COMELEC</option>
                                                                    <option value="DEPED">DEPED</option>
                                                                    <option value="DILG">DILG</option>
                                                                    <option value="Engineering Office">Engineering Office</option>
                                                                    <option value="GAD">GAD</option>
                                                                    <option value="Garbage Collection">Garbage Collection</option>
                                                                    <option value="GSO">GSO</option>
                                                                    <option value="HRMO">HRMO</option>
                                                                    <option value="LCR">LCR</option>
                                                                    <option value="Market / Slaughter">Market / Slaughter</option>
                                                                    <option value="MDRRMO">MDRRMO</option>
                                                                    <option value="MPDC">MPDC</option>
                                                                    <option value="MSWD / STAC">MSWD / STAC</option>
                                                                    <option value="Mayor's Office">Mayor's Office</option>
                                                                    <option value="PESO">PESO</option>
                                                                    <option value="PNP">PNP</option>
                                                                    <option value="RHU">RHU</option>
                                                                    <option value="SB / Municipal Library">SB / Municipal Library</option>
                                                                    <option value="Sanitary Land Filling">Sanitary Land Filling</option>
                                                                    <option value="Street Cleaning">Street Cleaning</option>
                                                                    <option value="Traffic Enforcement">Traffic Enforcement</option>
                                                                    <option value="Tourism Office">Tourism Office</option>
                                                                    <option value="Treasurer Office">Treasurer Office</option>
                                                                </select>
                                                            </div>

                                                            <div class="col-12 col-md-4">
                                                                <label class="form-label-soft">Designation</label>
                                                                <select name="designation[]" class="form-select form-modern js-desig" required>
                                                                    <option value="" selected disabled>Select Designation</option>
                                                                    <option value="Aircon Maintenance">Aircon Maintenance</option>
                                                                    <option value="Administrative Assistance">Administrative Assistance</option>
                                                                    <option value="Backhoe Operator">Backhoe Operator</option>
                                                                    <option value="Beach Ward">Beach Ward</option>
                                                                    <option value="Building Guard">Building Guard</option>
                                                                    <option value="Caregiver">Caregiver</option>
                                                                    <option value="Carpenter">Carpenter</option>
                                                                    <option value="Clerk">Clerk</option>
                                                                    <option value="Computer Technician">Computer Technician</option>
                                                                    <option value="Daycare Teacher">Daycare Teacher</option>
                                                                    <option value="Driver">Driver</option>
                                                                    <option value="Electrician">Electrician</option>
                                                                    <option value="Encoder">Encoder</option>
                                                                    <option value="Engineering Brigade">Engineering Brigade</option>
                                                                    <option value="Focal Person for Senior Citizen">Focal Person for Senior Citizen</option>
                                                                    <option value="Financial Assistance Staff">Financial Assistance Staff</option>
                                                                    <option value="First Responder">First Responder</option>
                                                                    <option value="GAD Personnel">GAD Personnel</option>
                                                                    <option value="Heavy Equipment Operator">Heavy Equipment Operator</option>
                                                                    <option value="Laboratory Assistant">Laboratory Assistant</option>
                                                                    <option value="Laboratory Technician">Laboratory Technician</option>
                                                                    <option value="Market Aide">Market Aide</option>
                                                                    <option value="Market Cleaner">Market Cleaner</option>
                                                                    <option value="Market Watchman">Market Watchman</option>
                                                                    <option value="Mechanic">Mechanic</option>
                                                                    <option value="Midwife Assistant">Midwife Assistant</option>
                                                                    <option value="Nurse">Nurse</option>
                                                                    <option value="Nursing Assistant">Nursing Assistant</option>
                                                                    <option value="OSCA Head">OSCA Head</option>
                                                                    <option value="Plumber">Plumber</option>
                                                                    <option value="Pump Tender">Pump Tender</option>
                                                                    <option value="Pumping Station Guard">Pumping Station Guard</option>
                                                                    <option value="Recorder">Recorder</option>
                                                                    <option value="Rescue Personnel">Rescue Personnel</option>
                                                                    <option value="School Guard">School Guard</option>
                                                                    <option value="Security">Security</option>
                                                                    <option value="SPED Teacher">SPED Teacher</option>
                                                                    <option value="Spring Guard">Spring Guard</option>
                                                                    <option value="Street Cleaner">Street Cleaner</option>
                                                                    <option value="Traffic Enforcer">Traffic Enforcer</option>
                                                                    <option value="Utility Worker">Utility Worker</option>
                                                                    <option value="Shadow Teacher">Shadow Teacher</option>
                                                                    <option value="STAC Staff">STAC Staff</option>
                                                                    <option value="Child Development Teacher">Child Development Teacher</option>
                                                                    <option value="Tourism Aide">Tourism Aide</option>
                                                                    <option value="Maintenance Personnel">Maintenance Personnel</option>
                                                                </select>
                                                            </div>

                                                            <div class="col-12 col-md-4">
                                                                <label class="form-label-soft">Rate</label>
                                                                <input type="text" name="rate[]" class="form-control form-modern js-rate" required>
                                                            </div>
                                                        </div>

                                                        <!-- Date of Appointment + Status -->
                                                        <div class="row g-3 mt-1">
                                                            <div class="col-12 col-md-6">
                                                                <label class="form-label-soft">Date of Appointment</label>
                                                                <input type="date" name="date_of_appointment[]" class="form-control form-modern js-appoint" required>
                                                            </div>

                                                            <div class="col-12 col-md-6">
                                                                <label class="form-label-soft">Status</label>
                                                                <select name="status[]" class="form-select form-modern js-status" required>
                                                                    <option value="Employed">Employed</option>
                                                                    <option value="Resigned/Retired">Resigned/Retired</option>
                                                                    <option value="Terminated">Terminated</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <!-- Date Ended + Duration (hidden until needed) -->
                                                        <div class="row g-3 mt-1 js-ended-row d-none">
                                                            <div class="col-12 col-md-6 js-ended-wrap">
                                                                <label class="form-label-soft">Date Ended</label>

                                                                <!-- visible (datetime-local like Add Record) -->
                                                                <input type="datetime-local" class="form-control form-modern js-ended">

                                                                <!-- submitted -->
                                                                <input type="hidden" name="date_ended[]" class="js-ended-hidden">

                                                                <small class="text-secondary d-block mt-1 js-ended-hint" style="font-size:12px;"></small>
                                                            </div>

                                                            <div class="col-12 col-md-6">
                                                                <label class="form-label-soft">Service Duration</label>
                                                                <input type="text" name="service_duration[]" class="form-control form-modern js-duration" readonly>
                                                            </div>
                                                        </div>

                                                        <!-- Buttons (same as Add Record) -->
                                                        <div class="d-flex gap-2 justify-content-center mt-4">
                                                            <button type="button" class="btn btn-danger mt-1 js-remove-service">Remove</button>
                                                            <button type="button" class="btn btn-outline-primary mt-1 js-add-service">
                                                                + Add Service Record
                                                            </button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </template>


                                        </div>
                                    </div>
                                </div>

                                <!-- Footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light btn-pill" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary btn-pill">
                                        <i class="bi bi-check2-circle me-1"></i> Save Changes
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>









                <!-- ========================= -->
                <!-- DELETE CONFIRMATION MODAL -->
                <!-- ========================= -->
                <div class="modal fade" id="deleteConfirmModal" tabindex="-1">
                    <div class="modal-dialog modal-sm modal-dialog-centered">
                        <div class="modal-content rounded-4 shadow">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>Confirm Delete
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>

                            <form id="deleteForm" method="post">
                                <?= csrf_field() ?>
                                <div class="modal-body text-center">
                                    <p>Are you sure you want to permanently delete this record?</p>
                                </div>
                                <div class="modal-footer justify-content-center">
                                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger rounded-pill">Delete</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

            </div><!-- table-responsive -->
        </div><!-- p-4 -->
    </div><!-- form-card -->

</div><!-- container -->
<script>
    // public/js/edit_dynamic_services.js
    // ✅ Bulletproof version (event delegation) for Edit Modal dynamic services

    function splitPipe(val) {
        if (!val) return [];
        return String(val).split("||").map((s) => s.trim());
    }

    function isZeroDate(v) {
        return String(v || "").trim() === "0000-00-00";
    }

    // Accepts: "YYYY-MM-DD", "YYYY-MM-DD HH:mm:ss", "YYYY-MM-DDTHH:mm"
    function toISODate(val) {
        if (!val) return "";
        val = String(val).trim();
        if (isZeroDate(val)) return "";
        if (/^\d{4}-\d{2}-\d{2}$/.test(val)) return val;
        if (/^\d{4}-\d{2}-\d{2}/.test(val)) return val.slice(0, 10);
        return "";
    }

    function parseDateOnly(iso) {
        return iso ? new Date(iso + "T00:00:00") : null;
    }

    function needsEndDate(status) {
        return status === "Terminated" || status === "Resigned/Retired";
    }

    function daysInMonth(year, monthIndex) {
        return new Date(year, monthIndex + 1, 0).getDate();
    }

    function diffYMD(fromDate, toDate) {
        let y = toDate.getFullYear() - fromDate.getFullYear();
        let m = toDate.getMonth() - fromDate.getMonth();
        let d = toDate.getDate() - fromDate.getDate();

        if (d < 0) {
            m -= 1;
            const prevMonth = (toDate.getMonth() - 1 + 12) % 12;
            const prevMonthYear = prevMonth === 11 ? toDate.getFullYear() - 1 : toDate.getFullYear();
            d += daysInMonth(prevMonthYear, prevMonth);
        }

        if (m < 0) {
            y -= 1;
            m += 12;
        }

        return {
            years: y,
            months: m,
            days: d
        };
    }

    function formatDuration({
        years,
        months,
        days
    }) {
        const parts = [];
        if (years > 0) parts.push(`${years} year${years !== 1 ? "s" : ""}`);
        if (months > 0) parts.push(`${months} month${months !== 1 ? "s" : ""}`);
        if (days > 0) parts.push(`${days} day${days !== 1 ? "s" : ""}`);
        return parts.length ? parts.join(", ") : "0 days";
    }

    function createRow(container) {
        const tpl = document.getElementById("editServiceRowTpl");
        if (!tpl) {
            console.error("❌ #editServiceRowTpl not found");
            return null;
        }
        const node = tpl.content.cloneNode(true);
        container.appendChild(node);
        return container.querySelector(".service-row:last-child");
    }

    function renumber(container) {
        container.querySelectorAll(".service-row").forEach((row, i) => {
            const badge = row.querySelector(".js-service-index");
            if (badge) badge.textContent = `Service ${i + 1}`;
        });
    }

    function updateRow(row) {
        const statusEl = row.querySelector(".js-status");
        const appointEl = row.querySelector(".js-appoint");
        const endedRow = row.querySelector(".js-ended-row");
        const endedEl = row.querySelector(".js-ended"); // datetime-local visible
        const endedHidden = row.querySelector(".js-ended-hidden"); // hidden date_ended[]
        const durationEl = row.querySelector(".js-duration");
        const hintEl = row.querySelector(".js-ended-hint");

        const status = (statusEl?.value || "").trim();
        const startISO = toISODate(appointEl?.value || "");
        const startDate = parseDateOnly(startISO);

        if (endedEl) {
            endedEl.required = false;
            endedEl.setCustomValidity("");
        }

        // no start
        if (!startDate) {
            if (endedRow) endedRow.classList.add("d-none");
            if (durationEl) durationEl.value = "";
            if (endedHidden) endedHidden.value = "";
            if (hintEl) hintEl.textContent = "";
            return;
        }

        // employed -> hide
        if (!needsEndDate(status)) {
            if (endedRow) endedRow.classList.add("d-none");
            if (endedEl) endedEl.value = "";
            if (endedHidden) endedHidden.value = "0000-00-00";
            if (durationEl) durationEl.value = "Currently Working";
            if (hintEl) hintEl.textContent = "Currently Working";
            return;
        }

        // terminated/resigned -> show
        if (endedRow) endedRow.classList.remove("d-none");
        if (hintEl) hintEl.textContent = "Required";
        if (endedEl) endedEl.required = true;

        const endedISO = toISODate(endedEl?.value || "");
        if (endedHidden) endedHidden.value = endedISO;

        if (!endedISO) {
            if (durationEl) durationEl.value = "Waiting for end date";
            if (endedEl) endedEl.setCustomValidity("Date Ended is required.");
            return;
        }

        const endDate = parseDateOnly(endedISO);
        if (!endDate) {
            if (durationEl) durationEl.value = "Waiting for end date";
            return;
        }

        if (startDate > endDate) {
            if (durationEl) durationEl.value = "Invalid dates";
            if (endedEl) endedEl.setCustomValidity("Date Ended cannot be earlier than Date of Appointment.");
            return;
        }

        if (durationEl) durationEl.value = formatDuration(diffYMD(startDate, endDate));
    }

    function fillRow(row, data) {
        row.querySelector(".js-dept")?.setAttribute("value", "");
        const deptEl = row.querySelector(".js-dept");
        const desigEl = row.querySelector(".js-desig");
        const rateEl = row.querySelector(".js-rate");
        const appointEl = row.querySelector(".js-appoint");
        const statusEl = row.querySelector(".js-status");
        const endedEl = row.querySelector(".js-ended");
        const endedHidden = row.querySelector(".js-ended-hidden");

        if (deptEl) deptEl.value = data.department || "";
        if (desigEl) desigEl.value = data.designation || "";
        if (rateEl) rateEl.value = data.rate || "";
        if (appointEl) appointEl.value = toISODate(data.date_of_appointment || "");
        if (statusEl) statusEl.value = (data.status || "Employed").trim();

        const endedISO = toISODate(data.date_ended || "");
        if (endedEl) endedEl.value = endedISO ? `${endedISO}T00:00` : "";
        if (endedHidden) endedHidden.value = endedISO || ((statusEl?.value || "") === "Employed" ? "0000-00-00" : "");

        updateRow(row);
    }

    // ========= PUBLIC: called by your onclick openEditModal(JSON) =========
    window.openEditModal = function(rec) {
        document.getElementById("edit_id").value = rec.id ?? "";
        document.getElementById("edit_last_name").value = rec.last_name ?? "";
        document.getElementById("edit_first_name").value = rec.first_name ?? "";
        document.getElementById("edit_middle_name").value = rec.middle_name ?? "";
        document.getElementById("edit_extensions").value = rec.extensions ?? "";
        document.getElementById("edit_birthdate").value = toISODate(rec.birthdate ?? "");
        document.getElementById("edit_gender").value = rec.gender ?? "Male";
        document.getElementById("edit_educational_attainment").value = rec.educational_attainment ?? "";
        document.getElementById("edit_eligibility").value = rec.eligibility ?? "NON";
        document.getElementById("edit_remarks").value = rec.remarks ?? "";

        const container = document.getElementById("editServiceContainer");
        container.innerHTML = "";

        const departments = splitPipe(rec.department);
        const designations = splitPipe(rec.designation);
        const rates = splitPipe(rec.rate);
        const appoints = splitPipe(rec.date_of_appointment);
        const statuses = splitPipe(rec.status);
        const endeds = splitPipe(rec.date_ended);

        const maxLen = Math.max(
            departments.length,
            designations.length,
            rates.length,
            appoints.length,
            statuses.length,
            endeds.length,
            1
        );

        for (let i = 0; i < maxLen; i++) {
            const row = createRow(container);
            if (!row) continue;

            fillRow(row, {
                department: departments[i] || "",
                designation: designations[i] || "",
                rate: rates[i] || "",
                date_of_appointment: appoints[i] || "",
                status: statuses[i] || "Employed",
                date_ended: endeds[i] || "",
            });
        }

        renumber(container);
    };

    document.addEventListener("DOMContentLoaded", () => {
        const modalEl = document.getElementById("editModal");
        const container = document.getElementById("editServiceContainer");
        const form = document.getElementById("editForm");
        const topAddBtn = document.getElementById("editAddServiceBtn");

        if (!container) {
            console.warn("❌ #editServiceContainer not found. JS will not work.");
            return;
        }

        // ✅ event delegation: Add/Remove buttons inside rows
        container.addEventListener("click", (e) => {
            // add button inside row
            const addInside = e.target.closest(".js-add-service");
            if (addInside) {
                const row = createRow(container);
                if (!row) return;

                // default values
                row.querySelector(".js-status").value = "Employed";
                row.querySelector(".js-ended-hidden").value = "0000-00-00";
                updateRow(row);
                renumber(container);
                return;
            }

            // remove
            const removeBtn = e.target.closest(".js-remove-service");
            if (removeBtn) {
                const row = removeBtn.closest(".service-row");
                const all = container.querySelectorAll(".service-row");
                if (all.length <= 1) {
                    // reset instead of remove
                    row.querySelectorAll("select").forEach((s) => (s.selectedIndex = 0));
                    row.querySelectorAll("input").forEach((i) => (i.value = ""));
                    row.querySelector(".js-ended-hidden").value = "0000-00-00";
                    updateRow(row);
                    renumber(container);
                    return;
                }
                row.remove();
                renumber(container);
            }
        });

        // ✅ delegation: change/input updates
        container.addEventListener("change", (e) => {
            const row = e.target.closest(".service-row");
            if (!row) return;

            if (
                e.target.classList.contains("js-status") ||
                e.target.classList.contains("js-appoint") ||
                e.target.classList.contains("js-ended")
            ) {
                updateRow(row);
            }
        });

        container.addEventListener("input", (e) => {
            const row = e.target.closest(".service-row");
            if (!row) return;
            if (e.target.classList.contains("js-ended")) updateRow(row);
        });

        // ✅ top add service button
        if (topAddBtn) {
            topAddBtn.addEventListener("click", () => {
                const row = createRow(container);
                if (!row) return;

                row.querySelector(".js-status").value = "Employed";
                row.querySelector(".js-ended-hidden").value = "0000-00-00";
                updateRow(row);
                renumber(container);
            });
        }

        // ✅ on modal show: force refresh (fix "still hidden")
        if (modalEl) {
            modalEl.addEventListener("shown.bs.modal", () => {
                setTimeout(() => {
                    const rows = container.querySelectorAll(".service-row");
                    if (rows.length === 0) {
                        const row = createRow(container);
                        if (!row) return;
                        row.querySelector(".js-status").value = "Employed";
                        row.querySelector(".js-ended-hidden").value = "0000-00-00";
                    }
                    container.querySelectorAll(".service-row").forEach(updateRow);
                    renumber(container);
                }, 80);
            });
        }

        // ✅ submit: sync + validate
        if (form) {
            form.addEventListener("submit", (e) => {
                container.querySelectorAll(".service-row").forEach(updateRow);

                if (!form.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();
                }
                form.classList.add("was-validated");
            });
        }
    });
</script>

<!-- DELETE BUTTON SCRIPT -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteForm = document.getElementById('deleteForm');
        let recordIdToDelete = null;

        const deleteUrl = "<?= site_url('delete_records') ?>";
        const csrfName = "<?= csrf_token() ?>";
        const csrfHash = "<?= csrf_hash() ?>";

        document.querySelectorAll('.delete-trigger').forEach(btn => {
            btn.addEventListener('click', function() {
                recordIdToDelete = this.getAttribute('data-record-id');
            });
        });

        deleteForm.addEventListener('submit', function(e) {
            e.preventDefault();
            if (!recordIdToDelete) return;

            fetch(`${deleteUrl}/${recordIdToDelete}`, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        [csrfName]: csrfHash
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const row = document.querySelector(`[data-record-id='${recordIdToDelete}']`).closest('tr');
                        if (row) row.remove();

                        const modal = bootstrap.Modal.getInstance(document.getElementById('deleteConfirmModal'));
                        modal.hide();

                        recordIdToDelete = null;
                    }
                })
                .catch(err => console.error(err));
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const table = document.getElementById("searchTable");
        if (!table) return;

        const tbody = table.tBodies[0];
        const paginationEl = document.getElementById("tablePagination");
        const infoEl = document.getElementById("paginationInfo");
        if (!paginationEl || !infoEl) return;

        const ROWS_PER_PAGE = 10;
        let currentPage = 1;

        function getDataRows() {
            return Array.from(tbody.querySelectorAll("tr"))
                .filter(r => r.querySelectorAll("td").length > 1);
        }

        function getFilteredRows() {
            return getDataRows().filter(r => r.dataset.filtered !== "0");
        }

        function forceHide(row) {
            row.style.setProperty("display", "none", "important");
        }

        function forceShow(row) {
            row.style.removeProperty("display"); // back to normal
        }

        function applyFinalVisibility() {
            getDataRows().forEach(row => {
                const filtered = row.dataset.filtered !== "0";
                const paged = row.dataset.page === "1";
                (filtered && paged) ? forceShow(row): forceHide(row);
            });
        }

        function buildPageItem(label, targetPage, {
            disabled = false,
            active = false
        } = {}) {
            const li = document.createElement("li");
            li.className = "page-item";
            if (disabled) li.classList.add("disabled");
            if (active) li.classList.add("active");

            const a = document.createElement("a");
            a.className = "page-link";
            a.href = "#";
            a.textContent = label;

            a.addEventListener("click", (e) => {
                e.preventDefault();
                if (disabled) return;
                renderPage(targetPage);
            });

            li.appendChild(a);
            return li;
        }

        function renderPagination(totalPages) {
            paginationEl.innerHTML = "";

            paginationEl.appendChild(buildPageItem("«", currentPage - 1, {
                disabled: currentPage === 1
            }));

            const windowSize = 7;
            let start = Math.max(1, currentPage - Math.floor(windowSize / 2));
            let end = Math.min(totalPages, start + windowSize - 1);
            start = Math.max(1, end - windowSize + 1);

            for (let p = start; p <= end; p++) {
                paginationEl.appendChild(buildPageItem(String(p), p, {
                    active: p === currentPage
                }));
            }

            paginationEl.appendChild(buildPageItem("»", currentPage + 1, {
                disabled: currentPage === totalPages
            }));
        }

        function renderPage(page) {
            const filteredRows = getFilteredRows();
            const totalRows = filteredRows.length;
            const totalPages = Math.max(1, Math.ceil(totalRows / ROWS_PER_PAGE));

            currentPage = Math.min(Math.max(page, 1), totalPages);

            // reset page markers for ALL rows
            getDataRows().forEach(r => r.dataset.page = "0");

            // set page=1 only for current slice
            const startIndex = (currentPage - 1) * ROWS_PER_PAGE;
            const endIndex = startIndex + ROWS_PER_PAGE;
            filteredRows.slice(startIndex, endIndex).forEach(r => r.dataset.page = "1");

            applyFinalVisibility();

            const from = totalRows === 0 ? 0 : startIndex + 1;
            const to = totalRows === 0 ? 0 : Math.min(endIndex, totalRows);
            infoEl.textContent = `Showing ${from} to ${to} of ${totalRows} entries`;

            renderPagination(totalPages);
        }

        // called by main_search.js
        window.__paginationRefresh = () => renderPage(1);

        // init defaults
        getDataRows().forEach(r => {
            if (typeof r.dataset.filtered === "undefined") r.dataset.filtered = "1";
        });

        renderPage(1);
    });
</script>




<link rel="stylesheet" href="<?= base_url('css/search_records.css') ?>">


<!-- SCRIPTS -->
<script src="<?= base_url('js/main_search.js') ?>"></script>
<script src="<?= base_url('js/print_table.js') ?>"></script>
<script src="<?= base_url('js/flash_data_timer.js') ?>"></script>


<?= $this->endSection(); ?>