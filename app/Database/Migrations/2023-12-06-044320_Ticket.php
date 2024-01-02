<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
// 2023-12-06-044144_
// id
// nama ticket
// harga ticket
// diskon
// description
// qty
// publish


class Ticket extends Migration
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
            'image' => [
                'type' => 'text',
                'default' => 'default.jpg'
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'description' => [
                'type' => 'text',
            ],
            'access' => [
                'type' => 'text',
            ],
            'totalqrcode' => [
                'type' => 'INT',
                'default' => 1,
                'unsigned'  => true,
            ],
            'discount' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
            ],
            'price' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
            ],
            'qty' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
            ],
            'publish' => [
                'type' => 'enum',
                'constraint' => ["publish", "no"]
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tickets');
    }

    public function down()
    {
        //
        $this->forge->dropTable('tickets');
    }
}
