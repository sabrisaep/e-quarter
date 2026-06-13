<?= $this->extend('layout/admin'); ?>
<?= $this->section('content'); ?>
<?php
/**
 * @var string $role
 * @var string $roleTitle
 * @var object[] $activeUsers
 * @var object[] $blockedUsers
 */
?>
<h1 class="text-primary"><?= esc($roleTitle) ?></h1>

<div class="card mb-4">
    <div class="card-header">
        <h5 id="formTitle" class="mb-0">Daftar <?= esc($roleTitle) ?> Baru</h5>
    </div>
    <div class="card-body">
        <form id="keraniForm" action="<?= base_url('admin/user_simpan/' . $role) ?>" method="post">
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
                    <input type="text" name="no_kp" id="no_kp" class="form-control" required pattern="\d{12}" maxlength="12" title="Sila masukkan 12 digit nombor kad pengenalan tanpa tanda -">
                </div>
                <div class="col-md-2 mb-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary" id="submitBtn">Simpan</button>
                    <button type="button" class="btn btn-secondary" id="cancelBtn" style="display:none;" onclick="resetForm('<?= esc($role) ?>')">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Senarai <?= esc($roleTitle) ?> Aktif</h5>
    </div>
    <div class="card-body">
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
                <?php if(!empty($activeUsers)): foreach($activeUsers as $index => $user): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= esc($user->nama_penuh) ?></td>
                    <td><?= esc($user->email) ?></td>
                    <td><?= esc($user->no_kp) ?></td>
                    <td>
                        <button class="btn btn-sm btn-warning" onclick="editUser(<?= htmlspecialchars(json_encode($user)) ?>, '<?= esc($role) ?>')">Edit</button>
                        <button class="btn btn-sm btn-danger" onclick="confirmDelete(<?= $user->id ?>, '<?= esc($role) ?>')">Padam</button>
                        <button class="btn btn-sm btn-info" onclick="confirmReset(<?= $user->id ?>, '<?= esc($role) ?>')">Reset</button>
                        <button class="btn btn-sm btn-secondary" onclick="confirmSekat(<?= $user->id ?>, '<?= esc($role) ?>')">Sekat</button>
                    </td>
                </tr>
                <?php endforeach; else: ?>
                <tr><td colspan="5" class="text-center">Tiada rekod <?= strtolower(esc($roleTitle)) ?> aktif.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header bg-light">
        <h5 class="mb-0">Senarai <?= esc($roleTitle) ?> Disekat Capaian</h5>
    </div>
    <div class="card-body">
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
                <?php if(!empty($blockedUsers)): foreach($blockedUsers as $index => $user): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= esc($user->nama_penuh) ?></td>
                    <td><?= esc($user->no_kp) ?></td>
                    <td>
                        <button class="btn btn-sm btn-success" onclick="confirmAktif(<?= $user->id ?>, '<?= esc($role) ?>')">Aktifkan Semula</button>
                    </td>
                </tr>
                <?php endforeach; else: ?>
                <tr><td colspan="4" class="text-center">Tiada rekod sekatan untuk <?= strtolower(esc($roleTitle)) ?>.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection(); ?>