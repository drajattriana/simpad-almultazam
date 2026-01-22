<?= $this->extend('template/index') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
  <!--begin::Row-->
  <div class="row">
    <div class="col-12">
      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Tabel History Scan Hari Ini</h3>
          <div class="card-tools gap-2 mt-3">
            <button class="btn btn-info form-control" data-toggle="modal" data-target="#scanChoiceModal">
              Scan iPad
            </button>
          </div>
        </div>
        <div class="card-body">

          <div class="table-responsive">
            <table id="roles-table" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Student</th>
                  <th>Employee</th>
                  <th>Date</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php $i = 1; ?>
                <?php foreach ($scan as $row) : ?>
                  <tr>
                    <td><?= $i++ ?></td>
                    <td><?= esc($row['student']) ?></td>
                    <td><?= esc($row['employee']) ?></td>
                    <td><?= esc($row['created_at']) ?></td>
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


<!-- Modal Pilihan Scan -->
<div class="modal fade" id="scanChoiceModal" tabindex="-1" aria-labelledby="scanChoiceLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="scanChoiceLabel">Pilih Jenis Scan iPad</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="mb-3">Silakan pilih salah satu jenis scan berikut:</p>
        <div class="d-grid gap-2">
          <button class="btn btn-primary form-control mb-2" id="btnScanPembelajaran">
            Scan Pembelajaran
          </button>
          <button class="btn btn-success form-control mb-2" id="btnScanSimpan">
            Scan untuk Disimpan
          </button>
          <button class="btn btn-warning form-control mb-2" id="btnScanPinjam">
            Scan untuk Dipinjam
          </button>
        </div>
      </div>
      <div class="modal-footer">
        <small class="text-muted">Pilih sesuai kebutuhan operasi iPad.</small>
      </div>
    </div>
  </div>
</div>

<!-- (BARU) Modal Form Peminjaman -->
<div class="modal fade" id="pinjamModal" tabindex="-1" aria-labelledby="pinjamModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="pinjamModalLabel">Form Peminjaman iPad</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="pinjamForm">
        <div class="modal-body">
          <div class="form-group">
            <label for="tanggalPengembalian">Tanggal Pengembalian</label>
            <input type="date" class="form-control" id="tanggalPengembalian" name="tanggal_pengembalian" required>
          </div>
          <div class="form-group">
            <label for="keterangan">Keterangan Peminjaman</label>
            <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Opsional..."></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-warning">Lanjutkan Scan</button>
        </div>
      </form>
    </div>
  </div>
</div>


<?php if (session()->getFlashdata('success')) : ?>
  <div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="errorToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-header bg-success text-white">
        <strong class="me-auto">Success</strong>
        <button type="button" class="btn-close btn-close-white" data-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body">
        <?= session()->getFlashdata('success') ?>
      </div>
    </div>
  </div>
<?php endif; ?>


<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
  $(function() {
    // Inisialisasi DataTables
    $('#roles-table').DataTable({});

    // Inisialisasi Toast jika ada
    var toastEl = document.getElementById('errorToast');
    if (toastEl) {
      var toast = new bootstrap.Toast(toastEl, {
        delay: 2000
      });
      toast.show();
    }
  });

  // --- LOGIKA MODAL ---

  // Redirect langsung untuk "Pembelajaran"
  document.getElementById('btnScanPembelajaran').addEventListener('click', () => {
    window.location.href = `scan/Pembelajaran`;
  });

  // Redirect langsung untuk "Disimpan"
  document.getElementById('btnScanSimpan').addEventListener('click', () => {
    window.location.href = `scan/Disimpan`;
  });

  // (DIUBAH) Tampilkan modal form saat "Dipinjam" diklik
  document.getElementById('btnScanPinjam').addEventListener('click', () => {
    $('#scanChoiceModal').modal('hide'); // Sembunyikan modal pilihan
    $('#pinjamModal').modal('show'); // Tampilkan modal form peminjaman
  });

  // (BARU) Handle submit form peminjaman
  document.getElementById('pinjamForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Mencegah form submit secara default

    // Ambil nilai dari form
    const tanggal = document.getElementById('tanggalPengembalian').value;
    const keterangan = document.getElementById('keterangan').value;

    // Buat URL baru dengan query parameters
    const baseUrl = "scan/Pinjam";
    const params = new URLSearchParams({
      tanggal_pengembalian: tanggal,
      keterangan: keterangan
    }).toString();

    const finalUrl = `${baseUrl}?${params}`;

    // Redirect ke URL baru
    window.location.href = finalUrl;
  });
</script>
<?= $this->endSection() ?>