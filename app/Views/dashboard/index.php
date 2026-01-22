    <?= $this->extend('template/index') ?>

    <?= $this->section('content') ?>

    <style>
        /* Make the card header clickable */
        .collapsible-header {
            cursor: pointer;
            user-select: none;
        }

        /* Pastikan .card-title memenuhi lebar container */
        .collapsible-header .card-title {
            width: 100%;
        }

        /* Add an arrow icon to the header title */
        .collapsible-header .card-title::after {
            content: '\f068';
            /* Kode Unicode untuk ikon "minus" di FA5 */
            font-family: 'Font Awesome 5 Solid';
            font-weight: 900;
            /* Penting untuk ikon Solid di FA5 */
            font-size: 12px;
            float: right;
            margin-left: 15px;
            transition: transform 0.3s ease;
        }

        /* The content to be hidden/shown */
        .collapsible-content {
            max-height: 1000px;
            overflow: hidden;
            transition: max-height 0.4s ease-in-out, padding 0.4s ease-in-out;
        }

        /* Style for when the card is minimized (inactive) */
        .card:not(.active) .collapsible-content {
            max-height: 0;
            padding-top: 0;
            padding-bottom: 0;
            border-top: none;
        }

        /* Change icon when minimized */
        .card:not(.active) .collapsible-header .card-title::after {
            content: '\f067';
            /* Kode Unicode untuk ikon "plus" di FA5 */
        }
    </style>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body ">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="fas fa-tablet"></i>
                                </div>
                            </div>
                            <div class="col col-stats ml-3 ml-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total IPad</p>
                                    <h4 class="card-title"><?= $count_all_ipad ?></h4>
                                    <a href="#tabel-class" class="badge badge-primary view-data-btn" data-target="#tabel-class">Lihat Data</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-info bubble-shadow-small">
                                    <i class="fa fa-book"></i>
                                </div>
                            </div>
                            <div class="col col-stats ml-3 ml-sm-0">
                                <div class="numbers">
                                    <p class="card-category">IPad dalam Pembelajaran</p>
                                    <h4 class="card-title"><?= $count_class_ipad ?></h4>
                                    <a href="#tabel-pembelajaran" class="badge badge-info view-data-btn" data-target="#tabel-pembelajaran">Lihat Data</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-success bubble-shadow-small">
                                    <i class="fa fa-university"></i>
                                </div>
                            </div>
                            <div class="col col-stats ml-3 ml-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total IPad Disimpan</p>
                                    <h4 class="card-title"><?= $count_rak_ipad ?></h4>
                                    <a href="#tabel-disimpan" class="badge badge-success view-data-btn" data-target="#tabel-disimpan">Lihat Data</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-warning bubble-shadow-small">
                                    <i class="fa fa-id-card"></i>
                                </div>
                            </div>
                            <div class="col col-stats ml-3 ml-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total IPad Dipinjam</p>
                                    <h4 class="card-title"><?= $count_rent_ipad ?></h4>
                                    <a href="#tabel-dipinjam" class="badge badge-warning view-data-btn" data-target="#tabel-dipinjam">Lihat Data</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel IPad dalam Pembelajaran -->
        <div class="row">
            <div class="col-md-12">
                <div id="tabel-pembelajaran" class="card collapsible-card">
                    <div class="card-header collapsible-header">
                        <div class="card-head-row">
                            <div class="card-title">Tabel IPad dalam Pembelajaran</div>
                        </div>
                    </div>
                    <div class="card-body collapsible-content">
                        <div class="table-responsive">
                            <table id="roles-table" class="table table-bordered table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th style="width:60px">No</th>
                                        <th>Name</th>
                                        <th>Kelas</th>
                                        <th>Model</th>
                                        <th>Note</th>
                                        <th>Nama Ibu</th>
                                        <th>Wa Ortu</th>
                                        <th>Walas Name</th>
                                        <th>Wa Walas</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($class_ipad as $row) : ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td><?= esc($row['student']) ?></td>
                                            <td><?= esc($row['class_name']) ?></td>
                                            <td><?= esc($row['model']) ?></td>
                                            <td><?= esc($row['note']) ?></td>
                                            <td><?= esc($row['mother_name']) ?></td>
                                            <td>
                                            <?php
                                            $wa_number = $row['whatsapp'];
                                            if (!empty($wa_number)) {
                                                // 1. Hapus semua karakter non-numerik
                                                $cleaned_number = preg_replace('/[^0-9]/', '', $wa_number);
                                                // 2. Jika nomor diawali '0', ganti dengan '62'
                                                if (substr($cleaned_number, 0, 1) === '0') {
                                                    $formatted_number = '62' . substr($cleaned_number, 1);
                                                } else {
                                                    $formatted_number = $cleaned_number;
                                                }
                                                // 3. Buat link jika nomor valid
                                                echo '<a href="https://wa.me/' . esc($formatted_number, 'url') . '" target="_blank" rel="noopener noreferrer">'
                                                    . esc($wa_number) . ' <i class="fab fa-whatsapp" style="color: #25D366;"></i>'
                                                    . '</a>';
                                            } else {
                                                echo '-'; // Tampilkan strip jika tidak ada nomor
                                            }
                                            ?>
                                        </td>

                                            <td><?= esc($row['dormitory_name']) ?></td>
                                            <td>
                                                <?php
                                                $dormitory_wa_number = $row['dormitory_wa'];
                                                if (!empty($dormitory_wa_number)) {
                                                    $cleaned_number = preg_replace('/[^0-9]/', '', $dormitory_wa_number);
                                                    if (substr($cleaned_number, 0, 1) === '0') {
                                                        $formatted_number = '62' . substr($cleaned_number, 1);
                                                    } else {
                                                        $formatted_number = $cleaned_number;
                                                    }
                                                    echo '<a href="https://wa.me/' . esc($formatted_number, 'url') . '" target="_blank" rel="noopener noreferrer">'
                                                        . esc($dormitory_wa_number) . ' <i class="fab fa-whatsapp" style="color: #25D366;"></i>'
                                                        . '</a>';
                                                } else {
                                                    echo '-';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $status = esc($row['status']);
                                                $badgeClass = ''; $iconClass = ''; $text = $status;
                                                switch ($status) {
                                                    case 'Pembelajaran': $badgeClass = 'badge-info'; $iconClass = 'fas fa-book'; break;
                                                    case 'Disimpan': $badgeClass = 'badge-success'; $iconClass = 'fas fa-archive'; break;
                                                    case 'Pinjam': $badgeClass = 'badge-warning'; $iconClass = 'fas fa-id-card'; $text = 'Dipinjam'; break;
                                                    default: $badgeClass = 'badge-light'; $iconClass = 'fas fa-question-circle'; break;
                                                }
                                                ?>
                                                <span class="badge <?= $badgeClass ?>"><i class="<?= $iconClass ?>"></i> <?= $text ?></span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel IPad Disimpan -->
        <div class="row">
            <div class="col-md-12">
                <div id="tabel-disimpan" class="card collapsible-card">
                    <div class="card-header collapsible-header">
                        <div class="card-head-row">
                            <div class="card-title">Tabel IPad DiSimpan</div>
                        </div>
                    </div>
                    <div class="card-body collapsible-content">
                        <div class="table-responsive">
                            <table id="roles-table2" class="table table-bordered table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th style="width:60px">No</th>
                                        <th>Name</th>
                                        <th>Kelas</th>
                                        <th>Model</th>
                                        <th>Note</th>
                                        <th>Nama Ibu</th>
                                        <th>Wa Ortu</th>
                                        <th>Nama Walas</th>
                                        <th>Wa Walas</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($rak_ipad as $row) : ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td><?= esc($row['student']) ?></td>
                                            <td><?= esc($row['class_name']) ?></td>
                                            <td><?= esc($row['model']) ?></td>
                                            <td><?= esc($row['note']) ?></td>
                                            <td><?= esc($row['mother_name']) ?></td>
                                            <td>
                                            <?php
                                            $wa_number = $row['whatsapp'];
                                            if (!empty($wa_number)) {
                                                // 1. Hapus semua karakter non-numerik
                                                $cleaned_number = preg_replace('/[^0-9]/', '', $wa_number);
                                                // 2. Jika nomor diawali '0', ganti dengan '62'
                                                if (substr($cleaned_number, 0, 1) === '0') {
                                                    $formatted_number = '62' . substr($cleaned_number, 1);
                                                } else {
                                                    $formatted_number = $cleaned_number;
                                                }
                                                // 3. Buat link jika nomor valid
                                                echo '<a href="https://wa.me/' . esc($formatted_number, 'url') . '" target="_blank" rel="noopener noreferrer">'
                                                    . esc($wa_number) . ' <i class="fab fa-whatsapp" style="color: #25D366;"></i>'
                                                    . '</a>';
                                            } else {
                                                echo '-'; // Tampilkan strip jika tidak ada nomor
                                            }
                                            ?>
                                        </td>

                                            <td><?= esc($row['dormitory_name']) ?></td>
                                            <td>
                                                <?php
                                                $dormitory_wa_number = $row['dormitory_wa'];
                                                if (!empty($dormitory_wa_number)) {
                                                    $cleaned_number = preg_replace('/[^0-9]/', '', $dormitory_wa_number);
                                                    if (substr($cleaned_number, 0, 1) === '0') {
                                                        $formatted_number = '62' . substr($cleaned_number, 1);
                                                    } else {
                                                        $formatted_number = $cleaned_number;
                                                    }
                                                    echo '<a href="https://wa.me/' . esc($formatted_number, 'url') . '" target="_blank" rel="noopener noreferrer">'
                                                        . esc($dormitory_wa_number) . ' <i class="fab fa-whatsapp" style="color: #25D366;"></i>'
                                                        . '</a>';
                                                } else {
                                                    echo '-';
                                                }
                                                ?>
                                            </td>   
                                            <td>
                                                <?php
                                                $status = esc($row['status']);
                                                $badgeClass = ''; $iconClass = ''; $text = $status;
                                                switch ($status) {
                                                    case 'Pembelajaran': $badgeClass = 'badge-info'; $iconClass = 'fas fa-book'; break;
                                                    case 'Disimpan': $badgeClass = 'badge-success'; $iconClass = 'fas fa-archive'; break;
                                                    case 'Pinjam': $badgeClass = 'badge-warning'; $iconClass = 'fas fa-id-card'; $text = 'Dipinjam'; break;
                                                    default: $badgeClass = 'badge-light'; $iconClass = 'fas fa-question-circle'; break;
                                                }
                                                ?>
                                                <span class="badge <?= $badgeClass ?>"><i class="<?= $iconClass ?>"></i> <?= $text ?></span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel IPad Dipinjam -->
        <div class="row">
            <div class="col-md-12">
                <div id="tabel-dipinjam" class="card collapsible-card">
                    <div class="card-header collapsible-header">
                        <div class="card-head-row">
                            <div class="card-title">Tabel IPad Dipinjam</div>
                        </div>
                    </div>
                    <div class="card-body collapsible-content">
                        <div class="table-responsive">
                            <table id="roles-table3" class="table table-bordered table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th style="width:60px">No</th>
                                        <th>Name</th>
                                        <th>Kelas</th>
                                        <th>Model</th>
                                        <th>Note</th>
                                        <th>Tanggal Pengembalian</th>
                                        <th>Keterangan</th>
                                        <th>Nama Ibu</th>
                                        <th>Wa Ortu</th>
                                        <th>Nama Walas</th>
                                        <th>Wa Walas</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($rent_ipad as $row) : ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td><?= esc($row['student']) ?></td>
                                            <td><?= esc($row['class_name']) ?></td>
                                            <td><?= esc($row['model']) ?></td>
                                            <td><?= esc($row['note']) ?></td>
                                            <td><?= esc($row['pengembalian']) ?></td>
                                            <td><?= esc($row['ket']) ?></td>
                                            <td><?= esc($row['mother_name']) ?></td>
                                            <td>
                                            <?php
                                            $wa_number = $row['whatsapp'];
                                            if (!empty($wa_number)) {
                                                // 1. Hapus semua karakter non-numerik
                                                $cleaned_number = preg_replace('/[^0-9]/', '', $wa_number);
                                                // 2. Jika nomor diawali '0', ganti dengan '62'
                                                if (substr($cleaned_number, 0, 1) === '0') {
                                                    $formatted_number = '62' . substr($cleaned_number, 1);
                                                } else {
                                                    $formatted_number = $cleaned_number;
                                                }
                                                // 3. Buat link jika nomor valid
                                                echo '<a href="https://wa.me/' . esc($formatted_number, 'url') . '" target="_blank" rel="noopener noreferrer">'
                                                    . esc($wa_number) . ' <i class="fab fa-whatsapp" style="color: #25D366;"></i>'
                                                    . '</a>';
                                            } else {
                                                echo '-'; // Tampilkan strip jika tidak ada nomor
                                            }
                                            ?>
                                        </td>

                                            <td><?= esc($row['dormitory_name']) ?></td>
                                            <td>
                                                <?php
                                                $dormitory_wa_number = $row['dormitory_wa'];
                                                if (!empty($dormitory_wa_number)) {
                                                    $cleaned_number = preg_replace('/[^0-9]/', '', $dormitory_wa_number);
                                                    if (substr($cleaned_number, 0, 1) === '0') {
                                                        $formatted_number = '62' . substr($cleaned_number, 1);
                                                    } else {
                                                        $formatted_number = $cleaned_number;
                                                    }
                                                    echo '<a href="https://wa.me/' . esc($formatted_number, 'url') . '" target="_blank" rel="noopener noreferrer">'
                                                        . esc($dormitory_wa_number) . ' <i class="fab fa-whatsapp" style="color: #25D366;"></i>'
                                                        . '</a>';
                                                } else {
                                                    echo '-';
                                                }
                                                ?>
                                            </td>   
                                            <td>
                                                <?php
                                                $status = esc($row['status']);
                                                $badgeClass = ''; $iconClass = ''; $text = $status;
                                                switch ($status) {
                                                    case 'Pembelajaran': $badgeClass = 'badge-info'; $iconClass = 'fas fa-book'; break;
                                                    case 'Disimpan': $badgeClass = 'badge-success'; $iconClass = 'fas fa-archive'; break;
                                                    case 'Pinjam': $badgeClass = 'badge-warning'; $iconClass = 'fas fa-id-card'; $text = 'Dipinjam'; break;
                                                    default: $badgeClass = 'badge-light'; $iconClass = 'fas fa-question-circle'; break;
                                                }
                                                ?>
                                                <span class="badge <?= $badgeClass ?>"><i class="<?= $iconClass ?>"></i> <?= $text ?></span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Data Siswa Per Kelas -->
        <div class="row">
            <div class="col-md-12">
                <div id="tabel-class" class="card collapsible-card">
                    <div class="card-header collapsible-header">
                        <div class="card-head-row">
                            <div class="card-title">Tabel Data Siswa Per Kelas</div>
                        </div>
                    </div>
                    <div class="card-body collapsible-content">
                        <!-- FORM FILTER -->
                        <form id="filter-class-form" class="form-inline mb-4">
                            <label for="select-class" class="mr-2">Pilih Kelas:</label>
                            <select class="form-control mr-2" id="select-class" name="class_id" required>
                                <option value="">-- Pilih Kelas --</option>
                                <?php foreach ($classes as $class) : ?>
                                    <option value="<?= $class['id'] ?>"><?= esc($class['class_name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                            
                            <label for="select-status" class="mr-2">Pilih Status:</label>
                            <select class="form-control mr-2" id="select-status" name="status_id" required>
                                <option value="">-- Pilih Status --</option>
                                    <option value="All">Semua Status</option>
                                    <option value="Pembelajaran">Pembelajaran</option>
                                    <option value="Disimpan">Disimpan</option>
                                    <option value="Pinjam">Pinjam</option>
                            </select>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-filter"></i> Filter
                            </button>
                        </form>

                        <!-- TABEL UNTUK DATA SISWA -->
                        <div class="table-responsive">
                            <table id="class-student-table" class="table table-bordered table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th style="width:60px">No</th>
                                        <th>NIS</th>
                                        <th>Nama Siswa</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Kelas</th>
                                        <th>Tanggal Pengembalian</th>
                                        <th>Keterangan</th>
                                        <th>Nama Ibu</th>
                                        <th>Wa Ortu</th>
                                        <th>Nama Walas</th>
                                        <th>Wa Walas</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="student-data-body">
                                    <tr>
                                        <td colspan="12" class="text-center">Pilih kelas dan klik filter untuk menampilkan data.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= $this->endSection() ?>

    <?= $this->section('scripts') ?>
    <script>
    $(document).ready(function() {

        // Inisialisasi DataTable untuk tabel yang sudah ada
        $('#roles-table').DataTable({
            scrollY: '50vh',
            scrollX: true,
            scrollCollapse: true,
        });
        $('#roles-table2').DataTable({
            scrollY: '50vh',
            scrollX: true,
            scrollCollapse: true,
        });
        $('#roles-table3').DataTable({
            scrollY: '50vh',
            scrollX: true,
            scrollCollapse: true,
        });

        // --- FUNGSI UNTUK COLLAPSIBLE CARD ---
        $('.collapsible-header').on('click', function() {
            $(this).closest('.card').toggleClass('active');
        });

        $('.view-data-btn').on('click', function(e) {
            e.preventDefault();
            var targetId = $(this).data('target');
            var $targetCard = $(targetId);
            if ($targetCard.length) {
                $('.collapsible-card.active').not($targetCard).removeClass('active');
                $targetCard.toggleClass('active');
                if ($targetCard.hasClass('active')) {
                    $('html, body').animate({
                        scrollTop: $targetCard.offset().top - 80
                    }, 500);
                }
            }
        });


        let studentTable; // Variabel untuk menyimpan instance DataTable

        $('#filter-class-form').on('submit', function(e) {
            e.preventDefault();

            const classId = $('#select-class').val();
            const statusId = $('#select-status').val();
            const filterButton = $(this).find('button[type="submit"]');

            if (!classId) {
                alert('Silakan pilih kelas terlebih dahulu.');
                return;
            }
            if (!statusId) {
                alert('Silakan pilih Status terlebih dahulu.');
                return;
            }

            filterButton.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memuat...');

            $.ajax({
                url: '<?= base_url('superadmin/getStudentsByClass') ?>',
                type: 'POST',
                data: {
                    class_id: classId,
                    status_id: statusId
                },
                dataType: 'json',
                success: function(response) {

                    if (studentTable) {
                        studentTable.destroy();
                        studentTable = null;
                    }

                    const tableBody = $('#student-data-body');
                    tableBody.empty();
                    
                    if (response && response.length > 0) {
                        $.each(response, function(index, student) {

                            // --- 1. Logika untuk membuat link WhatsApp Ibu ---
                            let whatsappHtml = '-';
                            if (student.whatsapp) {
                                let cleanedNumber = String(student.whatsapp).replace(/[^0-9]/g, '');
                                let formattedNumber = cleanedNumber;
                                if (cleanedNumber.startsWith('0')) {
                                    formattedNumber = '62' + cleanedNumber.substring(1);
                                }
                                whatsappHtml = `<a href="https://wa.me/${formattedNumber}" target="_blank" rel="noopener noreferrer">
                                                    ${student.whatsapp} <i class="fab fa-whatsapp" style="color: #25D366;"></i>
                                               </a>`;
                            }

                            // --- 2. Logika untuk membuat link WhatsApp Asrama/Walas ---
                            let dormitoryWaHtml = '-';
                            if (student.dormitory_wa) {
                                let cleanedNumber = String(student.dormitory_wa).replace(/[^0-9]/g, '');
                                let formattedNumber = cleanedNumber;
                                if (cleanedNumber.startsWith('0')) {
                                    formattedNumber = '62' + cleanedNumber.substring(1);
                                }
                                dormitoryWaHtml = `<a href="https://wa.me/${formattedNumber}" target="_blank" rel="noopener noreferrer">
                                                      ${student.dormitory_wa} <i class="fab fa-whatsapp" style="color: #25D366;"></i>
                                                   </a>`;
                            }

                            // --- 3. Logika untuk badge status ---
                            let statusBadge = '<span class="badge badge-light">-</span>';
                            if (student.status_ipad) { 
                                let badgeClass = '', iconClass = '', text = student.status_ipad;
                                switch (student.status_ipad) {
                                    case 'Pembelajaran': badgeClass = 'badge-info'; iconClass = 'fas fa-book'; break;
                                    case 'Disimpan': badgeClass = 'badge-success'; iconClass = 'fas fa-archive'; break;
                                    case 'Pinjam': badgeClass = 'badge-warning'; iconClass = 'fas fa-id-card'; text = 'Dipinjam'; break;
                                    default: badgeClass = 'badge-secondary'; iconClass = 'fas fa-question-circle'; break;
                                }
                                statusBadge = `<span class="badge ${badgeClass}"><i class="${iconClass}"></i> ${text}</span>`;
                            }

                            // =======================================================================
                            // PERUBAHAN UTAMA: Struktur baris tabel disesuaikan dengan permintaan Anda
                            // =======================================================================
                            const row = `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${student.nis || '-'}</td>
                                    <td>${student.name || '-'}</td>
                                    <td>${student.gender || '-'}</td>
                                    <td>${student.class_name || '-'}</td>
                                    <td>${student.pengembalian || '-'}</td>
                                    <td>${student.ket || '-'}</td>
                                    <td>${student.mother_name || '-'}</td>
                                    <td>${whatsappHtml}</td>
                                    <td>${student.dormitory_name || '-'}</td>
                                    <td>${dormitoryWaHtml}</td>
                                    <td>${statusBadge}</td>
                                </tr>
                            `;
                            tableBody.append(row);
                        });

                        studentTable = $('#class-student-table').DataTable({
                            "pageLength": 10,
                            scrollY: '50vh',
                            scrollX: true,
                            scrollCollapse: true,
                        });

                    } else {
                        // Menyesuaikan colspan agar sesuai dengan jumlah kolom yang baru (11)
                        tableBody.html('<tr><td colspan="12" class="text-center">Tidak ada data siswa yang cocok dengan filter ini.</td></tr>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: ", status, error);
                    if (studentTable) {
                        studentTable.destroy();
                        studentTable = null;
                    }
                    // Sesuaikan colspan di sini juga
                    $('#student-data-body').html('<tr><td colspan="12" class="text-center text-danger">Gagal memuat data. Silakan coba lagi.</td></tr>');
                },
                complete: function() {
                    filterButton.prop('disabled', false).html('<i class="fa fa-filter"></i> Filter');
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>
