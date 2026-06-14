<?= $this->extend('layout/admin'); ?>
<?= $this->section('content'); ?>
<?php
/**
 * @var object $jabatan
 */
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="text-primary mb-0">Senarai Mata Pelajaran</h1>
    <a href="<?= base_url('admin/mata_pelajaran') ?>" class="btn btn-outline-primary btn-warning">
        <i class="fas fa-list"></i> Lihat Ikut Program
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="dataTable">
                <thead>
                <tr>
                    <th>Bil</th>
                    <th>Jabatan</th>
                    <th>Program</th>
                    <th>Mata Pelajaran</th>
                </tr>
                </thead>
                <tbody>
                <?php $no = 1;
                foreach ($jabatan as $j):
                    $rowspan_jabatan = 0;
                    foreach ($j->program as $p) {
                        $rowspan_jabatan += count($p->mata_pelajaran);
                    }
                    ?>
                    <?php foreach ($j->program as $p_index => $p):
                        $rowspan_program = count($p->mata_pelajaran);
                        ?>
                        <?php foreach ($p->mata_pelajaran as $mp_index => $mp): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <?php if ($p_index === 0 && $mp_index === 0): ?>
                                    <td rowspan="<?= $rowspan_jabatan; ?>"
                                        style="border-top-width: 1px; border-top-color: black">
                                        <?= $j->nama_jabatan; ?>
                                    </td>
                                <?php endif; ?>
                                <?php if ($mp_index === 0): ?>
                                    <td rowspan="<?= $rowspan_program; ?>"
                                        style="border-top-width: 1px; border-top-color: black">
                                        <?= $p->nama_program; ?>
                                    </td>
                                <?php endif; ?>
                                <td><?= $mp->nama_mp; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
