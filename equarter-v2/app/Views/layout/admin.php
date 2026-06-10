<?php
/**
 * @var array $mesej
 */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>e-Quarter 2.0</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
          crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">

        <!-- Kiri -->
        <a class="navbar-brand" href="#">e-Quarter</a>
        (<?= ucfirst(session('username')) ?>)

        <!-- Button mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Kanan -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarMenu">
            <ul class="navbar-nav gap-2">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('admin/') ?>">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('admin/manage/pengurusan') ?>">Pengurusan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('admin/manage/kerani') ?>">Kerani</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('admin/jabatan') ?>">Jabatan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('admin/ketua') ?>">Ketua</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('admin/program') ?>">Program</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('admin/mata_pelajaran') ?>">Mata Pelajaran</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('admin/kata_laluan') ?>">Kata Laluan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="<?= base_url('logout') ?>">Log Keluar</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-3 mb-5 flex-grow-1">
    <?= $this->renderSection('content') ?>
</div>

<footer class="footer mt-auto py-3 bg-light border-top">
    <div class="container text-center">
        <span class="text-muted">
            &copy; <?= date('Y') == '2026' ? '2026' : '2026 - ' . date('Y') ?>
            e-Quarter 2.0. Kolej Vokasional Sultan Abdul Samad. Hak Cipta Terpelihara.
        </span>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
<script>
// Helper function to capitalize the first letter
function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

// Global function to set form action for modals
function setModalFormAction(formId, baseUrl, id) {
    document.getElementById(formId).action = baseUrl + id;
}

// Function to handle editing any user type
function editUser(data, role) {
    document.getElementById('formTitle').innerText = 'Kemaskini ' + capitalizeFirstLetter(role);
    document.getElementById('keraniId').value = data.id;
    document.getElementById('nama_penuh').value = data.nama_penuh;
    document.getElementById('no_kp').value = data.no_kp;
    document.getElementById('email').value = data.email;
    document.getElementById('submitBtn').innerText = 'Kemaskini';
    document.getElementById('cancelBtn').style.display = 'inline-block';
    // Update the main form action for editing
    document.getElementById('keraniForm').action = '<?= base_url('admin/user_simpan/') ?>' + role;
}

function resetForm(role) {
    document.getElementById('keraniForm').reset();
    document.getElementById('keraniId').value = '';
    document.getElementById('formTitle').innerText = 'Daftar ' + capitalizeFirstLetter(role) + ' Baru';
    document.getElementById('submitBtn').innerText = 'Simpan';
    document.getElementById('cancelBtn').style.display = 'none';
    // Reset the main form action
    document.getElementById('keraniForm').action = '<?= base_url('admin/user_simpan/') ?>' + role;
}

function confirmDelete(id, role) {
    setModalFormAction('deleteForm', '<?= base_url('admin/user_padam/') ?>' + role + '/', id);
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

function confirmReset(id, role) {
    setModalFormAction('resetForm', '<?= base_url('admin/user_reset/') ?>' + role + '/', id);
    new bootstrap.Modal(document.getElementById('resetModal')).show();
}

function confirmSekat(id, role) {
    setModalFormAction('sekatForm', '<?= base_url('admin/user_sekat/') ?>' + role + '/', id);
    new bootstrap.Modal(document.getElementById('sekatModal')).show();
}

function confirmAktif(id, role) {
    setModalFormAction('aktifForm', '<?= base_url('admin/user_aktifkan/') ?>' + role + '/', id);
    new bootstrap.Modal(document.getElementById('aktifModal')).show();
}
</script>

<?php if (isset($mesej) && $mesej): ?>
    <div class="toast-container position-fixed top-50 start-50 translate-middle p-3">
        <div id="liveToast" class="toast show border-0 shadow-lg" role="alert" aria-live="assertive"
             aria-atomic="true">
            <div class="toast-header <?= esc($mesej['warna']) ?> text-white">
                <strong class="me-auto">
                    <i class="fas fa-info-circle me-2"></i><?= esc($mesej['tajuk']) ?>
                </strong>
                <small class="text-white"><?= date('h:i a') ?></small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                <?= esc($mesej['isi']) ?>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let toastElList = [].slice.call(document.querySelectorAll('.toast'));
            toastElList.map(function (toastEl) {
                new bootstrap.Toast(toastEl).show()
            });
        });
    </script>
<?php endif; ?>

<!-- Modal Padam -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="deleteForm" method="post">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title">Sahkan Padam</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Adakah anda pasti ingin memadam data ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Padam</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Reset -->
<div class="modal fade" id="resetModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="resetForm" method="post">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title">Sahkan Reset Kata Laluan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Adakah anda pasti ingin set semula kata laluan pengguna ini kepada nombor kad pengenalannya?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-info">Reset Kata Laluan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Sekat -->
<div class="modal fade" id="sekatModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="sekatForm" method="post">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title">Sahkan Sekatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Adakah anda pasti ingin menyekat capaian akaun pengguna ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-secondary">Sekat Akaun</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Aktifkan -->
<div class="modal fade" id="aktifModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="aktifForm" method="post">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title">Sahkan Aktifkan Semula</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Adakah anda pasti ingin mengaktifkan semula akaun pengguna ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Aktifkan Akaun</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>