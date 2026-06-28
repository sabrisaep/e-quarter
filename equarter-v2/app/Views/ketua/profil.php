<?= $this->extend('layout/pengguna'); ?>
<?= $this->section('content'); ?>
<?php
/**
 * @var object $pengguna
 */
$role = session()->get('role');
?>

<h1 class="text-primary">Profil Saya</h1>

<div class="row mt-4">
    <div class="col-md-4">
        <div class="card h-100 shadow-sm">
            <h5 class="card-header bg-primary text-white">
                Maklumat Pengguna
            </h5>
            <div class="card-body">
                <p><strong>Nama Penuh:</strong><br><?= esc($pengguna->nama_penuh) ?></p>
                <p><strong>Email:</strong><br><?= esc($pengguna->email) ?></p>
                <p><strong>No. KP:</strong><br><?= esc($pengguna->no_kp) ?></p>
                <p><strong>Peranan:</strong><br><?= PENGGUNA[esc($role)] ?></p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card h-100 shadow-sm h-100">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">Kemaskini Profil</h5>
            </div>
            <div class="card-body">
                <form action="<?= base_url('ketua/profil/kemaskini') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="nama_penuh" class="form-label">Nama Penuh</label>
                        <input type="text" name="nama_penuh" id="nama_penuh" class="form-control"
                               value="<?= esc($pengguna->nama_penuh) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control"
                               value="<?= esc($pengguna->email) ?>" required>
                    </div>
                    <button type="submit" class="btn btn-outline-primary">Simpan Perubahan</button>
                </form>
            </div>
            <div class="card-footer">
                Untuk kemaskini nombor kad pengenalan, sila hubungi pentadbir sistem.
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card h-100 shadow-sm h-100">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">Tukar Kata Laluan</h5>
            </div>
            <div class="card-body">
                <form id="formTukarPassword" action="<?= base_url('ketua/profil/tukar-password') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Kata Laluan Semasa</label>
                        <input type="password" name="current_password" id="current_password" class="form-control"
                               required>
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">Kata Laluan Baru</label>
                        <input type="password" name="new_password" id="new_password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Sahkan Kata Laluan Baru</label>
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control"
                               required>
                    </div>
                    <button type="submit" class="btn btn-outline-primary">Tukar Kata Laluan</button>
                    <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#modalPanduan">Panduan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Panduan -->
<div class="modal fade" id="modalPanduan" tabindex="-1" aria-labelledby="modalPanduanLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPanduanLabel">Panduan Kata Laluan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul>
                    <li>Minimum 8 aksara.</li>
                    <li>Kata laluan baru mestilah berbeza dengan kata laluan lama.</li>
                    <li>Pastikan pengesahan kata laluan adalah sama dengan kata laluan baru.</li>
                    <li>Mestilah menggunakan kombinasi huruf dan nombor untuk keselamatan optimum.</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Alert JS -->
<div class="modal fade" id="jsAlertModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Ralat Validasi</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="jsAlertMessage">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<script>
document.getElementById('formTukarPassword').addEventListener('submit', function(e) {
    const currentPw = document.getElementById('current_password').value;
    const newPw = document.getElementById('new_password').value;
    const confirmPw = document.getElementById('confirm_password').value;
    const alertModal = new bootstrap.Modal(document.getElementById('jsAlertModal'));
    const alertMsg = document.getElementById('jsAlertMessage');

    const showAlert = (msg) => {
        e.preventDefault();
        alertMsg.innerText = msg;
        alertModal.show();
    };

    // Regex: Minimum 8 characters, at least one letter and one number
    const complexityRegex = /^(?=.*[A-Za-z])(?=.*\d).{8,}$/;

    if (newPw.length < 8) {
        showAlert('Kata laluan baru mestilah sekurang-kurangnya 8 aksara.');
    } else if (!complexityRegex.test(newPw)) {
        showAlert('Kata laluan mestilah mengandungi kombinasi huruf dan nombor.');
    } else if (newPw === currentPw) {
        showAlert('Kata laluan baru tidak boleh sama dengan kata laluan semasa.');
    } else if (newPw !== confirmPw) {
        showAlert('Pengesahan kata laluan tidak sepadan.');
    }
});
</script>
<?= $this->endSection(); ?>
