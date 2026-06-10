<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJabatanTable extends Migration
{
    public function up(): void
    {
        // Mendefinisikan kolum untuk jadual 'jabatan'
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_jabatan' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => false,
            ],
        ]);

        // Menetapkan 'id' sebagai Primary Key
        $this->forge->addKey('id', true);

        // Mencipta jadual 'jabatan'
        $this->forge->createTable('jabatan');
    }

    public function down(): void
    {
        // Memadam jadual 'jabatan' jika fungsi rollback dijalankan
        $this->forge->dropTable('jabatan');
    }
}