<?= $this->extend('template/index') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <div class="row g-2 align-items-center">
            <div class="col-12 col-lg-6">
              <h3 class="card-title mb-0">Tabel Data <?= $title ?></h3>
            </div>
            <div class="col-12 col-lg-6">
              <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                <select id="cameraSelect" class="form-select form-control form-select-sm" style="min-width:220px; max-width:100%">
                  <option value="">Pilih kamera...</option>
                </select> <br>
                <button id="btnRefreshCams" class="btn btn-outline-secondary btn-sx m-1 mt-1">Refresh</button>
                <button id="btnStart" class="btn btn-primary btn-sx m-1 mt-1">Mulai</button>
                <button id="btnStop" class="btn btn-outline-secondary btn-sx m-1 mt-1">Stop</button>
              </div>
            </div>
          </div>
        </div>

        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
              <!-- Wrapper agar reader center dan responsif -->
              <div class="ratio ratio-4x3 border rounded bg-light d-flex align-items-center justify-content-center">
                <!-- Reader: ukurannya mengikuti parent -->
                <div id="reader" style="width:100%; max-width:480px;"></div>
              </div>
              <small class="text-muted d-block mt-2" id="camStatus">Kamera belum aktif.</small>

              <div class="mt-3">
                <label class="form-label">Hasil QR Terakhir</label>
                <input type="text" id="lastResult" class="form-control" readonly>
              </div>

                <div class="mt-3">
                    <label class="form-label">Data Form Peminjaman</label>
                    
                    <!-- Input untuk Method (Status) -->
                    <div class="input-group mb-2">
                    <span class="input-group-text" style="width: 110px;">Status</span>
                    <input type="text" id="methodInput" class="form-control" value="<?= esc($scan) ?>" readonly>
                    </div>

                    <!-- Input untuk Tanggal Pengembalian -->
                    <div class="input-group mb-2">
                    <span class="input-group-text" style="width: 110px;">Tgl Kembali</span>
                    <input type="text" id="dateInput" class="form-control" value="<?= esc($pengembalian) ?>" readonly>
                    </div>

                    <!-- Input untuk Keterangan -->
                    <div class="input-group">
                    <span class="input-group-text" style="width: 110px;">Keterangan</span>
                    <input type="text" id="noteInput" class="form-control" value="<?= esc($keterangan) ?>" readonly>
                    </div>
                    <small class="text-muted">Data ini akan dikirim otomatis bersama hasil scan QR.</small>
                </div>
            </div>
          </div>
        </div>

        <div class="card-footer"></div>
      </div>
    </div>
  </div>
</div>

<!-- Toast container (Bootstrap 5) -->

<audio id="beepAudio" preload="auto">
  <source src="<?= base_url('sounds/beep.mp3') ?>" type="audio/mpeg">
  <source src="<?= base_url('sounds/beep.ogg') ?>" type="audio/ogg">
</audio>

<?= $this->endSection() ?>


<?= $this->section('scripts') ?>


