<?= $this->extend('layout/admin'); ?>
<?= $this->section('content'); ?>
<?php
/**
 * @var object $admin
 */
?>

<h1 class="text-primary">Tukar Kata Laluan Pentadbir Sistem</h1>
<p class="text-muted">Kemaskini terakhir: <?= isset($admin->updated_at) ? format_tarikh_malaysia($admin->updated_at) : 'Tiada rekod' ?></p>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="row align-items-stretch">
                    <div class="col-md-6 border-right">
                        <form id="formTukarKataLaluan" action="<?= base_url('admin/kata_laluan_simpan') ?>" method="post">
                            <?= csrf_field() ?>

                            <div class="form-group mb-3">
                                <label for="kata_laluan_lama">Kata Laluan Lama</label>
                                <input type="password" name="kata_laluan_lama" id="kata_laluan_lama" class="form-control" required autofocus>
                            </div>

                            <div class="form-group mb-3">
                                <label for="kata_laluan_baru">Kata Laluan Baru</label>
                                <input type="password" name="kata_laluan_baru" id="kata_laluan_baru" class="form-control" required minlength="8">
                            </div>

                            <div class="form-group mb-3">
                                <label for="sahkan_kata_laluan">Sahkan Kata Laluan Baru</label>
                                <input type="password" name="sahkan_kata_laluan" id="sahkan_kata_laluan" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">Simpan Perubahan</button>
                        </form>
                    </div>
                    <div class="col-md-6 bg-light p-4">
                        <h5 class="font-weight-bold">Syarat Kata Laluan:</h5>
                        <ul class="small text-muted">
                            <li>Minimum 8 aksara.</li>
                            <li>Kata laluan baru mestilah berbeza dengan kata laluan lama.</li>
                            <li>Pastikan pengesahan kata laluan adalah sama dengan kata laluan baru.</li>
                            <li>Mestilah menggunakan kombinasi huruf dan nombor untuk keselamatan optimum.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Pengesahan -->
<div class="modal fade" id="modalSahkanTukar" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Pengesahan Kemaskini</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Adakah anda pasti ingin menukar kata laluan?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="btnConfirmSubmit" class="btn btn-primary">Ya, Simpan</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<script>
    function showWarningModal(message) {
        // Menggunakan modal sedia ada atau mengubah suai teks modal untuk ralat
        $('#modalLabel').text('Ralat Validasi');
        $('.modal-body').html('<div class="text-danger">' + message + '</div>');
        $('#btnConfirmSubmit').hide(); // Sembunyi butang simpan jika ralat
        $('.btn-secondary').text('Tutup');

        $('#modalSahkanTukar').modal('show');
    }

    const form = document.getElementById('formTukarKataLaluan');

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const oldPassword = document.getElementById('kata_laluan_lama').value;
        const password = document.getElementById('kata_laluan_baru').value;
        const confirm = document.getElementById('sahkan_kata_laluan').value;

        // Reset modal state
        $('#modalLabel').text('Pengesahan Kemaskini');
        $('.modal-body').text('Adakah anda pasti ingin menukar kata laluan?');
        $('#btnConfirmSubmit').show();
        $('.btn-secondary').text('Batal');

        if (password.length < 8) {
            showWarningModal('Kata laluan baru mestilah sekurang-kurangnya 8 aksara!');
            return false;
        }

        if (password === oldPassword) {
            showWarningModal('Kata laluan baru mestilah berbeza dengan kata laluan lama!');
            return false;
        }

        const hasLetter = /[a-zA-Z]/.test(password);
        const hasNumber = /[0-9]/.test(password);
        if (!hasLetter || !hasNumber) {
            showWarningModal('Kata laluan baru mestilah mengandungi kombinasi huruf dan nombor!');
            return false;
        }

        if (password !== confirm) {
            showWarningModal('Kata laluan baru dan pengesahan tidak sepadan!');
            return false;
        }

        $('#modalSahkanTukar').modal('show');
    });

    document.getElementById('btnConfirmSubmit').addEventListener('click', function() {
        form.submit();
    });
</script>
<?= $this->endSection(); ?>
