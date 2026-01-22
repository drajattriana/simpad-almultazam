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
                    <div class="card-tools mt-3">
                        <button class="btn btn-info form-control" data-toggle="modal" data-target="#addRowModal">Tambah Data</button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="roles-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($menus as $menu) : ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= esc($menu['name']) ?></td>
                                    <td>
                                        <a href="<?= site_url('superadmin/submenu/' . $menu['id']) ?>" class="btn btn-success btn-sm">
                                            <i class="bi bi-card-list"></i> Data Menu
                                        </a>
                                        <a data-toggle="modal" data-target="#editRowModal" data-role_id="<?= esc($menu['id']) ?>" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <a href="<?= site_url('superadmin/menu/delete/' . $menu['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus role ini?')">
                                            <i class="bi bi-trash3"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
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




<div class="modal fade" id="addRowModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data <?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('superadmin/menu/add') ?>" method="POST">
                    <div class="row">

                        <div class="col-md-12 mb-3 mb-3">
                            <div class="form-group form-group-default">
                                <label>Nama <?= $title ?></label>
                                <input id="text" type="text" class="form-control" placeholder="Nama <?= $title ?>" name="name" required style="padding-left: 10px;">
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data <?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('superadmin/menu/update/') ?>" method="POST">
                    
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
                url: '<?= base_url('Ajax/edit_menu/') ?>' + id,
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