<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>
<?php
/**
 * @var int $jumlahJabatan
 * @var int $jumlahProgram
 * @var int $jumlahMataPelajaran
 *
 * @var int $jumlahKerani
 * @var int $jumlahPengurusan
 * @var int $jumlahKetua
 *
 * @var object $kerani
 * @var object $ketua
 * @var object $pengurusan
 */
?>

    <h1 class="text-primary">Dashboard Pentadbir Sistem</h1>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 text-xs font-weight-bold text-uppercase mb-1">Jumlah Jabatan</div>
                            <div class="h3 mb-0 font-weight-bold text-primary">
                                <?= $jumlahJabatan ?>
                                <span class="font-weight-normal h5">JABATAN</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-university fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 text-xs font-weight-bold text-uppercase mb-1">Jumlah Program</div>
                            <div class="h3 mb-0 font-weight-bold text-primary">
                                <?= $jumlahProgram ?>
                                <span class="font-weight-normal h5">PROGRAM</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-graduation-cap fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 text-xs font-weight-bold text-uppercase mb-1">Jumlah Mata Pelajaran</div>
                            <div class="h3 mb-0 font-weight-bold text-primary">
                                <?= $jumlahMataPelajaran ?>
                                <span class="font-weight-normal h5">MATA PELAJARAN</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 text-xs font-weight-bold text-uppercase mb-1">Pihak Pengurusan</div>
                            <div class="h3 mb-0 font-weight-bold text-primary">
                                <?= $jumlahPengurusan ?>
                                <span class="font-weight-normal h5">ORANG</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-shield fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 text-xs font-weight-bold text-uppercase mb-1">Kerani Kewangan</div>
                            <div class="h3 mb-0 font-weight-bold text-primary">
                                <?= $jumlahKerani ?>
                                <span class="font-weight-normal h5">ORANG</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-invoice-dollar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 text-xs font-weight-bold text-uppercase mb-1">Ketua Program / Jabatan</div>
                            <div class="h3 mb-0 font-weight-bold text-primary">
                                <?= $jumlahKetua ?>
                                <span class="font-weight-normal h5">ORANG</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card shadow mt-3 h-100 py-2">
                <div class="card-header py-3">
                    <h5 class="m-0 font-weight-bold text-primary">Senarai Pihak Pengurusan</h5>
                </div>
                <div class="card-body">
                    <ol class="mb-0">
                        <?php foreach ($pengurusan as $p): ?>
                            <li><?= esc($p->nama_penuh) ?></li>
                        <?php endforeach; ?>
                    </ol>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow mt-3 h-100 py-2">
                <div class="card-header py-3">
                    <h5 class="m-0 font-weight-bold text-primary">Senarai Kerani Kewangan</h5>
                </div>
                <div class="card-body">
                    <ol class="mb-0">
                        <?php foreach ($kerani as $k): ?>
                            <li><?= esc($k->nama_penuh) ?></li>
                        <?php endforeach; ?>
                    </ol>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow mt-3 h-100 py-2">
                <div class="card-header py-3">
                    <h5 class="m-0 font-weight-bold text-primary">Senarai Ketua Program / Jabatan</h5>
                </div>
                <div class="card-body">
                    <ol class="mb-0">
                        <?php foreach ($ketua as $kt): ?>
                            <li><?= esc($kt->nama_penuh) ?></li>
                        <?php endforeach; ?>
                    </ol>
                </div>
            </div>
        </div>
    </div>

<?= $this->endSection() ?>
<?= $this->section('script') ?>

<?= $this->endSection() ?>