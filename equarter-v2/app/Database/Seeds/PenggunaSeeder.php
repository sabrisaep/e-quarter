<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PenggunaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama_penuh' => 'Ali Bin Ahmad',
                'email'      => 'kerani@e-quarter.com',
                'no_kp'      => '950101145551',
                'password'   => password_hash('password123', PASSWORD_DEFAULT),
                'role'       => 'kerani',
                'status'     => 'aktif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_penuh' => 'Siti Binti Abu',
                'email'      => 'ketua@e-quarter.com',
                'no_kp'      => '850202145552',
                'password'   => password_hash('password123', PASSWORD_DEFAULT),
                'role'       => 'ketua',
                'status'     => 'aktif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_penuh' => 'Dato Johan Bin Harun',
                'email'      => 'pengurusan@e-quarter.com',
                'no_kp'      => '750303145553',
                'password'   => password_hash('password123', PASSWORD_DEFAULT),
                'role'       => 'pengurusan',
                'status'     => 'aktif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Masukkan data layang (batch) ke dalam jadual 'pengguna'
        $this->db->table('pengguna')->insertBatch($data);
    }
}