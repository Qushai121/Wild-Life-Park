<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TicketQrCode extends Migration
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
            'transaction_id' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
            ],
            'status' => [
                'type' => 'enum',
                'constraint' => ["unused", "used", "expired"]
            ],
            'qrcode' => [
                'type' => 'text'
            ],
            'qrcode_token' => [
                'type' => 'text'
            ],
            'expired_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('transaction_id', 'transactions', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('ticketqrcodes');
    }

    public function down()
    {
        $this->forge->dropTable('ticketqrcodes');
        //
    }
}
