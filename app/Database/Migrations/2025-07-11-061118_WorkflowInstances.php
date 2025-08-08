<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class WorkflowInstances extends Migration
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
            'workflow_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ],
            'current_node_id' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
                'null' => true
            ],
            'context_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['running', 'failed', 'completed'],
                'default' => 'running',
                'null' => true
            ]

        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('workflow_instances');
    }

    public function down()
    {
        $this->forge->dropTable('workflow_instances');
    }
}
