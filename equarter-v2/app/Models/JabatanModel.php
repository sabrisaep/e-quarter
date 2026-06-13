<?php

namespace App\Models;

use CodeIgniter\Model;

class JabatanModel extends Model
{
    protected $table            = 'jabatan'; // Assume table name is 'jabatan'
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama_jabatan']; // Only 'nama_jabatan' can be mass-assigned

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'id' => 'permit_empty',
        'nama_jabatan' => 'required|is_unique[jabatan.nama_jabatan,id,{id}]|min_length[3]|max_length[255]',
    ];
    protected $validationMessages = [
        'nama_jabatan' => [
            'required'   => 'Nama Jabatan diperlukan.',
            'is_unique'  => 'Nama Jabatan ini sudah wujud.',
            'min_length' => 'Nama Jabatan terlalu pendek.',
            'max_length' => 'Nama Jabatan terlalu panjang.',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
