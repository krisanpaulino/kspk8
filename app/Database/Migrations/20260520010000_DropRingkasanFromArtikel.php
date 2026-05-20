<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DropRingkasanFromArtikel extends Migration
{
    public function up()
    {
        if ($this->db->fieldExists('ringkasan', 'artikel')) {
            $this->forge->dropColumn('artikel', ['ringkasan']);
        }
    }

    public function down()
    {
        if (! $this->db->fieldExists('ringkasan', 'artikel')) {
            $this->forge->addColumn('artikel', [
                'ringkasan' => ['type' => 'TEXT', 'null' => true],
            ]);
        }
    }
}
