<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TicketManagements extends Migration
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
            'quota_per_day' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['to_all_date', 'no','apply'],
                'default' => 'no',
            ],
            'the_day' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('ticketmanagements');
    }

    public function down()
    {
        $this->forge->dropTable('ticketmanagements');
    }
}
