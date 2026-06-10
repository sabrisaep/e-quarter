<?= $this->extend('layout/admin'); ?>
<?= $this->section('content'); ?>
<?php
/**
 * @var object $jabatan
 */
?>

<h1 class="text-primary">Senarai Jabatan</h1>

<!--
TODO
field dalam table jabatan adalah nama_jabatan.
sediakan form untuk mendaftarkan jabatan baru.
diikuti senarai nama_jabatan, di hujung setiap baris data ada button Edit & Padam.
bila klik button Edit, data tersebut akan masuk ke dalam form, untuk kemaskini data.
-->

<?= $this->endSection(); ?>
<?= $this->section('script'); ?>

<?= $this->endSection(); ?>
