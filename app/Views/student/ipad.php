<?= $this->extend('template/index') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Tabel Data <?= esc($title) ?></h3>
        </div>

        <div class="card-body">
          <!-- Add filter form -->
          <div class="row mb-3">
            <div class="col-12">
              <form action="<?= base_url('siswa/ipad') ?>" method="GET" class="form-inline">
                <div class="form-group mr-2">
                  <label for="filter-class" class="mr-2">Kelas</label>
                  <select name="class_id" id="filter-class" class="form-control">
                    <option value="">Semua Kelas</option>
                    <?php foreach ($classes as $class): ?>
                      <option value="<?= esc($class['id']) ?>" <?= (isset($selectedClass) && $class['id'] == $selectedClass) ? 'selected' : '' ?>>
                        <?= esc($class['class_name']) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <div class="form-group mr-2">
                  <label for="filter-status" class="mr-2">Status</label>
                  <select name="status" id="filter-status" class="form-control">
                    <option value="">Semua Status</option>
                    <option value="Pembelajaran" <?= (isset($selectedStatus) && 'Pembelajaran' == $selectedStatus) ? 'selected' : '' ?>>Pembelajaran</option>
                    <option value="Disimpan" <?= (isset($selectedStatus) && 'Disimpan' == $selectedStatus) ? 'selected' : '' ?>>Disimpan</option>
                    <option value="Pinjam" <?= (isset($selectedStatus) && 'Pinjam' == $selectedStatus) ? 'selected' : '' ?>>Dipinjam</option>
                  </select>
                </div>

                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="<?= base_url('siswa/ipad') ?>" class="btn btn-secondary ml-2">Reset</a>
              </form>
            </div>
          </div>

          <div class="card-tools mt-4">
            <button class="btn btn-info form-control" data-toggle="modal" data-target="#addRowModal">Update Group Data</button>
          </div>

          <div class="table-responsive">
            <table id="roles-table" class="table table-bordered table-striped align-middle">
              <thead>
                <tr>
                  <th style="width:60px">No</th>
                  <th>Name</th>
                  <th>Kelas</th>
                  <th>Model</th>
                  <th>Note</th>
                  <th>Waktu Peminjaman</th>
                  <th>Waktu Pengembalian</th>
                  <th style="width:160px">QRCode</th>
                  <th>Status</th>
                  <th style="width:120px">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php $i = 1;
                foreach ($ipad as $row):
                  $nis   = esc($row['nis']);
                  $qrUrl = base_url('upload/qr/' . $nis . '.png');
                ?>
                  <tr>
                    <td><?= $i++ ?></td>
                    <td><?= esc($row['student']) ?></td>
                    <td><?= esc($row['class_name']) ?></td>
                    <td><?= esc($row['model']) ?></td>
                    <td><?= esc($row['note']) ?></td>
                    <?php if ($row['status'] == 'Pinjam') { ?>
                      <td><?= date('d M Y', strtotime($row['peminjaman'])) ?></td>
                      <td><?= date('d M Y', strtotime($row['pengembalian'])) ?></td>
                    <?php } else { ?>
                      <td>-</td>
                      <td>-</td>
                    <?php } ?>
                    <td>
                      <!-- Gambar QR: klik untuk buka modal preview -->
                      <img
                        src="<?= $qrUrl ?>"
                        alt="QR <?= $nis ?>"
                        class="img-thumbnail qr-thumb"
                        style="width:64px;height:64px;object-fit:contain;cursor:pointer;"
                        data-qr="<?= $qrUrl ?>"
                        data-title="QR: <?= esc($row['student']) ?> (<?= $nis ?>)">
                    </td>
                    <td>
                      <?php
                      $status = esc($row['status']);
                      $badgeClass = '';
                      $iconClass = '';
                      $text = $status;
                      switch ($status) {
                        case 'Pembelajaran':
                          $badgeClass = 'badge-info';
                          $iconClass = 'fas fa-book';
                          break;
                        case 'Disimpan':
                          $badgeClass = 'badge-success';
                          $iconClass = 'fas fa-archive';
                          break;
                        case 'Pinjam':
                          $badgeClass = 'badge-warning';
                          $iconClass = 'fas fa-id-card';
                          $text = 'Dipinjam';
                          break;
                        default:
                          $badgeClass = 'badge-light';
                          $iconClass = 'fas fa-question-circle';
                          break;
                      }
                      ?>
                      <span class="badge <?= $badgeClass ?>"><i class="<?= $iconClass ?>"></i> <?= $text ?></span>
                    </td>
                    <td>
                      <a data-toggle="modal"
                        data-target="#editRowModal"
                        data-role_id="<?= esc($row['id']) ?>"
                        class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil-square"></i> Edit
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>

        <div class="card-footer"></div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="addRowModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Group Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('reset/scan') ?>" method="POST">
          <div class="row">

            <div class="col-md-6 mb-3">
              <div class="form-group form-group-default">
                <label>Kelas</label>
                  <select name="class_id" id="addPosition" class="form-control" required style="padding-left: 10px;">
                    <?php foreach ($classes as $class): ?>
                      <option value="<?= esc($class['id']) ?>" <?= (isset($selectedClass) && $class['id'] == $selectedClass) ? 'selected' : '' ?>>
                        <?= esc($class['class_name']) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group form-group-default">
                <label>Ubah Status Ke</label>
                  <select name="status"  id="addPosition" class="form-control" required style="padding-left: 10px;">
                    <option value="Pembelajaran">Pembelajaran</option>
                    <option value="Disimpan">Disimpan</option>
                  </select>
              </div>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Update Group Data</button>
      </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal Preview QR (dipicu oleh klik gambar) -->
<div class="modal fade" id="previewQrModal" tabindex="-1" aria-labelledby="previewQrLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="previewQrLabel">Preview QR</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <img id="previewQrImg" src="" alt="QR Preview" class="img-fluid" style="max-height:60vh;object-fit:contain;">
      </div>
      <div class="modal-footer">
        <a id="previewQrDownload" href="#" download class="btn btn-success">
          <i class="bi bi-download"></i> Download
        </a>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editRowModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Data <?= esc($title) ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('siswa/ipad/update') ?>" method="POST">
          <div class="fetched-data"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Edit Data <?= esc($title) ?></button>
      </div>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
  $(function() {
    // DataTable
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
    // Modal Edit (AJAX)
    $('#editRowModal').on('show.bs.modal', function(e) {
      var id = $(e.relatedTarget).data('role_id');
      $.ajax({
        type: 'post',
        url: '<?= base_url('Ajax/edit_ipad/') ?>' + id,
        data: {
          id: id,
          '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
        },
        success: function(html) {
          $('#editRowModal .fetched-data').html(html);
        },
        error: function() {
          $('#editRowModal .fetched-data').html('<div class="alert alert-danger mb-0">Gagal memuat data.</div>');
        }
      });
    });

    // Klik gambar QR => buka modal preview
    $(document).on('click', '.qr-thumb', function() {
      var qrSrc = $(this).data('qr');
      var title = $(this).data('title') || 'Preview QR';

      $('#previewQrLabel').text(title);
      $('#previewQrImg').attr('src', qrSrc);

      // Siapkan tautan download di modal
      $('#previewQrDownload').attr({
        href: qrSrc,
        download: (title.replace(/\s+/g, '_') || 'QR') + '.png'
      });

      $('#previewQrModal').modal('show');
    });
  });
</script>
<?= $this->endSection() ?>