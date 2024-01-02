<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

// id
// ticket id
// ticket category

class TicketTicketCategory extends Migration
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
            'ticketCategory_id' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
            ],
            'ticket_id' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('ticketCategory_id', 'ticketCategorys', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('ticket_id', 'tickets', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('ticketTicketCategorys');
    }
    
    public function down()
    {
        $this->forge->dropTable('ticketTicketCategorys');
    }
}
