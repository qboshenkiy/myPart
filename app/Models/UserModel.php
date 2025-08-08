<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\User;

class UserModel extends Model
{
    protected $table = 'user';

    protected $allowedFields = ['name', 'password'];
    protected $returnType = User::class;

    protected $beforeInsert = ['hashPassword'];

    protected $validationRules = [
        'name' => 'required|is_unique[user.name]',
        'password' => 'required|min_length[5]'
    ];

    protected $validationMessages = [
        'name' => [
            'required'=> 'Поле username является обязательным',
            'is_unique' => 'Данный логин уже занят попробуйте другой'
        ],
        'password' => [
            'required' => 'Поле password является обязательным',
            'min_length' => 'Длина пароля должна быть более 5 смиволов'
            ]
    ];
    protected function hashPassword($data){
        if(isset($data['data']['password'])){
            $data['data']['password_hash'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
            unset($data['data']['password']);
        }
        return $data;
    }
}
