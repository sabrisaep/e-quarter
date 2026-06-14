<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgramModel extends Model
{
    // Nama jadual di database
    protected $table            = 'program';

    // Primary key untuk jadual ini
    protected $primaryKey       = 'id';

    // Menandakan primary key menggunakan auto increment
    protected $useAutoIncrement = true;

    // Mengaktifkan soft deletes (ditetapkan ke false kerana tiada kolum deleted_at)
    protected $useSoftDeletes   = false;

    // Kolum yang dibenarkan untuk operasi INSERT dan UPDATE
    // Pastikan jabatan_id dimasukkan di sini kerana ia perlu disimpan
    protected $allowedFields    = [
        'jabatan_id',
        'nama_program',
    ];

    // Tetapan masa (ditetapkan ke false kerana jadual kita tiada created_at/updated_at)
    protected $useTimestamps = false;

    // Peraturan validasi sebelum simpan data
    protected $validationRules      = [
        'id'         => 'permit_empty',
        'jabatan_id'   => 'required|numeric|is_not_unique[jabatan.id]',
        'nama_program' => 'required|min_length[3]|max_length[255]|is_unique[program.nama_program,id,{id}]',
    ];

    protected $validationMessages   = [
        'jabatan_id' => [
            'required'      => 'Sila pilih jabatan.',
            'numeric'       => 'ID Jabatan mestilah dalam bentuk nombor.',
            'is_not_unique' => 'Jabatan yang dipilih tidak wujud dalam pangkalan data.'
        ],
        'nama_program' => [
            'required'   => 'Nama program wajib diisi.',
            'min_length' => 'Nama program mestilah sekurang-kurangnya {param} aksara.',
            'max_length' => 'Nama program tidak boleh melebihi {param} aksara.'
        ],
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    /**
     * Fungsi tambahan (Custom Method):
     * Memandangkan jadual 'program' ini berhubung dengan 'jabatan', fungsi ini
     * memudahkan anda untuk mengambil data program sekali gus dengan nama jabatannya (SQL JOIN).
     */
    public function getProgramWithJabatan()
    {
        return $this->select('program.*, jabatan.nama_jabatan')
            ->join('jabatan', 'jabatan.id = program.jabatan_id')
            ->findAll();
    }
}