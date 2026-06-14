<?= $this->extend('layout/admin'); ?>
<?= $this->section('content'); ?>
<?php
/**
 * @var object[] $jabatan
 */
?>

<h1 class="text-primary">Senarai Jabatan</h1>

<div class="card mb-4">
    <div class="card-header">
        <h5 id="formTitleJabatan" class="mb-0">Daftar Jabatan Baru</h5>
    </div>
    <div class="card-body">
        <form id="jabatanForm" action="<?= base_url('admin/jabatan_simpan'); ?>" method="post">
            <?= csrf_field(); ?>
            <input type="hidden" name="id" id="jabatanId">
            <div class="input-group">
                <label for="nama_jabatan" class="input-group-text">Nama Jabatan</label>
                <input type="text" name="nama_jabatan" id="nama_jabatan" class="form-control" required>
                <button type="submit" class="btn btn-primary" id="submitBtnJabatan">Simpan</button>
                <button type="button" class="btn btn-secondary d-none" id="cancelBtnJabatan" onclick="resetFormJabatan()">Batal</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th style="width: 50px;">No.</th>
                    <th>Nama Jabatan</th>
                    <th style="width: 200px;">Bilangan Ketua</th>
                    <th style="width: 200px;">Bilangan Program</th>
                    <th style="width: 150px;">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($jabatan)): ?>
                    <?php foreach ($jabatan as $index => $row): ?>
                        <tr>
                            <td><?= $index + 1; ?></td>
                            <td><?= esc($row->nama_jabatan); ?></td>
                            <td><?= $row->ketua ?? 0; ?></td>
                            <td><?= $row->bilangan_program ?? 0; ?></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-warning" onclick="editJabatan(<?= $row->id; ?>, '<?= esc($row->nama_jabatan, 'js'); ?>')">Edit</button>
                                <?php if (($row->bilangan_program ?? 0) > 0 || ($row->ketua ?? 0) > 0): ?>
                                    <button type="button" class="btn btn-sm btn-danger" disabled title="Jabatan mempunyai program atau ketua">Padam</button>
                                <?php else: ?>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDeleteJabatan(<?= $row->id; ?>)">Padam</button>
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

<!-- Delete Confirmation Modal for Jabatan -->
<div class="modal fade" id="deleteJabatanModal" tabindex="-1" aria-labelledby="deleteJabatanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteJabatanModalLabel">Pengesahan Padam Jabatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Adakah anda pasti ingin memadam data jabatan ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteJabatanForm" action="" method="post">
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
    const deleteJabatanModalInstance = new bootstrap.Modal(document.getElementById('deleteJabatanModal'));

    function editJabatan(id, nama) {
        document.getElementById('formTitleJabatan').innerText = 'Kemaskini Jabatan';
        document.getElementById('jabatanId').value = id;
        document.getElementById('nama_jabatan').value = nama;
        document.getElementById('submitBtnJabatan').innerText = 'Kemaskini';
        document.getElementById('cancelBtnJabatan').classList.remove('d-none');

        // Ensure action URL is correct for update
        document.getElementById('jabatanForm').action = "<?= base_url('admin/jabatan_simpan'); ?>";

        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function resetFormJabatan() {
        document.getElementById('formTitleJabatan').innerText = 'Daftar Jabatan Baru';
        document.getElementById('jabatanId').value = '';
        document.getElementById('nama_jabatan').value = '';
        document.getElementById('submitBtnJabatan').innerText = 'Simpan';
        document.getElementById('cancelBtnJabatan').classList.add('d-none');
        // Ensure action URL is correct for insert
        document.getElementById('jabatanForm').action = "<?= base_url('admin/jabatan_simpan'); ?>";
    }

    function confirmDeleteJabatan(id) {
        document.getElementById('deleteJabatanForm').action = "<?= base_url('admin/jabatan_padam'); ?>/" + id;
        deleteJabatanModalInstance.show();
    }
</script>
<?= $this->endSection(); ?>