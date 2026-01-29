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


            <!-- eto ung alert ng error/success creating record -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>


            <div class="form-card">

                <!-- Soft Header (dashboard style) -->
                <div class="form-card-header px-4 py-3 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-3 d-flex align-items-center justify-content-center"
                            style="width:38px;height:38px;background:rgba(13,110,253,.15);">
                            <i class="bi bi-clipboard2-plus-fill text-primary"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-uppercase text-secondary small mb-0">Employee's Basic Information</div>
                            <div class="text-secondary" style="font-size:12px;">Add a new employee record</div>
                        </div>
                    </div>

                    <a href="<?= base_url('dashboard') ?>" class="btn btn-outline-primary btn-sm rounded-pill fw-semibold">
                        Back →
                    </a>
                </div>

                <!-- Body -->
                <div class="p-4">
                    <form method="post" action="<?= site_url('create') ?>">
                        <?= csrf_field() ?>

                        <!-- Row 1 -->
                        <div class="row g-3">
                            <div class="col-12 col-md-3">
                                <label class="form-label-soft">First Name</label>
                                <input type="text" name="first_name" class="form-control form-modern" placeholder="First name" required>
                            </div>

                            <!-- row 2 -->
                            <div class="col-12 col-md-3">
                                <label class="form-label-soft">Middle Name</label>
                                <input type="text" name="middle_name" class="form-control form-modern" placeholder="Middle name" require>
                            </div>

                            <!-- row 3 -->
                            <div class="col-12 col-md-3">
                                <label class="form-label-soft">Last Name</label>
                                <input type="text" name="last_name" class="form-control form-modern" placeholder="Last name" required>
                            </div>

                            <!-- row 4 -->
                            <div class="col-12 col-md-3">
                                <label class="form-label-soft">Ext.</label>
                                <input type="text" name="extensions" class="form-control form-modern" placeholder="Jr, Sr, III">
                            </div>
                        </div>

                        <!-- Row 5 -->
                        <div class="row g-3 mt-1">
                            <div class="col-12 col-md-4">
                                <label class="form-label-soft">Birthdate</label>
                                <input type="date" name="birthdate" class="form-control form-modern" required>
                            </div>

                            <!-- row 6 -->
                            <div class="col-12 col-md-4">
                                <label class="form-label-soft">Gender</label>
                                <select name="gender" class="form-select form-modern" required>
                                    <option value="" selected disabled>Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>

                            <!-- row 7 -->
                            <div class="col-12 col-md-4">
                                <label class="form-label-soft">Rate</label>
                                <input type="text" name="rate" class="form-control form-modern" placeholder="Rate">
                            </div>
                        </div>

                        <!-- Row 8 -->


                        <!-- Row 10 -->
                        <div class="row g-3 mt-1">
                            <div class="col-12 col-md-6">
                                <label class="form-label-soft">Educational Attainment</label>
                                <input type="text" name="educational_attainment" class="form-control form-modern" placeholder="Education" required>
                            </div>

                            <!-- row 11 -->
                            <div class="col-12 col-md-6">
                                <label class="form-label-soft">Eligibility</label>
                                <select name="eligibility" class="form-select form-modern" required>
                                    <option value="" selected disabled>Select Eligibility</option>
                                    <option value="PRO">PRO</option>
                                    <option value="NON PRO">NON PRO</option>
                                    <option value="PRC">PRC</option>
                                    <option value="NON">NON</option>
                                </select>
                            </div>
                        </div>

                        <!-- date of appointment -->



                        <!-- row 14 -->
                        <div class="mt-3">
                            <label class="form-label-soft">Remarks</label>
                            <textarea name="remarks" rows="6" class="form-control form-modern" placeholder="Write remarks..."></textarea>
                        </div>

                        <br>

                        <div id="serviceContainer">

                            <div class="service-row">

                                <!-- HEADER -->
                                <div class="form-card-header px-4 py-3 d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-3 d-flex align-items-center justify-content-center"
                                            style="width:38px;height:38px;background:rgba(13,110,253,.15);">
                                            <i class="bi bi-clipboard2-plus-fill text-primary"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-uppercase text-secondary small mb-0">Employee's Service Information</div>
                                            <div class="text-secondary" style="font-size:12px;">Add a service record</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3 mt-1">
                                    <!-- Department -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label-soft">Department</label>
                                        <select name="department[]" class="form-select form-modern" required>
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

                                    <!-- Designation -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label-soft">Designation</label>
                                        <select name="designation[]" class="form-select form-modern" required>
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
                                </div>

                                <div class="row g-3 mt-1">
                                    <div class="col-12 col-md-6">
                                        <label class="form-label-soft">Date of Appointment</label>
                                        <input type="date" name="date_of_appointment[]" class="form-control form-modern" required>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label class="form-label-soft">Status</label>
                                        <select name="status[]" class="form-select form-modern" required>
                                            <option value="" disabled selected>Select Status</option>
                                            <option value="Employed">Employed</option>
                                            <option value="Resigned/Retired">Resigned/Retired</option>
                                            <option value="Terminated">Terminated</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="d-flex gap-2 justify-content-center mt-4">
                                    <button type="button" class="btn btn-danger mt-3 removeService">Remove</button>
                                    <button type="button" class="btn btn-outline-primary mt-3 addService">+ Add Service Record</button>
                                </div>
                            </div>
                            <br>
                        </div>

                        <!-- Buttons (dashboard style: right side) -->
                        <div class="d-flex gap-2 justify-content-end mt-4">
                            <button type="reset" class="btn btn-light btn-pill">Clear</button>
                            <button type="submit" class="btn btn-primary btn-pill">
                                <i class="bi bi-check2-circle me-1"></i> Submit
                            </button>
                        </div>
                </div>

            </div>

            </form>
        </div>
    </div>

