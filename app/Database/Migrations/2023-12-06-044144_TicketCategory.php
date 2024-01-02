<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

// 2023-12-06-045455_
// id
// category

class TicketCategory extends Migration
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
            'category' => [
                'type' => 'text'
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('ticketCategorys');
    }

    public function down()
    {

        $this->forge->dropTable('ticketCategorys');
    }
}
