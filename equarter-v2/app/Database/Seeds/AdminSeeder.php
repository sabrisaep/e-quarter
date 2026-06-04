<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // optional: kosongkan table dulu (untuk elak duplicate)
        $this->db->table('admin')->truncate();

        $data = [
                'username'   => 'admin',
                'password'   => password_hash('admin', PASSWORD_DEFAULT),
                'email'      => 'equarter@ruangprojek.com',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
        ];

        // insert banyak terus
        $this->db->table('admin')->insert($data);
    }
}