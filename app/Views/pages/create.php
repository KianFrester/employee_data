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
                        <div class="row g-3 mt-1">
                            <!-- Department -->
                            <div class="col-12 col-md-6">
                                <label class="form-label-soft">Department</label>
                                <select name="department" class="form-select form-modern" required>
                                    <option value="" selected disabled>Select Department</option>
                                    <option value="accounting_office">Accounting Office</option>
                                    <option value="administrators_office">Administrator's Office</option>
                                    <option value="agriculture_office">Agriculture Office</option>
                                    <option value="assessor">Assessor</option>
                                    <option value="bir">BIR</option>
                                    <option value="bfp">BFP</option>
                                    <option value="bolinao_water_works">Bolinao Water Works System</option>
                                    <option value="budget">Budget</option>
                                    <option value="coa">COA</option>
                                    <option value="comelec">Comelec</option>
                                    <option value="dilg">DILG</option>
                                    <option value="engineering_office">Engineering Office</option>
                                    <option value="gad">GAD</option>
                                    <option value="garbage_collection">Garbage Collection</option>
                                    <option value="gso">GSO</option>
                                    <option value="hrmo">HRMO</option>
                                    <option value="lcr">LCR</option>
                                    <option value="market_slaughter">Market/Slaughter</option>
                                    <option value="mdrrmo">MDRRMO</option>
                                    <option value="mpdc">MPDC</option>
                                    <option value="mswd_stac">MSWD/STAC</option>
                                    <option value="mayors_office">Mayor's Office</option>
                                    <option value="peso">PESO</option>
                                    <option value="pnp">PNP</option>
                                    <option value="rhu">RHU</option>
                                    <option value="sb_municipal_library">SB/Municipal Library</option>
                                    <option value="sanitary_land_filling">Sanitary Land Filling</option>
                                    <option value="street_cleaning">Street Cleaning</option>
                                    <option value="traffic_enforcement">Traffic Enforcement</option>
                                    <option value="tourism_office">Tourism Office</option>
                                    <option value="treasurer_office">Treasurer Office</option>
                                </select>
                            </div>

                            <!-- Designation -->
                            <div class="col-12 col-md-6">
                                <label class="form-label-soft">Designation</label>
                                <select name="designation" class="form-select form-modern" required>
                                    <option value="" selected disabled>Select Designation</option>
                                    <option value="aircon_maintenance">Aircon Maintenance</option>
                                    <option value="backhoe_operator">Backhoe Operator</option>
                                    <option value="beach_ward">Beach Ward</option>
                                    <option value="building_guard">Building Guard</option>
                                    <option value="caregiver">Caregiver</option>
                                    <option value="carpenter">Carpenter</option>
                                    <option value="clerk">Clerk</option>
                                    <option value="computer_technician">Computer Technician</option>
                                    <option value="daycare_teacher">Daycare Teacher</option>
                                    <option value="driver">Driver</option>
                                    <option value="electrician">Electrician</option>
                                    <option value="encoder">Encoder</option>
                                    <option value="engineering_brigade">Engineering Brigade</option>
                                    <option value="focal_person_senior_citizen">Focal Person for Senior Citizen</option>
                                    <option value="financial_assistance_staff">Financial Assistance Staff</option>
                                    <option value="first_responder">First Responder</option>
                                    <option value="gad_personnel">GAD Personnel</option>
                                    <option value="heavy_equipment_operator">Heavy Equipment Operator</option>
                                    <option value="laboratory_assistant">Laboratory Assistant</option>
                                    <option value="laboratory_technician">Laboratory Technician</option>
                                    <option value="market_aide">Market Aide</option>
                                    <option value="market_cleaner">Market Cleaner</option>
                                    <option value="market_watchman">Market Watchman</option>
                                    <option value="mechanic">Mechanic</option>
                                    <option value="midwife_assistant">Midwife Assistant</option>
                                    <option value="nurse">Nurse</option>
                                    <option value="nursing_assistant">Nursing Assistant</option>
                                    <option value="osca_head">OSCA Head</option>
                                    <option value="plumber">Plumber</option>
                                    <option value="pump_tender">Pump Tender</option>
                                    <option value="pumping_station_guard">Pumping Station Guard</option>
                                    <option value="recorder">Recorder</option>
                                    <option value="rescue_personnel">Rescue Personnel</option>
                                    <option value="school_guard">School Guard</option>
                                    <option value="security">Security</option>
                                    <option value="sped_teacher">SPED Teacher</option>
                                    <option value="spring_guard">Spring Guard</option>
                                    <option value="street_cleaner">Street Cleaner</option>
                                    <option value="traffic_enforcer">Traffic Enforcer</option>
                                    <option value="utility_worker">Utility Worker</option>
                                    <option value="shadow_teacher">Shadow Teacher</option>
                                    <option value="stac_staff">STAC Staff</option>
                                    <option value="teacher_child_development">Child Development Teacher</option>
                                    <option value="tourism_aide">Tourism Aide</option>
                                    <option value="maintenance_personnel">Maintenance Personnel</option>
                                </select>
                            </div>

                        </div>

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
                                    <option value="pro">PRO</option>
                                    <option value="non_pro">NON-PRO</option>
                                    <option value="prc">PRC</option>
                                    <option value="non">NON</option>
                                </select>
                            </div>
                        </div>

                        <!-- Row 12 -->
                        <div class="row g-3 mt-1">
                            <div class="col-12 col-md-6">
                                <label class="form-label-soft">Date of Appointment</label>
                                <input type="date" name="date_of_appointment" class="form-control form-modern" required>
                            </div>

                            <!-- row 13 -->
                            <div class="col-12 col-md-6">
                                <label class="form-label-soft">Service Duration</label>
                                <input type="text" name="service_duration" class="form-control form-modern" placeholder="e.g., 3 years" required>
                            </div>
                        </div>

                        <!-- row 14 -->
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