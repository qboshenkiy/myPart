<?php

namespace App\Controllers;

use App\Models\ProfileModel;
use App\Libraries\Flow;


class DrawflowController extends BaseController
{
    public function index(): string
    {
        $data = new ProfileModel();
        $data = $data->where('user_id', session('user_id'))->first();
        return view('drawflow/index', ['avatar' => $data['avatar']]);
    }
    public function parser(): string
    {
        $parser = new Flow();

        // $json = json_decode(file_get_contents(base_url('drawflow/example.json')), true);
        $json = json_decode(file_get_contents(base_url('drawflow/workflow_db.json')), true);
        // $table = $parser->parse_Json($json);

        // dd($json['drawflow']['Home']['data']);
        // $table = $parser->table;
        $parse_json = $parser->parse_Json($json); 

        $data = new ProfileModel();
        $data = $data->where('user_id', session('user_id'))->first();
        return view('drawflow/Parsers', [ 'html' => $parse_json['html'], 'avatar' => $data['avatar']]);
    }
    public function test()
    {
        $data = new ProfileModel();
        $data = $data->where('user_id', session('user_id'))->first();
        return view('drawflow/test', ['avatar' => $data['avatar']]);
    }
}
