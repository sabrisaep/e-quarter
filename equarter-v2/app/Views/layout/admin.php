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
                    <a class="nav-link" href="<?= base_url('admin/kerani') ?>">Kerani</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('admin/ketua') ?>">Ketua</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('admin/pengurusan') ?>">Pengurusan</a>
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
<?= $this->renderSection('script') ?>

<?php if (isset($mesej) && $mesej): ?>
    <div class="toast-container position-fixed top-50 start-50 translate-middle p-3">
        <div id="liveToast" class="toast show border-0 shadow-lg" role="alert" aria-live="assertive"
             aria-atomic="true">
            <div class="toast-header <?= esc($mesej['warna']) ?> text-white">
                <strong class="me-auto">
                    <i class="fas fa-info-circle me-2"></i><?= esc($mesej['tajuk']) ?>
                </strong>
                <small class="text-white-50"><?= date('h:i a') ?></small>
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