<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Absent extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'employee_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'shift' => [
                'type' => 'enum',
                'constraint' => ['morning', 'night']
            ],
            'status' => [
                'type' => 'enum',
                'constraint' => ['Present', 'Absent', 'Late','To Fast']
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('employee_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('absents');
    }

    public function down()
    {
        $this->forge->dropTable('absents');
        //
    }
}
