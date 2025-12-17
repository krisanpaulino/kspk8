<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SetAlumnniToNull extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('cerita', [
            'alumni_nim' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('cerita', [
            'alumni_nim' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
        ]);
    }
}
