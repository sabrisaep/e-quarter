<?= $this->extend('layout/admin'); ?>
<?= $this->section('content'); ?>
<?php
/**
 * @var object[] $jabatan
 */
?>

<h1 class="text-primary">Senarai Ketua Program / Jabatan</h1>

<div class="card mb-4">
    <div class="card-header">
        <h5 id="formTitle" class="mb-0">Daftar Ketua Program / Jabatan Baru</h5>
    </div>
    <div class="card-body">
        <form id="ketuaForm" action="<?= base_url('admin/ketua_simpan') ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="id" id="ketuaId">
            <div class="row">
                <div class="col-md-2 mb-3">
                    <label for="jabatan_id">Jabatan</label>
                    <select name="jabatan_id" id="jabatan_id" class="form-control" required>
                        <option value="">-- Pilih Jabatan --</option>
                        <?php foreach ($jabatan as $j): ?>
                            <option value="<?= $j->id ?>"><?= esc($j->nama_jabatan) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="nama_penuh">Nama Penuh</label>
                    <input type="text" name="nama_penuh" id="nama_penuh" class="form-control" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="email">Emel</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="no_kp">No. Kad Pengenalan</label>
                    <input type="text" name="no_kp" id="no_kp" class="form-control" required pattern="\d{12}"
                           maxlength="12" title="Sila masukkan 12 digit nombor kad pengenalan tanpa tanda -">
                </div>
                <div class="col-md-2 mb-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary" id="submitBtn">Simpan</button>
                    <button type="button" class="btn btn-secondary" id="cancelBtn" style="display:none;"
                            onclick="resetFormKetua()">Batal
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php if (!empty($jabatan) && is_array($jabatan)): ?>
    <?php foreach ($jabatan as $j): ?>
        <div class="card mt-4">
            <div class="card-header bg-light">
                <h4 class="mb-0 text-dark"><?= esc($j->nama_jabatan); ?></h4>
            </div>
            <div class="card-body">
                <h5 class="mb-3">Senarai Ketua Program / Jabatan Aktif</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th style="width: 50px;">Bil</th>
                            <th>Nama</th>
                            <th style="width: 350px;">Emel</th>
                            <th style="width: 150px;">No. KP</th>
                            <th style="width: 250px;">Tindakan</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($j->ketua_aktif)): ?>
                            <?php foreach ($j->ketua_aktif as $index => $ketua): ?>
                                <tr>
                                    <td><?= $index + 1; ?></td>
                                    <td><?= esc($ketua->nama_penuh); ?></td>
                                    <td><?= esc($ketua->email); ?></td>
                                    <td><?= esc($ketua->no_kp); ?></td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning"
                                                onclick="editKetua(<?= htmlspecialchars(json_encode($ketua)) ?>)">
                                            Edit
                                        </button>

                                        <button type="button" class="btn btn-sm btn-danger"
                                                onclick="confirmDeleteKetua(<?= $ketua->id ?>)">
                                            Padam
                                        </button>

                                        <button type="button" class="btn btn-sm btn-info"
                                                onclick="confirmResetKetua(<?= $ketua->id ?>)">
                                            Reset
                                        </button>

                                        <button type="button" class="btn btn-sm btn-secondary"
                                                onclick="confirmSekatKetua(<?= $ketua->id ?>)">
                                            Sekat
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted italic">Tiada ketua aktif direkodkan.</td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <hr class="my-4">

                <h5 class="mb-3">Senarai Ketua Program / Jabatan Disekat Capaian</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th style="width: 50px;">Bil</th>
                            <th>Nama</th>
                            <th style="width: 150px;">No. KP</th>
                            <th style="width: 250px;">Tindakan</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($j->ketua_sekat)): ?>
                            <?php foreach ($j->ketua_sekat as $index => $ketua): ?>
                                <tr>
                                    <td><?= $index + 1; ?></td>
                                    <td><?= esc($ketua->nama_penuh); ?></td>
                                    <td><?= esc($ketua->no_kp); ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-success"
                                                onclick="confirmAktifKetua(<?= $ketua->id ?>)">Aktifkan Semula
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted italic">Tiada ketua aktif direkodkan.</td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<script>
    function editKetua(data) {
        document.getElementById('formTitle').innerText = 'Kemaskini Ketua Program / Jabatan';
        document.getElementById('ketuaId').value = data.id;
        document.getElementById('jabatan_id').value = data.jabatan_id;
        document.getElementById('nama_penuh').value = data.nama_penuh;
        document.getElementById('email').value = data.email;
        document.getElementById('no_kp').value = data.no_kp;

        document.getElementById('submitBtn').innerText = 'Kemaskini';
        document.getElementById('cancelBtn').style.display = 'inline-block';
        document.getElementById('ketuaForm').action = '<?= base_url('admin/ketua_simpan') ?>'; // Update form action
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function resetFormKetua() { // Renamed to avoid conflict
        document.getElementById('formTitle').innerText = 'Daftar Ketua Program / Jabatan Baru';
        document.getElementById('ketuaForm').reset(); // Use ketuaForm
        document.getElementById('ketuaId').value = '';
        document.getElementById('submitBtn').innerText = 'Simpan';
        document.getElementById('cancelBtn').style.display = 'none';
        document.getElementById('ketuaForm').action = '<?= base_url('admin/ketua_simpan') ?>'; // Reset form action
    }

    function confirmDeleteKetua(id) {
        document.getElementById('deleteForm').action = '<?= base_url('admin/ketua_padam/') ?>' + id;
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    }

    function confirmResetKetua(id) {
        document.getElementById('resetForm').action = '<?= base_url('admin/ketua_reset/') ?>' + id;
        new bootstrap.Modal(document.getElementById('resetModal')).show();
    }

    function confirmSekatKetua(id) {
        document.getElementById('sekatForm').action = '<?= base_url('admin/ketua_sekat/') ?>' + id;
        new bootstrap.Modal(document.getElementById('sekatModal')).show();
    }

    function confirmAktifKetua(id) {
        document.getElementById('aktifForm').action = '<?= base_url('admin/ketua_aktifkan/') ?>' + id;
        new bootstrap.Modal(document.getElementById('aktifModal')).show();
    }
</script>
<?= $this->endSection(); ?>