<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('css/dashboard.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('node_modules/bootstrap/dist/css/bootstrap.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('node_modules/bootstrap-icons/font/bootstrap-icons.css') ?>">
</head>

<body>
    <main>
        <?= $this->renderSection('content') ?>
        <img src="<?= base_url('assets/images/munibuilding.png') ?>" class="shadow-lg" style="position:fixed; width: 100vw; height: 100vh; top:0;left:0;z-index:-2; filter: blur(8px); -webkit-filter: blur(8px);">
    </main>

    <script>
        window.ASSET_BASE = "<?= base_url() ?>";
    </script>

    <script src="<?= base_url('js/print_base.js') ?>"></script>
     <script src="<?= base_url('js/print_age_table.js') ?>"></script>
      <script src="<?= base_url('js/print_gender_table.js') ?>"></script>
       <script src="<?= base_url('js/print_base.js') ?>"></script>
        <script src="<?= base_url('js/print_base.js') ?>"></script>


    <script src="<?php echo base_url('node_modules/bootstrap/dist/js/bootstrap.bundle.js') ?>"></script>
</body>

</html>