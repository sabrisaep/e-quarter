<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKeraniTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_penuh' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'no_kp' => [
                'type'       => 'VARCHAR',
                'constraint' => 12,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['aktif', 'sekat'],
                'default'    => 'aktif',
            ],
            'last_login' => [
                'type'       => 'DATETIME',
                'null'       => true,
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

        // Tetapkan Primary Key
        $this->forge->addKey('id', true);

        // Tetapkan Unique Key untuk Email dan No KP
        $this->forge->addUniqueKey('email');
        $this->forge->addUniqueKey('no_kp');

        // Bina jadual
        $this->forge->createTable('kerani');
    }

    public function down(): void
    {
        $this->forge->dropTable('kerani');
    }
}
