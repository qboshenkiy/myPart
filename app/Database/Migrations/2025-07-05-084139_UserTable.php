<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;


class UserTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'  => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'  => 'VARCHAR',
                'constraint' => '128',
                'null' => false,
            ],
            'password_hash' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ]
            ]);

            $this->forge->addPrimaryKey('id')->addUniqueKey('name');
            $this->forge->createTable('user', true);
    }

    public function down()
    {
        $this->forge->dropTable('user');
    }
}
