<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class NoteTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'constraint' => 11,
                'auto_increment' => true
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 128,
                'null' => false,
            ],
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => 128,
                'null' => true,
            ],
            'task' => [
                'type' => 'TEXT',
                'constraint' => 1024,
                'null' => true,
            ],
            'date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'action' => [
                'type' => 'VARCHAR',
                'constraint' => 28,
                'null' => false,
            ],
            'user_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'constraint' => 11,
                'null' => true,
            ]

        ]);
        $this->forge->addForeignKey('user_id', 'user', 'id', 'CASCADE', 'SET NULL');
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('note');
    }

    public function down()
    {
        $this->forge->dropTable('note');
    }
}
