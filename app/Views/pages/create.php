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

                <!-- Names -->
                <div class="row g-3 mb-3">
                    <div class="col-md-3">
                        <input type="text" name="first_name" class="form-control form-control-lg rounded-pill" placeholder="First Name">
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="middle_name" class="form-control form-control-lg rounded-pill" placeholder="Middle Name">
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="last_name" class="form-control form-control-lg rounded-pill" placeholder="Last Name">
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="ext" class="form-control form-control-lg rounded-pill" placeholder="Ext.">
                    </div>
                </div>

                <!-- Department -->
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <input type="text" name="department" class="form-control form-control-lg rounded-pill" placeholder="Department">
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="designation" class="form-control form-control-lg rounded-pill" placeholder="Designation">
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="rate" class="form-control form-control-lg rounded-pill" placeholder="Rate">
                    </div>
                </div>

                <!-- Eligibility -->
                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <input type="text" name="eligibility" class="form-control form-control-lg rounded-pill" placeholder="Eligibility">
                    </div>
                    <div class="col-md-4">
                        <input type="date" name="date_appointment" class="form-control form-control-lg rounded-pill">
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="service_duration" class="form-control form-control-lg rounded-pill" placeholder="Service Duration">
                    </div>
                </div>

                <!-- Remarks -->
                <div class="mb-4">
                    <textarea name="remarks" rows="6" class="form-control form-control-lg rounded-4" placeholder="Remarks"></textarea>
                </div>

                <!-- Buttons -->
                <div class="d-flex justify-content-center gap-4">
                    <button type="submit" class="btn btn-primary btn-lg px-5 rounded-pill">
                        SUBMIT
                    </button>
                    <button type="reset" class="btn btn-danger btn-lg px-5 rounded-pill">
                        CLEAR
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<?= $this->endSection() ?>
