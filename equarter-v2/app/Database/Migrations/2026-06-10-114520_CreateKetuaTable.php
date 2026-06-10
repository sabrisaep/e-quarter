<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKetuaTable extends Migration
{
    public function up(): void
    {
        // Mendefinisikan kolum untuk jadual 'ketua'
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'jabatan_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'null'           => false,
            ],
            'nama_penuh' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'unique'     => true, // Memastikan tiada emel bertindih
                'null'       => false,
            ],
            'no_kp' => [
                'type'       => 'VARCHAR',
                'constraint' => 12, // 20 aksara sebagai langkah selamat walaupun MyKad mempunyai 12 digit
                'unique'     => true, // Memastikan tiada No KP bertindih
                'null'       => false,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255, // Panjang 255 disyorkan untuk menyimpan kata laluan yang di-hash (seperti BCRYPT)
                'null'       => false,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['aktif', 'sekat'], // Boleh diubah mengikut keperluan sistem
                'default'    => 'aktif',
                'null'       => false,
            ],
            'last_login' => [
                'type'       => 'DATETIME',
                'null'       => true, // Nullable kerana pengguna yang baru daftar mungkin belum log masuk
            ],
            'created_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'updated_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
        ]);

        // Menetapkan 'id' sebagai Primary Key
        $this->forge->addKey('id', true);

        // (Pilihan) Menetapkan 'jabatan_id' sebagai Foreign Key.
        // *Nota: Pastikan jadual 'jabatan' sudah wujud sebelum migration ini dijalankan.
        $this->forge->addForeignKey('jabatan_id', 'jabatan', 'id', 'CASCADE', 'CASCADE');

        // Mencipta jadual 'ketua'
        $this->forge->createTable('ketua');
    }

    public function down(): void
    {
        // Memadam jadual 'ketua' jika fungsi rollback (php spark migrate:rollback) dijalankan
        $this->forge->dropTable('ketua');
    }
}
