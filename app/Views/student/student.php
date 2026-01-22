<?= $this->extend('template/index') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!--begin::Row-->
    <div class="row">
        <div class="col-12">
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tabel Data <?= $title ?></h3>
                    <div class="card-tools gap-2 mt-3 pb-3">
                        <button class="btn btn-success form-control mb-2" data-toggle="modal" data-target="#importModal">+ Import Data</button>
                        <button class="btn btn-info form-control" data-toggle="modal" data-target="#addRowModal">+ Tambah Data</button>
                    </div>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table id="roles-table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIS</th>
                                    <th>Name</th>
                                    <th>Class</th>
                                    <th>Gender</th>
                                    <th>Nama Ibu</th>
                                    <th>No Ortu</th>
                                    <th>Wali Asrama</th>
                                    <th>No Walas</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($student as $row) : ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= esc($row['nis']) ?></td>
                                        <td><?= esc($row['name']) ?></td>
                                        <td><?= esc($row['class']) ?></td>
                                        <td><?= esc($row['gender']) ?></td>
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
                                            <a data-toggle="modal" data-target="#editRowModal" data-role_id="<?= esc($row['id']) ?>" class="btn btn-warning btn-sm">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </a>
                                            <a href="<?= site_url('siswa/delete/' . $row['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus role ini?')">
                                                <i class="bi bi-trash3"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer"></div>
                <!-- /.card-footer-->
            </div>
            <!-- /.card -->
        </div>
    </div>
    <!--end::Row-->
</div>


