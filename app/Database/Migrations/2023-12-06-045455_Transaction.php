<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

// 2023-12-06-044320_
// id
// user id
// transaction id
// ticket id 
// status  enum = unpaid,paid,used,unused,expired
// expired  tanggal expire keknya 1 minggu sesudah beli tiket
// created_at
// updated_at

class Transaction extends Migration
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
            'user_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'product_id' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
            ],
            'status' => [
                'type' => 'enum',
                'constraint' => ["pending", "settlement","cancel",'expire','failure']
            ],
            'order_id' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
            ],
            'snap_token' => [
                'type' => 'text'
            ],
            'price_then' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
            ],
            'discount_then' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
            ],
            'total_price_then' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
            ],
            'product_category' => [
                'type' => 'text'
            ],
            'quantity' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
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
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('transactions');
    }

    public function down()
    {
        //
        $this->forge->dropTable('transactions');
    }
}
