<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProgramTable extends Migration
{
    public function up()
    {
        // Mendefinisikan kolum untuk jadual 'program'
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
            ],
            'nama_program' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
        ]);

        // Menetapkan 'id' sebagai Primary Key
        $this->forge->addKey('id', true);

        // Menetapkan 'jabatan_id' sebagai Foreign Key yang merujuk kepada 'id' di jadual 'jabatan'
        // CASCADE bermaksud jika data jabatan dipadam/dikemaskini, data program yang berkaitan akan terkesan sama
        $this->forge->addForeignKey('jabatan_id', 'jabatan', 'id', 'CASCADE', 'CASCADE');

        // Mencipta jadual 'program'
        $this->forge->createTable('program');
    }

    public function down()
    {
        // Memadam jadual 'program' jika fungsi rollback dijalankan
        $this->forge->dropTable('program');
    }
}