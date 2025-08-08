<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProfileTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true,

            ],
            'firstname' => [
                'type' => 'VARCHAR',
                'constraint' => '128',
                'null' => true,
            ],
            'lastname' => [
                'type' => 'VARCHAR',
                'constraint' => '128',
                'null' => true,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '128',
                'null' => true,

            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => '128',
                'null' => true,

            ],
            'description' => [
                'type' => 'TEXT',
                'constraint' => '128',
                'null' => true,

            ],
            'date_birth' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'avatar' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 128,
                'unsigned' => true,
                'null' => true,
            ],
        ]);

        $this->forge->addForeignKey('user_id', 'user', 'id', 'CASCADE', 'SET NULL');
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('profile');
    }

    public function down()
    {
        $this->forge->dropTable('profile');
    }
}
