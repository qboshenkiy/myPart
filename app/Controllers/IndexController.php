<?php

namespace App\Controllers;

use App\Models\ProfileModel;

class IndexController extends BaseController
{
    public function index(): string
    {
        $profile = new ProfileModel();
        $data = $profile->where('user_id', session('user_id'))->first();

        if ($data) {
            return view('root/index', ['avatar' => $data['avatar']]);
        } else {
            return view('root/index', ['avatar' => 'null']);
        }
    }

    public function alerts()
    {
        return view('alerts/success');
    }
}
