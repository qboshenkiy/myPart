<?php

namespace App\Controllers;

use App\Models\ProfileModel;
use App\Models\UserModel;    // App instead of CodeIgniter
use CodeIgniter\Controller;

class SignUpController extends Controller
{
    protected $model;
    protected $profile;

    public function __construct()
    {
        $this->model = new UserModel();
        $this->profile = new ProfileModel();
    }

    public function register(): string
    {

        return view('Signup/register');
    }
    public function login(): string
    {
        return view('Signup/login');
    }
    public function signIn()
    {
        $user = $this->request->getPost('name');
        $login = $this->model->where('name', $user)->first();

        if ($login === null) {
            return redirect()->back()->withInput()->with('errors', ['Пользователь не найден'])->with('warning', 'Invalid data')->withInput();
        } else {
            $password = $this->request->getPost('password');
            if (password_verify($password, $login->password_hash)) {
                $session = session();
                $session->set('user_id', $login->id);
                $session->set('user_name', $login->name);
                $session->set('id', $login->id);
                return redirect()->to('/home')->with('success', ['Вы успешно авторизовались']);
            } else {
                return redirect()->back()->withInput()->with('errors', ['Неверный пароль'])->with('warning', 'Invalid data')->withInput();
            }
        }
    }
    public function logout()
    {
        $session = session();

        $session->destroy();
        return redirect()->to('signup/login');
    }

    public function create_account()
    {
        $user = $this->request->getPost();
        $avatar = $user['avatar'];  

        if ($user) {
            if ($this->model->insert($user)) {
                $user_id = $this->request->getPost('name');
                $login = $this->model->where('name', $user_id)->first();
                $session = session();
                $session->set('user_id', $login->id);
                $session->set('user_name', $login->name);
                if (session()->has('user_id') && $this->profile->upsert(['avatar' => $avatar, 'user_id' => session()->get('user_id')])) {
                    $session->set('id', $login->id);
                    return redirect()->to('/home')->with('success', ['Вы успешно авторизовались']);
                }
            } else {
                return redirect()->back()->with('errors', $this->model->errors())->with('warning', 'Invalid data')->withInput();
            }
        }
    }
}
