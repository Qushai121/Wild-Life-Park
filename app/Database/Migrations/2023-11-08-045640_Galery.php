<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Galery extends Migration
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
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'images' => [
                'type' => 'text',
                'default' => 'default.jpg'
            ],
            'description' => [
                'type' => 'text'
            ],
            'type' => [
                'type' => 'ENUM',
                'constraint' => ['human', 'animal']
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('galerys');
    }

    public function down()
    {
        $this->forge->dropTable('galerys');
    }
}
