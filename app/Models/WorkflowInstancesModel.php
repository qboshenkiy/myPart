<?php

namespace App\Models;

use CodeIgniter\Model;


class WorkflowInstancesModel extends Model
{
    protected $table ='workflow_instances';
    protected $allowedFields = ['id', 'workflow_id ', 'current_node_id', 'fields', 'status'];
}