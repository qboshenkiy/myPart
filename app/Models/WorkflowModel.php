<?php

namespace App\Models;

use CodeIgniter\Model;


class WorkflowModel extends Model
{
    protected $table ='workflow';
    protected $allowedFields = ['id', 'name', 'description', 'flow_json'];
}