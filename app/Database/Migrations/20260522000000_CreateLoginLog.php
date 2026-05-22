<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLoginLog extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'BIGINT', 'constraint' => 20, 'unsigned' => true, 'auto_increment' => true],
            'user_id' => ['type' => 'INT', 'constraint' => 11, 'null' => true],
            'user_email' => ['type' => 'VARCHAR', 'constraint' => 255],
            'user_type' => ['type' => 'VARCHAR', 'constraint' => 50],
            'ip_address' => ['type' => 'VARCHAR', 'constraint' => 45],
            'user_agent' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('user_id');
        $this->forge->addForeignKey('user_id', 'user', 'user_id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('login_log');
    }

    public function down()
    {
        $this->forge->dropTable('login_log', true);
    }
}
