<?= $this->extend('template/index') ?>

<?= $this->section('content') ?>    

        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-12">
                    <!-- Default box -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Tabel Data <?=  $title ?></h3>
                            <div class="card-tools mt-3">
                                <button class="btn btn-info form-control" data-toggle="modal" data-target="#addRowModal">Tambah Data</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="roles-table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Role</th>
                                        <th>Menu</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($navigation as $navigation) : ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td><?= esc($navigation['role_name']) ?></td>
                                            <td><?= esc($navigation['menu_name']) ?></td>
                                            <td>
                                                <!-- --- MODIFICATION START --- -->
                                                <!-- Correct the delete URL to include the role ID for proper redirection -->
                                                <a href="<?= site_url('superadmin/navigation/' . $role['id'] . '/delete/' . $navigation['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                    <i class="bi bi-trash3"></i> Delete
                                                </a>
                                                <!-- --- MODIFICATION END --- -->
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
                    <!-- Point the form action to the correct URL with roleId and action -->
                    <form action="<?= base_url('superadmin/navigation/' . $role['id'] . '/add') ?>" method="POST">
                        <div class="modal-body">
                            <!-- Add a hidden input to send the role ID -->
                            <input type="hidden" name="id_role" value="<?= $role['id'] ?>">

                            <div class="form-group mb-3">
                                <label for="roleName">Nama Role</label>
                                <!-- Display the role name as a readonly field -->
                                <input id="roleName" type="text" class="form-control border" value="<?= esc($role['name']) ?>" readonly>
                            </div>

                            <div class="form-group mb-3">
                                <label for="menuSelect">Pilih Menu</label>
                                <!-- Change text input to a select dropdown -->
                                <select class="form-select border form-control" id="menuSelect" name="id_menu" required>
                                    <option value="" selected disabled>-- Pilih Menu --</option>
                                    <?php foreach ($availableMenus as $menu) : ?>
                                        <option value="<?= $menu['id'] ?>"><?= esc($menu['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Tambah Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>



<?= $this->endSection() ?> 

<?= $this->section('scripts') ?>
<!-- Inisialisasi DataTables -->
<script>
  $(function () {
    
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
        
  });
</script>
<?= $this->endSection() ?>