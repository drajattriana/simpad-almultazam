<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Judul Default' ?></title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/adminlte.css') ?>">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
</head>
  <body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">

    <!--begin::App Wrapper-->
    <div class="app-wrapper">

        <?= $this->include('template/topbar') ?>

        <?= $this->include('template/sidebar') ?>

         <main class="app-main">
            <?= $this->renderSection('content') ?>
        </main>

        <?= $this->include('template/footer') ?>
