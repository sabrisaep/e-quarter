<?php
/**
 * @var array $mesej
 * @var object $pengguna
 */
$role = session()->get('role');
?>
<!DOCTYPE html>
<html lang="ms">
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
        <img src="<?= base_url('assets/images/logo_kvsas.png') ?>" alt="Logo KVSAS" height="50"
             class="me-3">
        <a class="navbar-brand" href="#">E-Quarter 2.0</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav gap-2">

                <?php if ($role == 'kerani'): ?>
                    <li class="nav-item">
                        <a class="nav-link link-primary text-secondary <?= url_is("kerani/sukuan*") ? 'active fw-bold' : '' ?>"
                           href="<?= base_url("kerani/sukuan") ?>">Sukuan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link-primary text-secondary <?= url_is("kerani/subsidiari*") ? 'active fw-bold' : '' ?>"
                           href="<?= base_url("kerani/subsidiari") ?>">Subsidiari</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link-primary text-secondary <?= url_is("kerani/profil*") ? 'active fw-bold' : '' ?>"
                           href="<?= base_url("kerani/profil") ?>">Profil</a>
                    </li>
                <?php elseif ($role == 'ketua'): ?>
                    <li class="nav-item">
                        <a class="nav-link link-primary text-secondary <?= url_is("ketua/kategori*") ? 'active fw-bold' : '' ?>"
                           href="<?= base_url("ketua/kategori") ?>">Kategori</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link-primary text-secondary <?= url_is("ketua/sukuan*") ? 'active fw-bold' : '' ?>"
                           href="<?= base_url("ketua/sukuan") ?>">Sukuan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link-primary text-secondary <?= url_is("ketua/nota_minta*") ? 'active fw-bold' : '' ?>"
                           href="<?= base_url("ketua/nota_minta") ?>">Nota Minta</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link-primary text-secondary <?= url_is("ketua/profil*") ? 'active fw-bold' : '' ?>"
                           href="<?= base_url("ketua/profil") ?>">Profil</a>
                    </li>
                <?php elseif ($role == 'pengurusan'): ?>
                    <li class="nav-item">
                        <a class="nav-link link-primary text-secondary <?= url_is("pengurusan/perbelanjaan*") ? 'active fw-bold' : '' ?>"
                           href="<?= base_url("pengurusan/perbelanjaan") ?>">Perbelanjaan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link-primary text-secondary <?= url_is("pengurusan/subsidiari*") ? 'active fw-bold' : '' ?>"
                           href="<?= base_url("pengurusan/subsidiari") ?>">Subsidiari</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link-primary text-secondary <?= url_is("pengurusan/analisis*") ? 'active fw-bold' : '' ?>"
                           href="<?= base_url("pengurusan/analisis") ?>">Analisis</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link-primary text-secondary <?= url_is("pengurusan/profil*") ? 'active fw-bold' : '' ?>"
                           href="<?= base_url("pengurusan/profil") ?>">Profil</a>
                    </li>
                <?php endif; ?>

                <li class="nav-item">
                    <a class="nav-link text-danger link-primary" href="<?= base_url('logout') ?>">Log Keluar</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <!-- Butiran Pengguna -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-user-circle fa-3x text-secondary"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">Nama Penuh</small>
                        <span class="fw-bold"><?= esc($pengguna->nama_penuh) ?></span>
                    </div>
                </div>
                <div class="col-md-3 d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-envelope fa-2x text-secondary"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">Email</small>
                        <span><?= esc($pengguna->email) ?></span>
                    </div>
                </div>
                <div class="col-md-3 d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-user-tag fa-2x text-secondary"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">Peranan</small>
                        <span><?= PENGGUNA[esc($role)] ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<?= $this->renderSection('script') ?>

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

</body>
</html>
