<?php

namespace App\Controllers;

// App instead of CodeIgniter

use App\Models\ProfileModel as ModelsProfileModel;
use CodeIgniter\Controller;

class UserController extends Controller
{
    protected $helpers = ['form'];

    public function update_image()
    {
        $profile = new ModelsProfileModel();

        $data = ['errors' => 'The file has already been moved.'];

        return view('user/profile_edit', $data);
    }
    public function update()
    {
        $profile = new ModelsProfileModel();
        $user = $profile->find(session('user_id'));
        $data = $this->request->getPost();
        $img = $this->request->getFile('avatar');

        if ($img) {
            $img_name = $this->request->getFile('avatar')->getName();
            if ($profile->update(session('user_id'), ['avatar' => $img_name])) {
                $user = $profile->find(session('user_id'));
                $img->move('image/avatars');

                return view('user/profile_edit', $user);
            }
        }
        if ($profile->update(session('user_id'), $data)) {
            return redirect()->to('user/profile_edit')->with('errors', ['Ошибка обновления']);
        } else {

            return view('user/profile', [
                'firstname' => $user['firstname'],
                'lastname' => $user['lastname'],
                'email' => $user['email'],
                'phone' => $user['phone'],
                'description' => $user['description'],
                'date_birth' => $user['date_birth'],
                'avatar' => $user['avatar']
            ]);
        }
    }
    public function profile_edit()
    {
        $profile = new ModelsProfileModel();
        $data = $profile->where('user_id', session('user_id'))->first();


        return view('user/profile_edit', [
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'description' => $data['description'],
            'date_birth' => $data['date_birth'],
            'avatar' => $data['avatar']
        ]);
    }
    public function profile()
    {
        $profile = new ModelsProfileModel();
        $model = $profile->find(session('user_id'));

        if (!$model) {
            return "Пользователь не найден";
        }


        return view('user/profile', [
            'firstname' => $model['firstname'],
            'lastname' => $model['lastname'],
            'email' => $model['email'],
            'phone' => $model['phone'],
            'description' => $model['description'],
            'date_birth' => $model['date_birth'],
            'avatar' => $model['avatar']
        ]);
    }
}
