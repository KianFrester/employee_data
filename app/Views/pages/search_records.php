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
        <!-- Soft Header (dashboard style) -->
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
        <!-- Body -->
        <div class="p-4">
            <div class="table-responsive">
                <table class="table table-modern align-middle text-center" id="searchTable">
                    <thead>
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
                                    <td><?= esc($rec['remarks']) ?></td>

                                    <td>
                                        <div class="d-flex justify-content-center gap-2">

                                            <!-- EDIT BUTTON -->
                                            <button
                                                class="btn btn-sm btn-primary btn-pill"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editModal"
                                                onclick="openEditModal(<?= htmlspecialchars(json_encode($rec), ENT_QUOTES, 'UTF-8') ?>)">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>

                                            <!-- DELETE BUTTON -->
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
                                            <input type="text" name="department" id="edit_department" class="form-control rounded-pill">
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">Educational Attainment</label>
                                            <input type="text" name="educational_attainment" id="edit_educational_attainment" class="form-control rounded-pill">
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">Designation</label>
                                            <input type="text" name="designation" id="edit_designation" class="form-control rounded-pill">
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">Rate</label>
                                            <input type="text" name="rate" id="edit_rate" class="form-control rounded-pill">
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">Eligibility</label>
                                            <input type="text" name="eligibility" id="edit_eligibility" class="form-control rounded-pill">
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">Date of Appointment</label>
                                            <input type="date" name="date_of_appointment" id="edit_date_of_appointment" class="form-control rounded-pill">
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">Service Duration</label>
                                            <input type="text" name="service_duration" id="edit_service_duration" class="form-control rounded-pill">
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

<!-- DELETE BUTTON FIX -->
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