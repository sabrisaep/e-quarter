<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>e-Quarter 2.0</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- HEADER (LOGO - FULL WIDTH PUTIH) -->
<div class="bg-white py-3 shadow-sm">
    <div class="container text-center">
        <img src="<?= base_url('assets/images/logo_kpm.jpg') ?>" alt="Logo KPM" height="50" class="me-3">
        <img src="<?= base_url('assets/images/logo_kvsas.png') ?>" alt="Logo KVSAS" height="50">
    </div>
</div>

<!-- TAJUK SISTEM -->
<div class="container text-center my-4">
    <h3 class="fw-bold mt-5">Sistem Pengurusan Kewangan e-Quarter</h3>
    <p class="text-muted">Sila log masuk untuk meneruskan</p>
</div>

<!-- CONTENT -->
<div class="container">
    <div class="row shadow rounded overflow-hidden w-75 mx-auto">

        <!-- LEFT SIDE -->
        <div class="col-md-6 bg-primary text-white p-5 d-none d-md-block">
            <h4 class="fw-bold">e-Quarter 2.0</h4>
            <p class="mt-3">
                Sistem e-Quarter 2.0 merupakan inovasi sistem pengurusan kewangan yang dibangunkan secara dalam talian
                bagi merekod, mengemaskini dan memantau data perbelanjaan khususnya bagi Peruntukan Dana Bantuan Geran
                Per Kapita. Sistem ini juga dapat menyediakan laporan perbelanjaan wang kerajaan mengikut sukuan bagi
                tahun.
            </p>
        </div>

        <!-- RIGHT SIDE (LOGIN) -->
        <div class="col-md-6 bg-white p-5">
            <form method="post" action="<?= base_url('login') ?>">
                <div class="mb-3">
                    <label for="username" class="form-label fw-bold">ID Pengguna</label>
                    <input type="text" name="username" id="username" class="form-control" required autofocus>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label fw-bold">Kata Laluan</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        Log Masuk
                    </button>
                </div>
            </form>

            <p class="text-center mt-3 text-muted small">
                Akses terhad untuk pengguna berdaftar sahaja
            </p>
        </div>
    </div>
</div>

<div class="container my-5">
    <div class="card border-3 border-primary shadow-sm rounded mx-auto">
        <div class="card-header bg-light py-3">
            <h5 class="card-title mb-0 fw-bold text-primary">
                <i class="fas fa-chart-line me-2"></i>Perkembangan Pembangunan Sistem e-Quarter
            </h5>
        </div>
        <div class="card-body">
            <div class="row text-center">
                <div class="col-md-3">
                    <div class="card h-100 border-primary shadow-sm">
                        <div class="card-header fw-bold bg-primary text-white">Pentadbir Sistem</div>
                        <div class="card-body">
                            <p class="card-text">Menguruskan senarai kerani kewangan, ketua program / jabatan & pihak pengurusan.</p>
                        </div>
                        <div class="card-footer">
                            Pembangunan sedang berjalan
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 border-secondary">
                        <div class="card-header fw-bold">Kerani Kewangan</div>
                        <div class="card-body">
                            <p class="card-text small">Modul ini sedang dalam perancangan. Struktur asas dan keperluan fungsi sedang dikenal pasti.</p>
                        </div>
                        <div class="card-footer text-muted small">
                            Pembangunan belum bermula
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 border-secondary">
                        <div class="card-header fw-bold">Ketua Program / Jabatan</div>
                        <div class="card-body">
                            <p class="card-text small">Modul ini sedang dalam perancangan. Struktur asas dan keperluan fungsi sedang dikenal pasti.</p>
                        </div>
                        <div class="card-footer text-muted small">
                            Pembangunan belum bermula
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 border-secondary">
                        <div class="card-header fw-bold">Pihak Pengurusan</div>
                        <div class="card-body">
                            <p class="card-text small">Modul ini sedang dalam perancangan. Struktur asas dan keperluan fungsi sedang dikenal pasti.</p>
                        </div>
                        <div class="card-footer text-muted small">
                            Pembangunan belum bermula
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="my-3 py-3"></div>

<footer class="footer mt-auto py-3 bg-white border-top fixed-bottom">
    <div class="container text-center">
        <span class="text-muted small">
             &copy; <?= date('Y') == '2026' ? '2026' : '2026 - ' . date('Y') ?>
            e-Quarter 2.0. Kolej Vokasional Sultan Abdul Samad. Hak Cipta Terpelihara.
        </span>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

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
