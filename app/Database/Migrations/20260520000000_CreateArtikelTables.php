<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateArtikelTables extends Migration
{
    public function up()
    {
        // artikel
        $this->forge->addField([
            'id' => ['type' => 'BIGINT', 'constraint' => 20, 'unsigned' => true, 'auto_increment' => true],
            'judul' => ['type' => 'VARCHAR', 'constraint' => 255],
            'slug' => ['type' => 'VARCHAR', 'constraint' => 255],
            'ringkasan' => ['type' => 'TEXT', 'null' => true],
            'isi' => ['type' => 'LONGTEXT'],
            'thumbnail' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'status' => ['type' => 'ENUM', 'constraint' => ['draft', 'published'], 'default' => 'draft'],
            'published_at' => ['type' => 'TIMESTAMP', 'null' => true],
            'views' => ['type' => 'BIGINT', 'constraint' => 20, 'unsigned' => true, 'default' => 0],
            'created_at' => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at' => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('slug', false, true);
        $this->forge->createTable('artikel');

        // tag_artikel
        $this->forge->addField([
            'id' => ['type' => 'BIGINT', 'constraint' => 20, 'unsigned' => true, 'auto_increment' => true],
            'nama' => ['type' => 'VARCHAR', 'constraint' => 100],
            'slug' => ['type' => 'VARCHAR', 'constraint' => 120],
            'created_at' => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at' => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('slug', false, true);
        $this->forge->createTable('tag_artikel');

        // pivot artikel_tag
        $this->forge->addField([
            'artikel_id' => ['type' => 'BIGINT', 'constraint' => 20, 'unsigned' => true],
            'tag_id' => ['type' => 'BIGINT', 'constraint' => 20, 'unsigned' => true],
        ]);
        $this->forge->addKey(['artikel_id', 'tag_id'], true);
        $this->forge->addForeignKey('artikel_id', 'artikel', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('tag_id', 'tag_artikel', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('artikel_tag');
    }

    public function down()
    {
        $this->forge->dropTable('artikel_tag', true);
        $this->forge->dropTable('tag_artikel', true);
        $this->forge->dropTable('artikel', true);
    }
}
