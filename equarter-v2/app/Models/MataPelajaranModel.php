<?php

namespace App\Models;

use CodeIgniter\Model;

class MataPelajaranModel extends Model
{
    // Nama jadual di dalam pangkalan data
    protected $table            = 'mata_pelajaran';

    // Primary key untuk jadual ini
    protected $primaryKey       = 'id';

    // Menetapkan auto increment kepada true kerana 'id' menggunakan auto_increment
    protected $useAutoIncrement = true;

    // Mematikan soft deletes kerana tiada kolum deleted_at dalam migration
    protected $useSoftDeletes   = false;

    // Kolum-kolum yang dibenarkan untuk operasi sedia ada (Mass Assignment)
    // Sila pastikan kolum 'id' tidak dimasukkan di sini
    protected $allowedFields    = [
        'program_id',
        'nama_mp',
    ];

    // Mengeset ke false kerana jadual ini tiada kolum created_at & updated_at
    protected $useTimestamps = false;

    // Peraturan Validasi (Pilihan tetapi sangat digalakkan)
    protected $validationRules      = [
        'program_id' => 'required|is_natural_no_zero',
        'nama_mp'    => 'required|min_length[3]|max_length[255]',
    ];

    protected $validationMessages   = [
        'program_id' => [
            'required'           => 'ID Program wajib diisi.',
            'is_natural_no_zero' => 'ID Program mestilah nombor sah.'
        ],
        'nama_mp' => [
            'required'   => 'Nama mata pelajaran wajib diisi.',
            'min_length' => 'Nama mata pelajaran terlalu pendek.',
            'max_length' => 'Nama mata pelajaran tidak boleh melebihi 255 aksara.'
        ],
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
