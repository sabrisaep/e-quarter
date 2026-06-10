<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMataPelajaranTable extends Migration
{
    public function up(): void
    {
        // Mendefinisikan kolum untuk jadual 'mata_pelajaran'
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'program_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'nama_mp' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
        ]);

        // Menetapkan 'id' sebagai Primary Key
        $this->forge->addKey('id', true);

        // Menetapkan 'program_id' sebagai Foreign Key yang merujuk kepada 'id' di jadual 'program'
        $this->forge->addForeignKey('program_id', 'program', 'id', 'CASCADE', 'CASCADE');

        // Mencipta jadual 'mata_pelajaran'
        $this->forge->createTable('mata_pelajaran');
    }

    public function down(): void
    {
        // Memadam jadual 'mata_pelajaran' jika fungsi rollback dijalankan
        $this->forge->dropTable('mata_pelajaran');
    }
}