</div>
</div>

</div>
<script>
    const appointmentInput = document.getElementById('date_of_appointment');
    const serviceDurationInput = document.getElementById('service_duration');
    const statusSelect = document.getElementById('status');
    const endDateInput = document.getElementById('date_ended');
    const endDateContainer = document.getElementById('end_date_container');

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
        if (years > 0) parts.push(`${years} year${years !== 1 ? 's' : ''}`);
        if (months > 0) parts.push(`${months} month${months !== 1 ? 's' : ''}`);
        if (days > 0) parts.push(`${days} day${days !== 1 ? 's' : ''}`);
        return parts.length ? parts.join(', ') : '0 days';
    }

    function computeServiceDuration() {
        const startValue = appointmentInput.value;
        const status = statusSelect.value;

        if (!startValue) {
            serviceDurationInput.value = '';
            return;
        }

        const startDate = new Date(startValue + "T00:00:00");
        let endDate;

        if (status === "currently_working") {
            endDate = new Date(); // today
        } else {
            if (!endDateInput.value) {
                serviceDurationInput.value = 'Waiting for end date';
                return;
            }
            endDate = new Date(endDateInput.value + "T00:00:00");
        }

        if (startDate > endDate) {
            serviceDurationInput.value = 'Invalid dates';
            return;
        }

        serviceDurationInput.value = formatDuration(diffYMD(startDate, endDate));
    }

    // Show/hide Date Ended based on status
    function handleStatusChange() {
        const status = statusSelect.value;

        if (status === "currently_working") {
            endDateContainer.classList.add('d-none');
            endDateInput.value = '';
        } else {
            endDateContainer.classList.remove('d-none');
        }

        computeServiceDuration();
    }

    appointmentInput.addEventListener('change', computeServiceDuration);
    statusSelect.addEventListener('change', handleStatusChange);
    endDateInput.addEventListener('change', computeServiceDuration);

    // Initial check
    handleStatusChange();
</script>

<script src="<?= base_url('js/dynamic_service_records.js') ?>"></script>

<?= $this->endSection() ?>