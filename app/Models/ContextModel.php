<?php

namespace App\Models;

use CodeIgniter\Model;


class ContextModel extends Model
{
    protected $table ='context';
    protected $allowedFields = ['id', 'type_flow', 'flow_id', 'title', 'label', 'type', 'value', 'table_id',];
}