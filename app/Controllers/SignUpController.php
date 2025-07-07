<?php

namespace App\Controllers;

class SignUpController extends BaseController
{
    public function register(): string
    {
        return view('Signup/register');
    }
}
