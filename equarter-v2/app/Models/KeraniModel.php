<?php

namespace App\Models;

use CodeIgniter\Model;

class KeraniModel extends Model
{
    protected $table            = 'kerani';
    protected $primaryKey       = 'id';

    // Lajur yang dibenarkan untuk operasi Insert & Update
    protected $allowedFields    = [
        'nama_penuh',
        'email',
        'no_kp',
        'password',
        'status',
        'last_login'
    ];

    // Konfigurasi Tarikh Automatik
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Pembidaan Validasi (Opsional tetapi digalakkan)
    protected $validationRules      = [
        'nama_penuh' => 'required|min_length[3]',
        'email'      => 'required|valid_email|is_unique[kerani.email,id,{id}]',
        'no_kp'      => 'required|is_unique[kerani.no_kp,id,{id}]',
        'password'   => 'required|min_length[6]',
    ];

    protected $validationMessages   = [];
    protected $skipValidation       = false;
}
