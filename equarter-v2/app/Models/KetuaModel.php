<?php

namespace App\Models;

use CodeIgniter\Model;

class KetuaModel extends Model
{
    // Nama jadual di dalam pangkalan data
    protected $table            = 'ketua';

    // Primary key untuk jadual ini
    protected $primaryKey       = 'id';

    // Menetapkan auto increment kepada true kerana 'id' menggunakan auto_increment
    protected $useAutoIncrement = true;

    // Mematikan soft deletes kerana tiada kolum deleted_at
    protected $useSoftDeletes   = false;

    // Kolum-kolum yang dibenarkan untuk operasi simpan/kemaskini (Mass Assignment)
    protected $allowedFields    = [
        'jabatan_id',
        'nama_penuh',
        'email',
        'no_kp',
        'password',
        'status',
        'last_login'
    ];

    // Ditetapkan ke false kerana jadual ini tiada kolum created_at & updated_at
    protected $useTimestamps = false;

    // --- PERATURAN VALIDASI ---
    // Sintaks {id} digunakan supaya sistem mengabaikan rekod sedia ada semasa operasi UPDATE (elak ralat is_unique)
    protected $validationRules = [
        'jabatan_id' => 'required|is_natural_no_zero',
        'nama_penuh' => 'required|min_length[3]|max_length[255]',
        'email'      => 'required|valid_email|is_unique[ketua.email,id,{id}]',
        'no_kp'      => 'required|numeric|min_length[12]|max_length[20]|is_unique[ketua.no_kp,id,{id}]',
        'password'   => 'required|min_length[6]',
        'status'     => 'required|in_list[aktif,tidak aktif]',
        'last_login' => 'permit_empty|valid_date[Y-m-d H:i:s]'
    ];

    protected $validationMessages = [
        'email' => [
            'required'    => 'Emel wajib diisi.',
            'valid_email' => 'Format emel tidak sah.',
            'is_unique'   => 'Emel ini telah pun digunakan dalam sistem.'
        ],
        'no_kp' => [
            'required'   => 'Nombor Kad Pengenalan wajib diisi.',
            'numeric'    => 'Nombor Kad Pengenalan mestilah mengandungi nombor sahaja.',
            'min_length' => 'Nombor Kad Pengenalan terlalu pendek.',
            'is_unique'  => 'Nombor Kad Pengenalan ini telah pun didaftarkan.'
        ],
        'password' => [
            'required'   => 'Kata laluan wajib diisi.',
            'min_length' => 'Kata laluan mestilah sekurang-kurangnya 6 aksara.'
        ],
        'status' => [
            'in_list' => 'Status mestilah sama ada "aktif" atau "tidak aktif".'
        ]
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // --- MODEL CALLBACKS ---
    // Mendaftarkan fungsi hashPassword untuk dijalankan secara automatik sebelum data dimasukkan atau dikemaskini
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    /**
     * Fungsi untuk menukar kata laluan teks biasa kepada format hash (BCRYPT) demi keselamatan.
     */
    protected function hashPassword(array $data): array
    {
        // Jika data password tidak dihantar atau kosong (contohnya semasa update tanpa tukar password), abaikan fungsi ini
        if (empty($data['data']['password'])) {
            return $data;
        }

        // Proses hash kata laluan
        $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);

        return $data;
    }
}