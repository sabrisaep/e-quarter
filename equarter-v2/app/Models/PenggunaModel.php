<?php

namespace App\Models;

use CodeIgniter\Model;

class PenggunaModel extends Model
{
    protected $table            = 'pengguna';
    protected $primaryKey       = 'id';

    // Lajur yang dibenarkan untuk operasi Insert & Update
    protected $allowedFields    = [
        'nama_penuh',
        'email',
        'no_kp',
        'password',
        'role',
        'status',
        'last_login',
    ];

    // Konfigurasi Tarikh Automatik
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Pembidaan Validasi (Opsional tetapi digalakkan)
    protected $validationRules = [
        'id'         => 'permit_empty',
        'nama_penuh' => 'required|min_length[3]',
        'email'      => 'required|valid_email|is_unique[pengguna.email,id,{id}]',
        'no_kp'      => 'required|numeric|exact_length[12]|is_unique[pengguna.no_kp,id,{id}]',
        'password'   => 'permit_empty|min_length[6]',
        'role'       => 'required|in_list[kerani,pengurusan]',
        'status'     => 'required|in_list[aktif,sekat]',
    ];

    protected $validationMessages = [
        'email' => [
            'is_unique' => 'Alamat emel ini telah didaftarkan.',
            'required'   => 'Sila masukkan alamat emel.',
        ],
        'no_kp' => [
            'is_unique'    => 'Nombor Kad Pengenalan ini telah didaftarkan.',
            'exact_length' => 'Nombor Kad Pengenalan mestilah 12 digit tanpa tanda sempang (-).',
        ],
        'password' => [
            'min_length' => 'Kata laluan mestilah sekurang-kurangnya 6 aksara.',
        ],
    ];

    protected $skipValidation       = false;

    // Hash password secara automatik sebelum simpan
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data): array
    {
        if (empty($data['data']['password'])) {
            return $data;
        }

        $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        return $data;
    }
}
