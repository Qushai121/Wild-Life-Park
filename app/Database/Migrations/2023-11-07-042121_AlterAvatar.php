<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterAvatar extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'avatar' => [
                'type' => 'text',
                'null' => true
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'avatar');
    }
}
