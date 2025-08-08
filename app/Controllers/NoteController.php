<?php

namespace App\Controllers;

use App\Models\NoteModel;
use App\Models\ProfileModel;

class NoteController extends BaseController
{
    protected $model;
    public function __construct()
    {
        $this->model = new NoteModel();
    }

    public function note(): string
    {
        $profile = new ProfileModel();
        $data = $profile->where('user_id', session('user_id'))->first();

        $note = $this->model->where('user_id', session('user_id'))->findAll();

        if ($data || $note) {
            return view('note/note', ['avatar' => $data['avatar'], 'note' => $note]);
        } else {
            return view('note/note', ['avatar' => 'avatar.png']);
        }
    }

    public function note_add()
    {
        $data = $this->request->getPost();

        if ($data && $this->model->upsert($data)) {
            return redirect()->to('note/note');
        }
    }


    public function alerts()
    {
        return view('alerts/success');
    }
}
