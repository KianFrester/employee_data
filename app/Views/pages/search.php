<?php echo $this->extend('main/master'); ?>
<?php echo $this->section('content'); ?>
<?php echo $this->include('main/navbar'); ?>

<div class="container my-5">

    <!-- Page Title -->
    <div class="text-center mb-4">
        <h2 class="fw-bold text-primary">Search Records</h2>
        <hr>
    </div>
<h1>Hi</h1>
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
        <div class="col-md-2">
            <div class="dropdown w-auto">
                <button
                    class="btn btn-light btn-lg w-100 rounded-pill shadow-sm text-primary text-black dropdown-toggle"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="bi bi-funnel-fill text-primary me-2"></i>
                    Filter Columns
                </button>

                <ul class="dropdown-menu w-100 p-3 shadow rounded-4">
                    <li class="mb-2">
                        <div class="form-check">
                            <input class="form-check-input column-check" type="checkbox" value="0" checked>
                            <label class="form-check-label">Last Name</label>
                        </div>
                    </li>
                    <li class="mb-2">
                        <div class="form-check">
                            <input class="form-check-input column-check" type="checkbox" value="1" checked>
                            <label class="form-check-label">First Name</label>
                        </div>
                    </li>
                    <li class="mb-2">
                        <div class="form-check">
                            <input class="form-check-input column-check" type="checkbox" value="2" checked>
                            <label class="form-check-label">Middle Name</label>
                        </div>
                    </li>
                    <li class="mb-2">
                        <div class="form-check">
                            <input class="form-check-input column-check" type="checkbox" value="2" checked>
                            <label class="form-check-label">Extensions</label>
                        </div>
                    </li>
                    <li class="mb-2">
                        <div class="form-check">
                            <input class="form-check-input column-check" type="checkbox" value="2" checked>
                            <label class="form-check-label">Birthdate</label>
                        </div>
                    </li>
                    <li>
                        <div class="form-check">
                            <input class="form-check-input column-check" type="checkbox" value="5" checked>
                            <label class="form-check-label">Gender</label>
                        </div>
                    </li>
                    <li class="mb-2">
                        <div class="form-check">
                            <input class="form-check-input column-check" type="checkbox" value="3" checked>
                            <label class="form-check-label">Department</label>
                        </div>
                    </li>
                    <li class="mb-2">
                        <div class="form-check">
                            <input class="form-check-input column-check" type="checkbox" value="4" checked>
                            <label class="form-check-label">Designation</label>
                        </div>
                    </li>
                    <li class="mb-2">
                        <div class="form-check">
                            <input class="form-check-input column-check" type="checkbox" value="2" checked>
                            <label class="form-check-label">Eduacational Attainment</label>
                        </div>
                    </li>
                    <li class="mb-2">
                        <div class="form-check">
                            <input class="form-check-input column-check" type="checkbox" value="2" checked>
                            <label class="form-check-label">Rate</label>
                        </div>
                    </li>
                    <li class="mb-2">
                        <div class="form-check">
                            <input class="form-check-input column-check" type="checkbox" value="2" checked>
                            <label class="form-check-label">Eligibility</label>
                        </div>
                    </li>
                    <li class="mb-2">
                        <div class="form-check">
                            <input class="form-check-input column-check" type="checkbox" value="2" checked>
                            <label class="form-check-label">Date of Appointment</label>
                        </div>
                    </li>
                    <li class="mb-2">
                        <div class="form-check">
                            <input class="form-check-input column-check" type="checkbox" value="2" checked>
                            <label class="form-check-label">Service Duration</label>
                        </div>
                    </li>
                    <li class="mb-2">
                        <div class="form-check">
                            <input class="form-check-input column-check" type="checkbox" value="2" checked>
                            <label class="form-check-label">Remarks</label>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

    </div>

    <!-- Table -->
    <div class="card shadow rounded-4">
        <div class="card-header bg-primary text-white fw-bold">
            Employee Records
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center align-middle" id="searchTable">
                    <thead class="table-primary">
                        <tr>
                            <th>Last Name</th>
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <th>Gender</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($records)): ?>
                            <?php foreach ($records as $rec): ?>
                                <tr>
                                    <td><?= esc($rec['last_name']) ?></td>
                                    <td><?= esc($rec['first_name']) ?></td>
                                    <td><?= esc($rec['middle_name']) ?></td>
                                    <td><?= esc($rec['department']) ?></td>
                                    <td><?= esc($rec['designation']) ?></td>
                                    <td><?= esc($rec['gender']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6">No records found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- SCRIPT -->
<script>
    /* ===== ELEMENTS ===== */
    const searchInput = document.getElementById('tableSearch');
    const clearBtn = document.getElementById('clearSearch');
    const table = document.getElementById('searchTable');
    const checkboxes = document.querySelectorAll('.column-check');

    /* ===== APPLY FILTERS ===== */
    function applyFilters() {
        const searchValue = searchInput.value.toLowerCase();
        const selectedColumns = Array.from(checkboxes)
            .filter(cb => cb.checked)
            .map(cb => parseInt(cb.value));

        const rows = table.querySelectorAll('tbody tr');

        /* Show / Hide Columns */
        table.querySelectorAll('tr').forEach(row => {
            row.querySelectorAll('th, td').forEach((cell, index) => {
                cell.style.display = selectedColumns.includes(index) ? '' : 'none';
            });
        });

        /* Search Rows */
        rows.forEach(row => {
            let rowText = '';
            selectedColumns.forEach(index => {
                rowText += row.cells[index]?.innerText.toLowerCase() + ' ';
            });
            row.style.display = rowText.includes(searchValue) ? '' : 'none';
        });
    }

    /* ===== CLEAR BUTTON VISIBILITY ===== */
    function toggleClearButton() {
        clearBtn.style.display = searchInput.value ? 'block' : 'none';
    }

    /* ===== EVENTS ===== */
    searchInput.addEventListener('input', () => {
        applyFilters();
        toggleClearButton();
    });

    clearBtn.addEventListener('click', () => {
        searchInput.value = '';
        searchInput.focus();
        applyFilters();
        toggleClearButton();
    });

    checkboxes.forEach(cb => {
        cb.addEventListener('change', applyFilters);
    });

    /* ===== INIT ===== */
    toggleClearButton();
    applyFilters();
</script>

<?php echo $this->endSection(); ?>