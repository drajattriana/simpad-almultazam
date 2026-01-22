<?= $this->extend('template/index') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-head-row">
                        <div class="card-title">Filter History Scan</div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filter Form -->
                    <form method="GET" action="<?= site_url('siswa/history') ?>">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="class_id">Kelas</label>
                                    <select name="class_id" id="class_id" class="form-control">
                                        <option value="">Semua Kelas</option>
                                        <?php foreach ($classes as $class) : ?>
                                            <option value="<?= $class['id'] ?>" <?= ($filters['class_id'] ?? '') == $class['id'] ? 'selected' : '' ?>>
                                                <?= esc($class['class_name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="start_date">Tanggal Mulai</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control" value="<?= esc($filters['start_date'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="end_date">Tanggal Akhir</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control" value="<?= esc($filters['end_date'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="">Semua Status</option>
                                        <?php foreach ($statuses as $status) : ?>
                                            <option value="<?= $status ?>" <?= ($filters['status'] ?? '') == $status ? 'selected' : '' ?>>
                                                <?= esc($status) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="<?= site_url('siswa/history') ?>" class="btn btn-warning">Reset</a>
                                <!-- Export button links to export_pdf with current filters -->
                                <a href="<?= site_url('siswa/export_pdf?' . http_build_query($filters)) ?>" class="btn btn-success" target="_blank">Export ke PDF</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="card-head-row">
                        <div class="card-title">Data History Scan</div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="history-scan-table" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Scan</th>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <th>Status</th>
                                    <th>Petugas</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($scanHistory)) : ?>
                                    <?php $i = 1; ?>
                                    <?php foreach ($scanHistory as $scan) : ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td><?= esc(date('d-m-Y H:i:s', strtotime($scan['created_at']))) ?></td>
                                            <td><?= esc($scan['student']) ?></td>
                                            <td><?= esc($scan['class_name']) ?></td>
                                            <td><?= esc($scan['status']) ?></td>
                                            <td><?= esc($scan['employee']) ?></td>
                                            <td><?= esc($scan['note']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data untuk ditampilkan.</td>
                                    </tr>
                                <?php endif; ?>
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
        // Initialize DataTable
        $('#history-scan-table').DataTable({
            "pageLength": 10,
        });
    });
</script>
<?= $this->endSection() ?>
