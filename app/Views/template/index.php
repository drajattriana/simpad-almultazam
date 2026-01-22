<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>SIMPAD | AL-MULTAZAM</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="<?= base_url('assets/img/logo.png') ?>" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="<?= base_url('assets/js/plugin/webfont/webfont.min.js') ?>"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Open+Sans:300,400,600,700"]
            },
            custom: {
                "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands"],
                urls: ['<?= base_url('assets/css/fonts.css') ?>']
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/azzara.min.css') ?>">

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="<?= base_url('assets/css/demo.css') ?>">
</head>

<body>
    <div class="wrapper">

        <?= $this->include('template/header') ?>

        <?= $this->include('template/sidebar') ?>

        <div class="main-panel">
            <div class="content">
                <div class="page-inner">
                    <div class="page-header">
                        <h4 class="page-title"><?= $title ?></h4>
                        <ul class="breadcrumbs">
                            <li class="nav-home">
                                <a href="<?= base_url() ?>">
                                    <i class="flaticon-home"></i>
                                </a>
                            </li>
                            <li class="separator">
                                <i class="flaticon-right-arrow"></i>
                            </li>
                            <li class="nav-item">
                                <a><?= $title ?></a>
                            </li>
                    </div>
                    <div class="row">
                        <?= $this->renderSection('content') ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Custom template | don't include it in your project! -->
        <!-- <div class="custom-template">
			<div class="title">Settings</div>
			<div class="custom-content">
				<div class="switcher">
					<div class="switch-block">
						<h4>Topbar</h4>
						<div class="btnSwitch">
							<button type="button" class="changeMainHeaderColor" data-color="blue"></button>
							<button type="button" class="selected changeMainHeaderColor" data-color="purple"></button>
							<button type="button" class="changeMainHeaderColor" data-color="light-blue"></button>
							<button type="button" class="changeMainHeaderColor" data-color="green"></button>
							<button type="button" class="changeMainHeaderColor" data-color="orange"></button>
							<button type="button" class="changeMainHeaderColor" data-color="red"></button>
						</div>
					</div>
					<div class="switch-block">
						<h4>Background</h4>
						<div class="btnSwitch">
							<button type="button" class="changeBackgroundColor" data-color="bg2"></button>
							<button type="button" class="changeBackgroundColor selected" data-color="bg1"></button>
							<button type="button" class="changeBackgroundColor" data-color="bg3"></button>
						</div>
					</div>
				</div>
			</div>
			<div class="custom-toggle">
				<i class="flaticon-settings"></i>
			</div>
		</div> -->
        <!-- End Custom template -->
    </div>
    <!--   Core JS Files   -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="<?= base_url('assets/js/core/popper.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/core/bootstrap.min.js') ?>"></script>

    <!-- jQuery UI -->
    <script src="<?= base_url('assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js') ?>"></script>

    <!-- jQuery Scrollbar -->
    <script src="<?= base_url('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') ?>"></script>

    <!-- Moment JS -->
    <script src="<?= base_url('assets/js/plugin/moment/moment.min.js') ?>"></script>

    <!-- Chart JS -->
    <script src="<?= base_url('assets/js/plugin/chart.js/chart.min.js') ?>"></script>

    <!-- jQuery Sparkline -->
    <script src="<?= base_url('assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') ?>"></script>

    <!-- Chart Circle -->
    <script src="<?= base_url('assets/js/plugin/chart-circle/circles.min.js') ?>"></script>

    <!-- Datatables -->
    <script src="<?= base_url('assets/js/plugin/datatables/datatables.min.js') ?>"></script>

    <!-- Bootstrap Notify -->
    <script src="<?= base_url('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') ?>"></script>

    <!-- Bootstrap Toggle -->
    <script src="<?= base_url('assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js') ?>"></script>

    <!-- Azzara JS -->
    <script src="<?= base_url('assets/js/ready.min.js') ?>"></script>

    <!-- Azzara DEMO methods, don't include it in your project! -->
    <script src="<?= base_url('assets/js/setting-demo.js') ?>"></script>
    <!-- <script src="< ?= base_url ('assets/js/demo.js')?>"></script> -->


    <?= $this->renderSection('scripts') ?>

</body>

</html>