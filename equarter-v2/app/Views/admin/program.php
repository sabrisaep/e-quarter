<?= $this->extend('layout/admin'); ?>
<?= $this->section('content'); ?>
<?php
/**
 * @var object $jabatan
 */
?>

<h1 class="text-primary">Senarai Program</h1>

<div class="card mb-4">
    <div class="card-header">Daftar Program Baru</div>
    <div class="card-body">
        <form action="<?= base_url('admin/program_simpan'); ?>" method="post">
            <?= csrf_field(); ?>
            <input type="hidden" name="id" id="programId">
            <div class="row">
                <div class="col-md-5 mb-3">
                    <label for="jabatan_id" class="form-label">Jabatan</label>
                    <select name="jabatan_id" id="jabatan_id" class="form-select" required>
                        <option value="">-- Pilih Jabatan --</option>
                        <?php foreach ($jabatan as $j) : ?>
                            <option value="<?= $j->id; ?>"><?= $j->nama_jabatan; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-5 mb-3">
                    <label for="nama_program" class="form-label">Nama Program</label>
                    <input type="text" name="nama_program" id="nama_program" class="form-control" required>
                </div>
                <div class="col-md-2 mb-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary" id="submitBtn">Simpan</button>
                    <button type="button" class="btn btn-secondary" id="cancelBtn" style="display:none;"
                            onclick="resetFormProgram()">Batal
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php if (!empty($jabatan) && is_array($jabatan)): ?>
    <?php foreach ($jabatan as $j): ?>
        <div class="card mt-4">
            <div class="card-header">
                <h4 class="mb-0 text-dark"><?= esc($j->nama_jabatan); ?></h4>
            </div>
            <div class="card-body">
                <h5 class="mb-3">Senarai Program</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th style="width: 50px;">Bil</th>
                            <th>Nama Program</th>
                            <th style="width: 200px;">Bilangan Mata Pelajaran</th>
                            <th style="width: 150px;">Tindakan</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($j->program)): ?>
                            <?php foreach ($j->program as $index => $program): ?>
                                <tr>
                                    <td><?= $index + 1; ?></td>
                                    <td><?= esc($program->nama_program); ?></td>
                                    <td><?= $program->mata_pelajaran ?? 0; ?></td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning"
                                                onclick="editProgram(<?= $program->id; ?>, '<?= esc($program->nama_program, 'js'); ?>', <?= $j->id; ?>)">
                                            Edit
                                        </button>
                                        <?php if (($program->mata_pelajaran ?? 0) > 0): ?>
                                            <button type="button" class="btn btn-sm btn-danger" disabled
                                                    title="Program mempunyai mata pelajaran">Padam
                                            </button>
                                        <?php else: ?>
                                            <button type="button" class="btn btn-sm btn-danger"
                                                    onclick="confirmDeleteProgram(<?= $program->id; ?>)">Padam
                                            </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">Tiada data dijumpai.</td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    <?php endforeach; ?>
<?php endif; ?>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Sahkan Padam</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Adakah anda pasti ingin memadam program ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" action="" method="post" style="display: inline;">
                    <?= csrf_field(); ?>
                    <button type="submit" class="btn btn-danger">Padam</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<script>
    function editProgram(id, nama, jabatanId) {
        document.getElementById('programId').value = id;
        document.getElementById('nama_program').value = nama;
        document.getElementById('jabatan_id').value = jabatanId;

        document.querySelector('.card-header').innerText = 'Kemaskini Program';
        document.getElementById('submitBtn').innerText = 'Kemaskini';
        document.getElementById('cancelBtn').style.display = 'inline-block';

        window.scrollTo({top: 0, behavior: 'smooth'});
    }

    function resetFormProgram() {
        document.getElementById('programId').value = '';
        document.getElementById('nama_program').value = '';
        document.getElementById('jabatan_id').value = '';

        document.querySelector('.card-header').innerText = 'Daftar Program Baru';
        document.getElementById('submitBtn').innerText = 'Simpan';
        document.getElementById('cancelBtn').style.display = 'none';
    }

    function confirmDeleteProgram(id) {
        document.getElementById('deleteForm').action = "<?= base_url('admin/program_padam/'); ?>/" + id;
        var myModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        myModal.show();
    }
</script>
<?= $this->endSection(); ?>
