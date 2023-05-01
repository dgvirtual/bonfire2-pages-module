<?php

namespace App\Modules\Pages\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePagesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'int',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type'       => 'varchar',
                'constraint' => 255,
            ],
            'content' => [
                'type' => 'text',
                'null' => true,
            ],
            'excerpt' => [
                'type'       => 'varchar',
                'constraint' => 255,
            ],
            'slug' => [
                'type'       => 'varchar',
                'constraint' => 255,
            ],
            'category' => [
                'type'       => 'varchar',
                'constraint' => 20,
            ],
            'created_at' => [
                'type' => 'datetime',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'datetime',
                'null' => false,
            ],
            'deleted_at' => [
                'type' => 'datetime',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('pages', true);
    }

    public function down()
    {
        $this->forge->dropTable('pages', true);
    }
}
