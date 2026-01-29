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
                        'Status',
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
                            <td class="text-truncate" style="max-width: 120px;"><?= esc($rec['last_name']) ?></td>
                            <td class="text-truncate" style="max-width: 120px;"><?= esc($rec['first_name']) ?></td>
                            <td class="text-truncate" style="max-width: 120px;"><?= esc($rec['middle_name']) ?></td>
                            <td class="text-truncate" style="max-width: 80px;"><?= esc($rec['extensions']) ?></td>
                            <td class="text-truncate" style="max-width: 100px;"><?= esc($rec['birthdate']) ?></td>
                            <td class="text-truncate" style="max-width: 80px;"><?= esc($rec['gender']) ?></td>
                            <td class="text-truncate" style="max-width: 120px;"><?= $rec['department'] ?></td>
                            <td class="text-truncate" style="max-width: 120px;"><?= esc($rec['educational_attainment']) ?></td>
                            <td class="text-truncate" style="max-width: 120px;"><?= $rec['designation'] ?></td>
                            <td class="text-truncate" style="max-width: 80px;"><?= esc($rec['rate']) ?></td>
                            <td class="text-truncate" style="max-width: 120px;"><?= esc($rec['eligibility']) ?></td>
                            <td class="text-truncate" style="max-width: 120px;"><?= $rec['date_of_appointment'] ?></td>
                            <td class="text-truncate" style="max-width: 100px;"><?= $rec['status'] ?></td>
                            <td class="text-truncate" style="max-width: 150px;"><?= esc($rec['remarks']) ?></td>
                            <td style="width: 120px;">
                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                    <button
                                        class="btn btn-sm btn-primary btn-pill"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editModal"
                                        onclick="openEditModal(<?= htmlspecialchars(json_encode($rec), ENT_QUOTES, 'UTF-8') ?>)">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button
                                        class="btn btn-sm btn-danger btn-pill delete-trigger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteConfirmModal"
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

                <!-- ========================= -->
                <!-- EDIT MODAL -->
                <!-- ========================= -->
                <div class="modal fade" id="editModal" tabindex="-1">
                    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content rounded-4 shadow">
                            <div class="modal-header bg-primary text-white rounded-top-4">
                                <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Edit Record</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>

                            <form action="<?= site_url('update_record') ?>" method="post">
                                <?= csrf_field() ?>
                                <div class="modal-body">
                                    <input type="hidden" name="id" id="edit_id">

                                    <div class="row g-3">
                                        <div class="col-md-3">
                                            <label class="form-label">Last Name</label>
                                            <input type="text" name="last_name" id="edit_last_name" class="form-control rounded-pill">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">First Name</label>
                                            <input type="text" name="first_name" id="edit_first_name" class="form-control rounded-pill">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Middle Name</label>
                                            <input type="text" name="middle_name" id="edit_middle_name" class="form-control rounded-pill">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Extensions</label>
                                            <input type="text" name="extensions" id="edit_extensions" class="form-control rounded-pill">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Birthdate</label>
                                            <input type="date" name="birthdate" id="edit_birthdate" class="form-control rounded-pill">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Gender</label>
                                            <select name="gender" id="edit_gender" class="form-select rounded-pill">
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Department</label>
                                            <select name="department" id="edit_department" class="form-select rounded-pill">
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
                                                <!-- Add other departments here -->
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Educational Attainment</label>
                                            <input type="text" name="educational_attainment" id="edit_educational_attainment" class="form-control rounded-pill">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Designation</label>
                                            <select name="designation" id="edit_designation" class="form-select rounded-pill">
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
                                                <!-- Add other designations here -->
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Rate</label>
                                            <input type="text" name="rate" id="edit_rate" class="form-control rounded-pill">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Eligibility</label>
                                            <select name="eligibility" id="edit_eligibility" class="form-select rounded-pill">
                                                <option value="" selected disabled>Select Eligibility</option>
                                                <option value="PRO">PRO</option>
                                                <option value="NON PRO">NON PRO</option>
                                                <option value="PRC">PRC</option>
                                                <option value="NON">NON</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Date of Appointment</label>
                                            <input type="date" name="date_of_appointment" id="edit_date_of_appointment" class="form-control rounded-pill">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Remarks</label>
                                            <textarea name="remarks" id="edit_remarks" class="form-control rounded-4"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary rounded-pill">Save Changes</button>
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

<!-- ========================= -->
<!-- SCRIPTS -->
<!-- ========================= -->
<script src="<?= base_url('js/main_search.js') ?>"></script>
<script src="<?= base_url('js/print_table.js') ?>"></script>
<script src="<?= base_url('js/fill_records_modal.js') ?>"></script>

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

<?= $this->endSection(); ?>