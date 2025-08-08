<?php

namespace App\Models;

use CodeIgniter\Model;


class NoteModel extends Model
{
    protected $table ='note';
    protected $allowedFields = ['id', 'title', 'description', 'task', 'action', 'date'];
}