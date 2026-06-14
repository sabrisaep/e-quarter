<?= $this->extend('layout/admin'); ?>
<?= $this->section('content'); ?>
<?php
/**
 * @var object $jabatan
 * @var int|null $selectedJabatan
 * @var int|null $selectedProgram
 */
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="text-primary mb-0">Senarai Mata Pelajaran</h1>
    <a href="<?= base_url('admin/mata_pelajaran_semua') ?>" class="btn btn-outline-primary btn-warning">
        <i class="fas fa-list"></i> Lihat Semua Mata Pelajaran
    </a>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h5 class="m-0 font-weight-bold" id="form-title">Tambah Mata Pelajaran Baru</h5>
            </div>
            <div class="card-body">
                <form id="form-mp" action="<?= base_url('admin/mata_pelajaran_simpan') ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id" id="mp_id">
                    <div class="form-group">
                        <label for="jabatan_id">Jabatan</label>
                        <select name="jabatan_id" id="jabatan_id" class="form-control" required>
                            <option value="">-- Pilih Jabatan --</option>
                            <?php foreach ($jabatan as $j) : ?>
                                <option value="<?= $j->id ?>" <?= (isset($selectedJabatan) && $selectedJabatan == $j->id) ? 'selected' : '' ?>><?= $j->nama_jabatan ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <label for="program_id">Program</label>
                        <select name="program_id" id="program_id" class="form-control" required disabled>
                            <option value="">-- Pilih Program --</option>
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <label for="nama_mp">Nama Mata Pelajaran</label>
                        <input type="text" name="nama_mp" id="nama_mp" class="form-control" required>
                    </div>
                    <button type="submit" id="btn-submit" class="btn btn-primary mt-3">Simpan</button>
                    <button type="button" id="btn-batal" class="btn btn-secondary mt-3 d-none" onclick="resetForm()">Batal</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h5 class="m-0 font-weight-bold">Senarai Mata Pelajaran</h5>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="filter_jabatan">Pilih Jabatan</label>
                    <select id="filter_jabatan" class="form-control">
                        <option value="">-- Pilih Jabatan --</option>
                        <?php foreach ($jabatan as $j) : ?>
                            <option value="<?= $j->id ?>" <?= (isset($selectedJabatan) && $selectedJabatan == $j->id) ? 'selected' : '' ?>><?= $j->nama_jabatan ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group mt-3">
                    <label for="filter_program">Pilih Program</label>
                    <select id="filter_program" class="form-control" disabled>
                        <option value="">-- Pilih Program --</option>
                    </select>
                </div>

                <div class="table-responsive mt-4">
                    <table class="table table-bordered table-striped" id="table_mp">
                        <thead>
                            <tr>
                                <th>Bil</th>
                                <th>Mata Pelajaran</th>
                                <th style="width: 150px;">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody id="list_mata_pelajaran">
                            <tr>
                                <td colspan="3" class="text-center">Sila pilih program</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<script>
    $(document).ready(function() {
        $('#jabatan_id').change(function(e, selectedProgramId = null) {
            let jabatanId = $(this).val();
            let programSelect = $('#program_id');

            if (jabatanId) {
                $.ajax({
                    url: "<?= base_url('admin/get-program-by-jabatan') ?>/" + jabatanId,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        programSelect.empty();
                        programSelect.append('<option value="">-- Pilih Program --</option>');
                        $.each(data, function(key, value) {
                            let selected = (selectedProgramId == value.id) ? 'selected' : '';
                            programSelect.append('<option value="' + value.id + '" ' + selected + '>' + value.nama_program + '</option>');
                        });
                        programSelect.prop('disabled', false);
                    }
                });
            } else {
                programSelect.empty();
                programSelect.append('<option value="">-- Pilih Program --</option>');
                programSelect.prop('disabled', true);
            }
        });

        // Filter logic for the list card
        $('#filter_jabatan').change(function(e, selectedProgramId = null) {
            let jabatanId = $(this).val();
            let programSelect = $('#filter_program');
            $('#list_mata_pelajaran').html('<tr><td colspan="3" class="text-center">Sila pilih program</td></tr>');

            if (jabatanId) {
                $.ajax({
                    url: "<?= base_url('admin/get-program-by-jabatan') ?>/" + jabatanId,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        programSelect.empty().append('<option value="">-- Pilih Program --</option>');
                        $.each(data, function(key, value) {
                            let selected = (selectedProgramId == value.id) ? 'selected' : '';
                            programSelect.append('<option value="' + value.id + '" ' + selected + '>' + value.nama_program + '</option>');
                        });
                        programSelect.prop('disabled', false);
                        if(selectedProgramId) {
                            programSelect.trigger('change');
                        }
                    }
                });
            } else {
                programSelect.empty().append('<option value="">-- Pilih Program --</option>').prop('disabled', true);
            }
        });

        $('#filter_program').change(function() {
            let programId = $(this).val();
            let tableBody = $('#list_mata_pelajaran');

            if (programId) {
                tableBody.html('<tr><td colspan="3" class="text-center">Memuatkan...</td></tr>');
                $.ajax({
                    url: "<?= base_url('admin/get-mp-by-program') ?>/" + programId,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        tableBody.empty();
                        if (data.length > 0) {
                            $.each(data, function(index, item) {
                                tableBody.append(`
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>${item.nama_mp}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-warning btn-edit" data-id="${item.id}" data-nama="${item.nama_mp}" data-jabatan="${$('#filter_jabatan').val()}" data-program="${programId}">Edit</button>
                                            <a href="<?= base_url('admin/mata_pelajaran_padam') ?>/${item.id}" class="btn btn-sm btn-danger" onclick="return confirm('Adakah anda pasti?')">Padam</a>
                                        </td>
                                    </tr>
                                `);
                            });
                        } else {
                            tableBody.append('<tr><td colspan="3" class="text-center">Tiada data ditemui</td></tr>');
                        }
                    }
                });
            } else {
                tableBody.html('<tr><td colspan="3" class="text-center">Sila pilih program</td></tr>');
            }
        });

        // Auto-trigger if IDs are passed from controller
        <?php if (isset($selectedJabatan)): ?>
            let initialProgramId = <?= json_encode($selectedProgram ?? null) ?>;
            $('#jabatan_id').trigger('change', [initialProgramId]);
            $('#filter_jabatan').trigger('change', [initialProgramId]);
        <?php endif; ?>

        $(document).on('click', '.btn-edit', function() {
            let id = $(this).data('id');
            let nama = $(this).data('nama');
            let jabatanId = $(this).data('jabatan');
            let programId = $(this).data('program');

            $('#form-title').text('Kemaskini Mata Pelajaran');
            $('#form-mp').attr('action', '<?= base_url('admin/mata_pelajaran_simpan') ?>');
            $('#mp_id').val(id);
            $('#nama_mp').val(nama);
            $('#jabatan_id').val(jabatanId).trigger('change');

            // Wait for program dropdown to populate before setting value
            setTimeout(function() {
                $('#program_id').val(programId);
            }, 500);

            $('#btn-submit').text('Kemaskini').removeClass('btn-primary').addClass('btn-success');
            $('#btn-batal').removeClass('d-none');

            // Scroll to form
            $('html, body').animate({
                scrollTop: $("#form-mp").offset().top - 100
            }, 500);
        });
    });

    function resetForm() {
        let formMp = $('#form-mp');
        $('#form-title').text('Tambah Mata Pelajaran Baru');
        formMp.attr('action', '<?= base_url('admin/mata_pelajaran_simpan') ?>');
        formMp[0].reset();
        $('#mp_id').val('');
        $('#program_id').prop('disabled', true);
        $('#btn-submit').text('Simpan').removeClass('btn-success').addClass('btn-primary');
        $('#btn-batal').addClass('d-none');
    }
</script>
<?= $this->endSection(); ?>
