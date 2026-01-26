<?= $this->extend('main/master'); ?>
<?= $this->section('content'); ?>
<?= $this->include('main/navbar'); ?>

<div class="container-fluid my-4 px-4">

    <!-- ===== DASHBOARD TITLE ===== -->
    <div class="mb-4 text-center">
        <h2 class="fw-bold text-primary">Dashboard</h2>
        <hr>
    </div>

    <!-- ===== SUMMARY CARDS ===== -->
    <div class="row g-4">

        <!-- GENDER -->
        <div class="col-md-6">
            <div class="card shadow rounded-4">
                <div class="card-header bg-primary text-white text-center fw-bold fs-5 rounded-top-4">
                    GENDER
                </div>
                <div class="card-body text-center">
                    <div class="row">
                        <div class="col">
                            <h6 class="fw-bold">MALE</h6>
                            <div class="bg-info text-white fs-3 fw-bold py-4 rounded">
                                10
                            </div>
                        </div>
                        <div class="col">
                            <h6 class="fw-bold">FEMALE</h6>
                            <div class="text-white fs-3 fw-bold py-4 rounded" style="background:#ff1493;">
                                5
                            </div>
                        </div>
                    </div>
                    <a href="#" class="d-block mt-3 fw-bold text-primary">VIEW ALL</a>
                </div>
            </div>
        </div>

        <!-- ELIGIBILITY -->
        <div class="col-md-6">
            <div class="card shadow rounded-4">
                <div class="card-header bg-primary text-white text-center fw-bold fs-5 rounded-top-4">
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
                    </div>
                    <a href="#" class="d-block mt-3 fw-bold text-primary">VIEW ALL</a>
                </div>
            </div>
        </div>

        <!-- AGE -->
        <div class="col-md-6">
            <div class="card shadow rounded-4">
                <div class="card-header bg-primary text-white text-center fw-bold fs-5 rounded-top-4">
                    AGE
                </div>
                <div class="card-body text-center">
                    <div class="row row-cols-5 g-2">
                        <?php foreach (['18-30','31-40','41-50','51-60','60+'] as $age): ?>
                        <div class="col">
                            <small class="fw-bold"><?= $age ?></small>
                            <div class="bg-info text-white fw-bold py-4 rounded">10</div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <a href="#" class="d-block mt-3 fw-bold text-primary">VIEW ALL</a>
                </div>
            </div>
        </div>

        <!-- EDUCATION -->
        <div class="col-md-6">
            <div class="card shadow rounded-4">
                <div class="card-header bg-primary text-white text-center fw-bold fs-5 rounded-top-4">
                    EDUCATIONAL ATTAINMENT
                </div>
                <div class="card-body text-center">
                    <div class="row row-cols-5 g-2">
                        <?php foreach (['ELEM','HS','COLLEGE','VOC','GRAD'] as $edu): ?>
                        <div class="col">
                            <small class="fw-bold"><?= $edu ?></small>
                            <div class="bg-info text-white fw-bold py-4 rounded">10</div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <a href="#" class="d-block mt-3 fw-bold text-primary">VIEW ALL</a>
                </div>
            </div>
        </div>

    </div>

    <!-- ===== TABLES ===== -->
    <div class="row g-4 mt-5">

        <div class="col-md-6">
            <div class="card shadow rounded-4">
                <div class="card-header bg-primary text-white fw-bold">
                    Gender Breakdown
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>Gender</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>Male</td><td>10</td></tr>
                            <tr><td>Female</td><td>5</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow rounded-4">
                <div class="card-header bg-primary text-white fw-bold">
                    Eligibility
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>Type</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>PRO</td><td>10</td></tr>
                            <tr><td>NONPRO</td><td>10</td></tr>
                            <tr><td>PRC</td><td>10</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow rounded-4">
                <div class="card-header bg-primary text-white fw-bold">
                    Age Groups
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>Age Range</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>18-30</td><td>10</td></tr>
                            <tr><td>31-40</td><td>10</td></tr>
                            <tr><td>41-50</td><td>10</td></tr>
                            <tr><td>51-60</td><td>10</td></tr>
                            <tr><td>60+</td><td>10</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow rounded-4">
                <div class="card-header bg-primary text-white fw-bold">
                    Educational Attainment
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>Level</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>Elementary</td><td>10</td></tr>
                            <tr><td>High School</td><td>10</td></tr>
                            <tr><td>College</td><td>10</td></tr>
                            <tr><td>Vocational</td><td>10</td></tr>
                            <tr><td>Graduate</td><td>10</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>

<?= $this->endSection(); ?>
