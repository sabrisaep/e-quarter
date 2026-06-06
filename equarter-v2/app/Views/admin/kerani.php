<?= $this->extend('layout/admin'); ?>
<?= $this->section('content'); ?>
<?php
/**
 * @var object $keraniAktif
 * @var object $keraniDisekat
 */
?>
<h1 class="text-primary">Kerani Kewangan</h1>

<div class="card mb-4">
    <div class="card-header">
        <h5 id="formTitle" class="mb-0">Daftar Kerani Baru</h5>
    </div>
    <div class="card-body">
        <form id="keraniForm" action="<?= base_url('admin/kerani_simpan') ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="id" id="keraniId">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="nama_penuh">Nama Penuh</label>
                    <input type="text" name="nama_penuh" id="nama_penuh" class="form-control" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="email">Emel</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="no_kp">No. Kad Pengenalan</label>
                    <input type="text" name="no_kp" id="no_kp" class="form-control" required>
                </div>
                <div class="col-md-2 mb-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary" id="submitBtn">Simpan</button>
                    <button type="button" class="btn btn-secondary" id="cancelBtn" style="display:none;" onclick="resetForm()">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Senarai Kerani Aktif</h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Bil</th>
                    <th>Nama</th>
                    <th>Emel</th>
                    <th>No. KP</th>
                    <th>Tindakan</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($keraniAktif)): foreach($keraniAktif as $index => $k): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= esc($k->nama_penuh) ?></td>
                    <td><?= esc($k->email) ?></td>
                    <td><?= esc($k->no_kp) ?></td>
                    <td>
                        <button class="btn btn-sm btn-warning" onclick="editKerani(<?= htmlspecialchars(json_encode($k)) ?>)">Edit</button>
                        <button class="btn btn-sm btn-danger" onclick="confirmDelete(<?= $k->id ?>)">Padam</button>
                        <button class="btn btn-sm btn-info" onclick="confirmReset(<?= $k->id ?>)">Reset</button>
                        <button class="btn btn-sm btn-secondary" onclick="confirmSekat(<?= $k->id ?>)">Sekat</button>
                    </td>
                </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header bg-light">
        <h5 class="mb-0">Senarai Kerani Disekat Capaian</h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Bil</th>
                    <th>Nama</th>
                    <th>No. KP</th>
                    <th>Tindakan</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($keraniDisekat)): foreach($keraniDisekat as $index => $kd): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= esc($kd->nama_penuh) ?></td>
                    <td><?= esc($kd->no_kp) ?></td>
                    <td>
                        <button class="btn btn-sm btn-success" onclick="confirmAktif(<?= $kd->id ?>)">Aktifkan Semula</button>
                    </td>
                </tr>
                <?php endforeach; else: ?>
                <tr><td colspan="4" class="text-center">Tiada rekod sekatan.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection(); ?>