<script src="https://unpkg.com/html5-qrcode"></script>
<script>
  // ===== State =====
  let html5Qrcode = null;
  let isScanning = false;
  let debounce = false;
  let camerasList = [];
  let selectedCameraId = null;

  // ===== Toast Helpers =====
  function showToastSuccess(msg) {
    $.notify({
      icon: 'flaticon-alarm-1',
      title: 'Berhasil',
      message: msg,
    }, {
      type: 'success',
      placement: {
        from: "bottom",
        align: "right"
      },

      delay: 500,
      timer: 1000,
    });

    const el = document.getElementById('liveToast');
    document.getElementById('toastMessage').textContent = msg || 'Berhasil';
    new bootstrap.Toast(el, {
      delay: 2500
    }).show();
  }

  function showToastError(msg) {
    const el = document.getElementById('errorToast');
    document.getElementById('errorMessage').textContent = msg || 'Terjadi kesalahan';
    new bootstrap.Toast(el, {
      delay: 3000
    }).show();
  }

  // ===== Camera Handling =====
  async function loadCameras() {
    try {
      camerasList = await Html5Qrcode.getCameras();
      const sel = document.getElementById('cameraSelect');
      sel.innerHTML = '<option value="">Pilih kamera...</option>';

      if (!camerasList.length) {
        showToastError('Tidak ada kamera.');
        return;
      }

      camerasList.forEach((cam, i) => {
        const o = document.createElement('option');
        o.value = cam.id;
        o.textContent = cam.label || `Kamera ${i+1}`;
        sel.appendChild(o);
      });

      const saved = localStorage.getItem('selectedCam');
      const back = camerasList.find(d => /back|rear|environment/i.test(d.label || ''));
      selectedCameraId = saved || (back ? back.id : camerasList[0].id);
      sel.value = selectedCameraId;
    } catch (e) {
      showToastError('Gagal ambil daftar kamera.');
    }
  }

  async function startCamera() {
    if (isScanning) return;
    const status = document.getElementById('camStatus');

    try {
      if (!selectedCameraId) {
        await loadCameras();
        if (!selectedCameraId) {
          status.textContent = 'Tidak ada kamera.';
          return;
        }
      }

      if (!html5Qrcode) html5Qrcode = new Html5Qrcode('reader');

      await html5Qrcode.start({
          deviceId: {
            exact: selectedCameraId
          }
        }, {
          fps: 10,
          qrbox: {
            width: 250,
            height: 250
          },
          aspectRatio: 1.777,
          rememberLastUsedCamera: true
        },
        onScanSuccess,
        onScanFailure
      );

      isScanning = true;
      status.textContent = 'Kamera aktif. Arahkan ke QR.';
    } catch (e) {
      showToastError('Gagal aktifkan kamera: ' + (e?.message || e));
      status.textContent = 'Gagal mengaktifkan kamera.';
    }
  }

  async function stopCamera() {
    const status = document.getElementById('camStatus');
    if (html5Qrcode && isScanning) {
      await html5Qrcode.stop();
      await html5Qrcode.clear();
      isScanning = false;
      status.textContent = 'Kamera dihentikan.';
    }
  }

  async function switchCamera(id) {
    selectedCameraId = id;
    localStorage.setItem('selectedCam', id);
    if (isScanning) {
      await stopCamera();
      await startCamera();
    }
  }

  // ===== Audio =====
  function playBeep() {
    const a = document.getElementById('beepAudio');
    if (!a) return;
    a.currentTime = 0;
    a.play().catch(() => {
      /* ignore */ });
  }

  // ===== Scan Handlers =====
  function onScanSuccess(text) {
    document.getElementById('lastResult').value = text;

    if (debounce) return;
    debounce = true;
    setTimeout(() => debounce = false, 1200);

    // Ambil nilai method dari input
    const methodVal = document.getElementById('methodInput')?.value || '';
    const dateVal = document.getElementById('dateInput')?.value || '';
    const noteVal = document.getElementById('noteInput')?.value || '';

    // Kirim sebagai JSON, cocok dengan controller (getJSON)
    fetch("<?= site_url('student/scan/process') ?>", {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
          <?php if (csrf_token()): ?>,
            'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
          <?php endif; ?>
        },
        body: JSON.stringify({
          qr: text,
          method: methodVal,
          date: dateVal,
          note: noteVal
        })
      })
      .then(r => r.json())
      .then(d => {
        if (d?.status === 'success') {
          playBeep();
          showToastSuccess(d.message || 'Scan berhasil.');
        } else {
          showToastError(d?.message || 'Scan gagal diproses.');
        }
      })
      .catch(() => {
        showToastError('Kesalahan jaringan.');
      });
  }

  function onScanFailure(error) {
    // Biasanya sering decode error; diamkan agar tidak bising di UI.
  }

  // ===== DOM Ready =====
  document.addEventListener('DOMContentLoaded', function() {
    loadCameras();

    document.getElementById('btnRefreshCams').addEventListener('click', loadCameras);
    document.getElementById('cameraSelect').addEventListener('change', function() {
      if (this.value) switchCamera(this.value);
    });
    document.getElementById('btnStart').addEventListener('click', startCamera);
    document.getElementById('btnStop').addEventListener('click', stopCamera);

    // Tombol clear method
    const btnClearMethod = document.getElementById('btnClearMethod');
    if (btnClearMethod) {
      btnClearMethod.addEventListener('click', function() {
        const inp = document.getElementById('methodInput');
        if (inp) inp.value = '';
      });
    }

    <?php if (session()->getFlashdata('success')): ?>
      showToastSuccess('<?= esc(session()->getFlashdata('success')) ?>');
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
      showToastError('<?= esc(session()->getFlashdata('error')) ?>');
    <?php endif; ?>
  });
</script>
<?= $this->endSection() ?>