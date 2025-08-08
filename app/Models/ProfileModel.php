<?php

namespace App\Models;

use CodeIgniter\Model;


class ProfileModel extends Model
{
    protected $table ='profile';
    protected $allowedFields = ['id', 'firstname', 'lastname', 'email', 'phone', 'description', 'date_birth', 'avatar'];
}