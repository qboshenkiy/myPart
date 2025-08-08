<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ContextTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'auto_increment' => true,
                'unsigned' => true,
                'constraint' => 11,
                'type' => 'INT'
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 128,
                'null' => true
            ],
            'type' => [
                'type' => 'VARCHAR',
                'constraint' => 128,
                'null' => true
            ],
            'node_id' => [
                'constraint' => 11,
                'type' => 'INT'
            ],

        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('context');
    }

    public function down()
    {
        $this->forge->dropTable('context');
    }
}
