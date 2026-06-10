<?php

namespace App\Models;

use CodeIgniter\Model;

class JabatanModel extends Model
{
    // Nama jadual di database
    protected $table            = 'jabatan';

    // Primary key untuk jadual ini
    protected $primaryKey       = 'id';

    // Kolum yang dibenarkan untuk operasi INSERT dan UPDATE
    protected $allowedFields    = [
        'nama_jabatan',
    ];

    // Tetapan masa (ditetapkan ke false kerana jadual kita tiada created_at/updated_at)
    protected $useTimestamps = false;

    // Peraturan validasi (Pilihan - sangat berguna semasa simpan data)
    protected $validationRules      = [
        'nama_jabatan' => 'required|max_length[150]|is_unique[jabatan.nama_jabatan,id,{id}]',
    ];

    protected $validationMessages   = [
        'nama_jabatan' => [
            'required'  => 'Nama jabatan wajib diisi.',
            'max_length'=> 'Nama jabatan tidak boleh melebihi 150 karakter.',
            'is_unique' => 'Nama jabatan ini sudah wujud dalam pangkalan data.'
        ],
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}