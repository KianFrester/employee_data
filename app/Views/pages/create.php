<?= $this->extend('main/master') ?>
<?= $this->section('content') ?>
<?= $this->include('main/navbar') ?>

<div class="container my-5">
    <div class="card shadow-lg rounded-4">

        <!-- Header -->
        <div class="card-header bg-primary text-white text-center fs-4 fw-bold rounded-top-4 py-3">
            ADD RECORD
        </div>

        <!-- Body -->
        <div class="card-body p-4">

            <form method="post" action="<?= site_url('save-record') ?>">

                <!-- Names, Birthdate, Gender -->
                <div class="row g-3 mb-3">
                    <div class="col-md-2">
                        <label class="form-label">First Name</label>
                        <input type="text" name="first_name" class="form-control form-control-lg rounded-pill" placeholder="First Name">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Middle Name</label>
                        <input type="text" name="middle_name" class="form-control form-control-lg rounded-pill" placeholder="Middle Name">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Last Name</label>
                        <input type="text" name="last_name" class="form-control form-control-lg rounded-pill" placeholder="Last Name">
                    </div>
                    <div class="col-md-1">
                        <label class="form-label">Ext.</label>
                        <input type="text" name="ext" class="form-control form-control-lg rounded-pill" placeholder="Ext.">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Birthdate</label>
                        <input type="date" name="birthdate" class="form-control form-control-lg rounded-pill">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-select form-select-lg rounded-pill">
                            <option value="" selected disabled>Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                </div>

                <!-- Department + Educational Attainment + Designation + Rate -->
                <div class="row g-3 mb-3">
                    <div class="col-md-3">
                        <label class="form-label">Department</label>
                        <input type="text" name="department" class="form-control form-control-lg rounded-pill" placeholder="Department">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Designation</label>
                        <input type="text" name="designation" class="form-control form-control-lg rounded-pill" placeholder="Designation">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Educational Attainment</label>
                        <select name="education" class="form-select form-select-lg rounded-pill">
                            <option value="" selected disabled>Select Education</option>
                            <option value="Elementary">Elementary</option>
                            <option value="High School">High School</option>
                            <option value="College">College</option>
                            <option value="Vocational">Vocational</option>
                            <option value="Graduate">Graduate</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Rate</label>
                        <input type="text" name="rate" class="form-control form-control-lg rounded-pill" placeholder="Rate">
                    </div>
                </div>

                <!-- Eligibility, Date of Appointment, Service Duration -->
                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Eligibility</label>
                        <input type="text" name="eligibility" class="form-control form-control-lg rounded-pill" placeholder="Eligibility">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Date of Appointment</label>
                        <input type="date" name="date_appointment" class="form-control form-control-lg rounded-pill">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Service Duration</label>
                        <input type="text" name="service_duration" class="form-control form-control-lg rounded-pill" placeholder="Service Duration">
                    </div>
                </div>

                <!-- Remarks -->
                <div class="mb-4">
                    <label class="form-label">Remarks</label>
                    <textarea name="remarks" rows="6" class="form-control form-control-lg rounded-4" placeholder="Remarks"></textarea>
                </div>

                <!-- Buttons -->
                <div class="d-flex justify-content-center gap-4">
                    <button type="submit" class="btn btn-primary btn-lg px-5 rounded-pill">SUBMIT</button>
                    <button type="reset" class="btn btn-danger btn-lg px-5 rounded-pill">CLEAR</button>
                </div>

            </form>

        </div>
    </div>
</div>

<?= $this->endSection() ?>