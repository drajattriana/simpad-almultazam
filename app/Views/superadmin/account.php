<?= $this->extend('template/index') ?>

<?= $this->section('content') ?>
<style>
    /* ADDED: Wrapper for positioning the icon relative to the input field */
    .password-wrapper {
        position: relative;
    }

    /* ADDED: Style and position the icon inside the input field */
    .password-wrapper #toggle-add-password {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #888;
        z-index: 5; /* Ensure icon is clickable */
    }

    /* ADDED: Adjust input padding to prevent text from overlapping with the icon */
    .password-wrapper .form-control {
        padding-right: 40px !important; /* Use !important to override existing styles if necessary */
    }
</style>

<div class="container-fluid">
    <!--begin::Row-->
    <div class="row">
        <div class="col-12">
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tabel Data <?= $title ?></h3>
                    <div class="card-tools mt-4">
                        <button class="btn btn-info form-control" data-toggle="modal" data-target="#addRowModal">Tambah Data</button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="roles-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Position</th>
                                <th>username</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($users as $row) : ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= esc($row['name']) ?></td>
                                    <td><?= esc($row['position']) ?></td>
                                    <td><?= esc($row['username']) ?></td>
                                    <td>
                                        <a data-toggle="modal" data-target="#editRowModal" data-role_id="<?= esc($row['id']) ?>" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <a href="<?= site_url('superadmin/akun/delete/' . $row['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus role ini?')">
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
                <form action="<?= base_url('superadmin/akun/add') ?>" method="POST">
                    <div class="row">

                        <div class="col-md-6 mb-3 mb-3">
                            <div class="form-group form-group-default">
                                <label>Nama Akun</label>
                                <input id="text" type="text" class="form-control" placeholder="Nama <?= $title ?>" name="name" required style="padding-left: 10px;">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group form-group-default">
                                <label>Pilih Role</label>
                                <select class="form-control" name="id_role" required style="padding-left: 10px;">
                                    <?php foreach ($roles as $row) : ?>
                                        <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3 mb-3">
                            <div class="form-group form-group-default">
                                <label>Username Akun</label>
                                <input id="text" type="text" class="form-control" placeholder="Username <?= $title ?>" name="username" required style="padding-left: 10px;">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <!-- ADDED: Wrapper div for relative positioning -->
                            <div class="password-wrapper">
                                <div class="form-group form-group-default">
                                    <label>Password</label>
                                    <!-- 1. CHANGED: input type to "password" for security -->
                                    <!-- 2. CHANGED: id to be specific for this field -->
                                    <input id="add-password-field" type="password" class="form-control" placeholder="Password <?= $title ?>" name="password" required style="padding-left: 10px;">
                                </div>
                                <!-- ADDED: Toggle icon to show/hide password -->
                                <i class="fas fa-eye" id="toggle-add-password"></i>
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
                <form action="<?= base_url('superadmin/akun/update') ?>" method="POST">
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
                url: '<?= base_url('Ajax/edit_akun/') ?>' + id,
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


        // ADDED: Logic to toggle password visibility for the 'Add' modal
$('#toggle-add-password').on('click', function() {
    // Select the password input field
    const passwordField = $('#add-password-field');
    // Get the current type of the input
    const passwordFieldType = passwordField.attr('type');

    // Check the current type and toggle it
    if (passwordFieldType === 'password') {
        // Change the type to 'text' to show the password
        passwordField.attr('type', 'text');
        // Change the icon to 'eye-slash'
        $(this).removeClass('fa-eye').addClass('fa-eye-slash');
    } else {
        // Change the type back to 'password' to hide it
        passwordField.attr('type', 'password');
        // Change the icon back to 'eye'
        $(this).removeClass('fa-eye-slash').addClass('fa-eye');
    }
});



    });
</script>
<?= $this->endSection() ?>