<!-- Modal for Import -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Import Data <?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('siswa/import') ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label for="excel_file">Upload File Excel</label>
                        <input type="file" name="excel_file" class="form-control" id="excel_file" required accept=".xls, .xlsx">
                        <small class="form-text text-muted">
                            File harus berformat .xls atau .xlsx. Pastikan kolom sesuai dengan template.
                            <a href="<?= base_url('siswa/download-template') ?>" target="_blank">Unduh Template</a>
                        </small>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Upload dan Proses</button>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="addRowModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data <?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('siswa/add') ?>" method="POST">
                    <div class="row">

                        <div class="col-md-6 mb-3 mb-3">
                            <div class="form-group form-group-default">
                                <label>NIS</label>
                                <input id="text" type="number" class="form-control" placeholder="Masukkan Nis Siswa" name="nis" required style="padding-left: 10px;">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group form-group-default">
                                <label>Nama Siswa</label>
                                <input id="addPosition" type="text" class="form-control" placeholder="Masukkan Siswa <?= $title ?>" name="name" required style="padding-left: 10px;">
                            </div>
                        </div>

                        <div class="col-md-6 mb-3 mb-3">
                            <div class="form-group form-group-default">
                                <label>Jenis Kelamin</label>
                                <select class="form-control" name="gender" required style="padding-left: 10px;">
                                    <option value="Laki-Laki">Laki-Laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3 mb-3">
                            <div class="form-group form-group-default">
                                <label>Kelas</label>

                                <select class="form-control" name="id_class" required style="padding-left: 10px;">
                                    <?php foreach ($classData as $row) : ?>
                                        <option value="<?= $row['id'] ?>"><?= $row['class_name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <hr>
                        <div class="col-md-6 mb-3 mb-3">
                            <div class="form-group form-group-default">
                                <label>Nama Orang Tua</label>
                                <input id="text" type="text" class="form-control" placeholder="Nama Orang Tua <?= $title ?>" name="mother_name" value="-" required style="padding-left: 10px;">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group form-group-default">
                                <label>No Whatsapp Orang Tua</label>
                                <input id="addPosition" type="number" class="form-control" placeholder="No Whatsapp Orang Tua <?= $title ?>" name="whatsapp" value="0" required style="padding-left: 10px;">
                            </div>
                        </div>

                        <hr>
                        <div class="col-md-6 mb-3 mb-3">
                            <div class="form-group form-group-default">
                                <label>Nama Wali Asrama</label>
                                <input id="text" type="text" class="form-control" placeholder="Nama Wali Asrama <?= $title ?>" name="dormitory_name" value="-" required style="padding-left: 10px;">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group form-group-default">
                                <label>No Whatsapp Wali Asrama</label>
                                <input id="addPosition" type="number" class="form-control" placeholder="No Whatsapp Wali Asrama <?= $title ?>" name="dormitory_wa" value="0" required style="padding-left: 10px;">
                            </div>
                        </div>



                        <hr>

                        <div class="col-md-6 mb-3 mb-3">
                            <div class="form-group form-group-default">
                                <label>Model Ipad</label>
                                <input id="text" type="text" class="form-control" placeholder="Masukkan Model Ipad" value="-" name="model" required style="padding-left: 10px;">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group form-group-default">
                                <label>Warna Ipad</label>
                                <input id="addPosition" type="text" class="form-control" placeholder="Masukkan Warna Ipad" value="-" name="color" required style="padding-left: 10px;">
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-group form-group-default">
                                <label>Kondisi Ipad</label>

                                <select class="form-control" name="grade" required style="padding-left: 10px;">
                                    <option value="Bagus">Bagus</option>
                                    <option value="Sedikit Rusak">Sedikit Rusak</option>
                                    <option value="Rusak">Rusak</option>
                                    <option value="Mati Total">Mati Total</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-group form-group-default">
                                <label>Status Ipad</label>
                                <select class="form-control" name="status" required style="padding-left: 10px;">
                                    <option value="Disimpan">Disimpan</option>
                                    <option value="Pembelajaran">Pembelajaran</option>
                                    <option value="Pinjam">Pinjam</option>
                                </select>
                            </div>
                        </div>


                        <div class="col-md-12 mb-3">
                            <div class="form-group form-group-default">
                                <label>Catatan</label>
                                <input id="addPosition" type="text" class="form-control" placeholder="Masukkan Catatan Ipad" value="-" name="note" required style="padding-left: 10px;">
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Tambah Data <?= $title ?></button>
            </div>
            </form>
        </div>
    </div>
</div>









<div class="modal fade" id="editRowModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data <?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('siswa/update') ?>" method="POST">
                    <!-- Isi Modal Fetch Data -->
                    <div class="fetched-data"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Edit Data <?= $title ?></button>
            </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<!-- Inisialisasi DataTables -->
<script>
    $(function() {
        $('#roles-table').DataTable({});


        // Ambil flash success dari server (string)
        var flashSuccess = <?= json_encode(session()->getFlashdata('success') ?? '') ?>;

        if (flashSuccess) {
            // Bootstrap Notify style
            $.notify({
                // Anda bisa sertakan icon jika tema mendukung
                icon: 'flaticon-alarm-1',
                title: '<strong>Berhasil</strong><br>',
                message: flashSuccess
            }, {
                type: 'success', // info | success | warning | danger
                allow_dismiss: true,
                newest_on_top: true,
                placement: {
                    from: 'bottom',
                    align: 'right'
                },
                offset: 20,
                spacing: 10,
                z_index: 9999,
                delay: 1000, // jeda sebelum mulai fade out (ms)
                timer: 500, // durasi animasi progress (ms)
                animate: {
                    enter: 'animated fadeInRight',
                    exit: 'animated fadeOutRight'
                }, // opsional jika pakai animate.css
                template: '<div data-notify="container" class="alert alert-{0} shadow-sm" role="alert">' +
                    '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">&times;</button>' +
                    '<span data-notify="icon"></span> ' +
                    '<span data-notify="title">{1}</span>' +
                    '<span data-notify="message">{2}</span>' +
                    '</div>'
            });
        }

        $('#editRowModal').on('show.bs.modal', function(e) {
            var id = $(e.relatedTarget).data('role_id');
            $.ajax({
                type: 'post',
                url: '<?= base_url('Ajax/edit_siswa/') ?>' + id,
                data: {
                    'id': id,
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                },
                success: function(data) {
                    // The content from the AJAX call is placed inside the modal's body
                    $('#editRowModal .fetched-data').html(data);
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>