<?php

namespace App\Libraries;

use App\Models\ContextModel;

class Flow
{
    protected $model;
    protected $flow;
    protected $data;
    protected $db;

    public function __construct()
    {
        $this->data = [];
        $this->db      = \Config\Database::connect();
        $this->model = new ContextModel();
    }
    function parse_Json($json)
    {
        function length($node, &$table)
        {
            $len = sizeof($table[$node['name']]) - 1;

            return $len;
        }

        function vardump($var)
        {
            echo '<pre>';
            print_r($var);
            echo '</pre>';
        }

        $html = '<div class="parser">';
        $default = [
            'process' => [
                'id' => [],
                'name' => [],
                'data' => [
                    "fields" => []
                ],
                'title' => [],
                'connection' => [
                    'inputs' => [],
                    'outputs' => [],
                ]
            ],
            'condition' => [
                'id' => [],
                'name' => [],
                'data' => [
                    "conditions" => []
                ],
                'title' => [],
                'connection' => [
                    'inputs' => [],
                    'outputs' => [],
                ]

            ],
            'start' => [

                'id' => [],
                'name' => [],
                'data' => [
                    "fields" => []
                ],
                'title' => [],
                'connection' => [
                    'outputs' => []
                ]


            ],
        ];
        $table = [
            'process' => [
                // [
                //     'id' => [],
                //     'name' => [],
                //     'data' => [
                //         "fields" => []
                //     ],
                //     'title' => [],
                //     'connection' => [
                //         'inputs' => [],
                //         'outputs' => [],
                //     ]

                // ]   
            ],
            'start' => [

                // 'id' => [],
                // 'name' => [],
                // 'data' => [
                //     "fields" => []
                // ],
                // 'title' => [],
                // 'connection' => [
                //     'outputs' => []
                // ]


            ],
            'condition' => [
                // 'id' => [],
                // 'name' => [],
                // 'data' => [
                //     "conditions" => []
                // ],
                // 'title' => [],
                // 'connection' => [
                //     'inputs' => [],
                //     'outputs' => [],
                // ]

            ]
        ];


        function get_connection($node, &$table, $value, &$id)
        {
            if (isset($node['inputs']['input_1']['connections']) && $value === 'input') {
                foreach ($node['inputs']['input_1']['connections'] as $inputs) {
                    if (array_push($table[$node['name']][$id]['connection']['inputs'], ['node_id' => $inputs['node']]));
                }
            }
            if (isset($node['outputs']['output_1']['connections']) && $value === 'output') {
                foreach ($node['outputs']['output_1']['connections'] as $outputs) {
                    if (array_push($table[$node['name']][$id]['connection']['outputs'], ['node_id' => $outputs['node']]));
                }
            }
            return $table;
        }
        function parse_in_objects($json, &$table, &$default)
        {
            $id = [
                'condition' => 0,
                'start' => 0,
                'process' => 0,
            ];

            if (isset($json['drawflow']['Home']['data'])) {
                foreach ($json['drawflow']['Home']['data'] as $node) {
                    if ($node['name'] === 'condition' && $default['condition'] && isset($node['data']['conditions'])) {
                        if (!isset($table['condition'][$id[$node['name']]]['id'])) {
                            array_push($table[$node['name']], $default[$node['name']]);
                            if (array_push($table['condition'][$id[$node['name']]]['title'], $node['data']['title']));
                            if (array_push($table['condition'][$id[$node['name']]]['id'], $node['id']));
                            get_connection($node, $table, 'input', $id[$node['name']]);
                            get_connection($node, $table, 'output', $id[$node['name']]);
                            foreach ($node['data']['conditions'] as $item) {
                                if (array_push($table['condition'][$id[$node['name']]]['data']['conditions'], ['field' => $item['field'], 'value' => $item['value'], 'type' => $item['type']]));
                            }
                            if ($node['name'] === 'condition' && isset($table['condition'][$id[$node['name']]]['id'])) {
                                $id[$node['name']]++;
                            }
                        } else {
                            if (array_push($table['condition'][$id[$node['name']]]['title'], $node['data']['title']));
                            if (array_push($table['condition'][$id[$node['name']]]['id'], $node['id']));
                            get_connection($node, $table, 'input',  $id[$node['name']]);
                            get_connection($node, $table, 'output', $id[$node['name']]);
                            foreach ($node['data']['conditions'] as $item) {
                                if (array_push($table['condition'][$id[$node['name']]]['data']['conditions'], ['field' => $item['field'], 'value' => $item['value'], 'type' => $item['type']]));
                            }
                            if ($node['name'] === 'condition') {
                                $id[$node['name']]++;
                            }
                        }
                    }

                    if ($node['name'] === 'process' && $default['process'] && isset($node['data']['fields'])) {
                        if (!isset($table['process'][$id[$node['name']]]['id'])) {
                            array_push($table[$node['name']], $default[$node['name']]);
                            if (array_push($table['process'][$id[$node['name']]]['title'], $node['data']['title']));
                            if (array_push($table['process'][$id[$node['name']]]['id'], $node['id']));
                            get_connection($node, $table, 'input', $id[$node['name']]);
                            get_connection($node, $table, 'output', $id[$node['name']]);
                            foreach ($node['data']['fields'] as $item) {
                                if (array_push($table['process'][$id[$node['name']]]['data']['fields'], ['label' => $item['label'], 'value' => $item['value'], 'type' => $item['type']]));
                            }
                            if ($node['name'] === 'process' && isset($table['process'][$id[$node['name']]]['id'])) {
                                $id[$node['name']]++;
                            }
                        } else {
                            if (array_push($table['process'][$id[$node['name']]]['title'], $node['data']['title']));
                            if (array_push($table['process'][$id[$node['name']]]['id'], $node['id']));
                            get_connection($node, $table, 'input', $id[$node['name']]);
                            get_connection($node, $table, 'output', $id[$node['name']]);
                            foreach ($node['data']['fields'] as $item) {
                                if (array_push($table['process'][$id[$node['name']]]['data']['fields'], ['label' => $item['label'], 'value' => $item['value'], 'type' => $item['type']]));
                            }
                            if ($node['name'] === 'process') {
                                $id[$node['name']]++;
                            }
                        }
                    }
                    if ($node['name'] === 'start' && isset($node['data']['fields'])) {
                        if (!isset($table['start'][$id[$node['name']]]['id'])) {
                            array_push($table[$node['name']], $default[$node['name']]);
                            if (array_push($table['start'][$id[$node['name']]]['title'], $node['data']['title']));
                            if (array_push($table['start'][$id[$node['name']]]['id'], $node['id']));
                            // get_connection($node, $table, 'input', $id[$node['name']]);
                            get_connection($node, $table, 'output', $id[$node['name']]);
                            foreach ($node['data']['fields'] as $item) {
                                if (array_push($table['start'][$id[$node['name']]]['data']['fields'], ['label' => $item['label'], 'value' => $item['value'], 'type' => $item['type']]));
                            }
                            if ($node['name'] === 'start' && isset($table['start'][$id[$node['name']]]['id'])) {
                                $id[$node['name']]++;
                            }
                        } else {
                            if (array_push($table['start'][$id[$node['name']]]['title'], $node['data']['title']));
                            if (array_push($table['start'][$id[$node['name']]]['id'], $node['id']));
                            // get_connection($node, $table, 'input', $id[$node['name']]);
                            get_connection($node, $table, 'output', $id[$node['name']]);
                            foreach ($node['data']['fields'] as $item) {
                                if (array_push($table['start'][$id[$node['name']]]['data']['fields'], ['label' => $item['label'], 'value' => $item['value'], 'type' => $item['type']]));
                            }
                            if ($node['name'] === 'start') {
                                $id[$node['name']]++;
                            }
                        }
                        //     if (array_push($table['process']['title'], $node['data']['title']));
                        //     get_connection($node, $table, 'output');

                        //     foreach ($node['data']['fields'] as $item) {
                        //         if (array_push($table['process']['data']['fields'], ['label' => $item['label'], 'value' => $item['value'], 'type' => $item['type']]));
                        //         if (array_push($table['process']['id'], $node['id']));
                        //     }
                    }
                }
            }
            // dd($table);
            return $table;
        }


        //     <table>
        //     <thead>
        //         <tr>
        //             <th scope="col" rowspan="2"></th>
        //             <th scope="col" rowspan="2">ID</th>
        //             <th scope="col" rowspan="2">Title</th>
        //             <th scope="col" colspan="3">Fields</th>
        //             <th scope="col" rowspan="2">Connections</th>
        //         </tr>
        //         <tr>
        //             <th scope="row">label</th>
        //             <th scope="row">type</th>
        //             <th scope="row">value</th>
        //         </tr>
        //     </thead>
        //     <tbody>
        //         <tr>
        //             <th scope="row">Start</th>
        //             <td>1</td>
        //             <td>Get Start</td>
        //             <td>Title</td>
        //             <td>string</td>
        //             <td>hello</td>
        //             <td>1,2,3,4</td>
        //         </tr>
        //     </tbody>
        // </table>

        function log_json($json, &$table,  &$default)
        {
            $len = 1;
            $row = 0;
            $table = parse_in_objects($json, $table, $default);
            foreach ($table as $key => $value) {
                foreach ($value as $jkey => $jvalue) {
                    # code...
                    if (isset($jvalue['connection']['inputs'])) {
                        $len = sizeof($jvalue['connection']['inputs']);
                        if ($row < $len) {
                            $row = $len;
                        }
                    }
                }
            }
            $repeat = $row;
            $row = $row > 3 ? 3 : $row;

            $html = '<table>';
            $html .= sprintf('
            <thead>
                <tr>
                    <th scope="col" rowspan="2"></th>
                    <th scope="col" rowspan="2">ID</th>
                    <th scope="col" rowspan="2">Title</th>
                    <th scope="col" colspan="3">Fields</th>
                        <th scope="col" rowspan="2" colspan="%s">Connection
                        ', $row) . '
                <tr>
                    <th scope="row">label</th>
                    <th scope="row">type</th>
                    <th scope="row">value</th>
                </tr>
            </thead>
            <tbody>
            ';
            // dd($html);



            // vardump($item['data']['fields']);
            // foreach ($value as $Jkey => $Jvalue) {
            // }
            foreach ($table['start'] as $key => $value) {
                $len = sizeof($value['data']['fields']);
                if ($len != 0) {
                    $html .= sprintf('
                        <tr>
                        <th scope="row" rowspan="%s">
                        ', $len);
                } else {
                    $html .= '
                        <tr>
                        <th scope="row">
                        ';
                }
                $html .= 'Start';
                $html .= '</th>';
                $html .= '<td>';
                $html .= $value['id'][0];
                $html .= '</td>';
                $html .= '<td>';
                $html .= $value['title'][0];
                $html .= '</td>';
                $count = 0;
                foreach ($value['data']['fields'] as $index => $field) {
                    $html .= '<td>';
                    $html .= $field['label'];
                    $html .= '</td>';
                    $html .= '<td>';
                    $html .= $field['type'];
                    $html .= '</td>';
                    $html .= '<td>';
                    $html .= substr($field['value'], 0, 20) . '...';
                    $html .= '</td>';
                    $html .= '</tr>';
                    $html .= '<tr>';
                    if ($count < $len - 1) {
                        $html .= '<td></td>';
                        $html .= '<td></td>';
                        $count += 1;
                    }
                }
                $html .= '<tr>';
                $html .= '</tr>';
                # code...
            }
            foreach ($table['process'] as $key => $value) {
                // dd($value['data']);
                // vardump($value['data']['fields']);

                $len = sizeof($value['data']['fields']);
                if ($len != 0) {
                    $html .= sprintf('
                        <tr>
                        <th scope="row" rowspan="%s">
                        ', $len);
                } else {
                    $html .= '
                        <tr>
                        <th scope="row">
                        ';
                }
                $html .= 'Process';
                $html .= '</th>';
                $html .= '<td>';
                $html .= $value['id'][0];
                $html .= '</td>';
                $html .= '<td>';
                $html .= $value['title'][0];
                $html .= '</td>';
                $count = 0;
                foreach ($value['data']['fields'] as $index => $field) {
                    $html .= '<td>';
                    $html .= $field['label'];
                    $html .= '</td>';
                    $html .= '<td>';
                    $html .= $field['type'];
                    $html .= '</td>';
                    $html .= '<td>';
                    $html .= substr($field['value'], 0, 100) . "...";
                    $html .= '</td>';
                    if (isset($value['connection']['inputs'])) {
                        foreach ($value['connection']['inputs'] as $node) {
                            $repeat--;
                            $html .= "<td> Node(connection) ID:";
                            $html .= $node['node_id'];
                            $html .= "</td>";
                            if ($repeat === 5) {
                                break;
                            }
                        }
                    }
                    $html .= '</tr>';
                    $html .= '<tr>';
                    if ($count < $len - 1) {
                        $html .= '<td></td>';
                        $html .= '<td></td>';
                        $count += 1;
                    }
                }
                $html .= '<tr>';
                $html .= '</tr>';

                // $html .= '<td>';
                // $html .= $value['data']['fields'][0];
                // $html .= '</td>';
                // $html .= '<td>';
                // $html .= $value['data']['fields'][0];
                // $html .= '</td>';
                // $html .= '</tr>';
                # code...
            }
            foreach ($table['condition'] as $key => $value) {
                if (sizeof($value['data']['conditions']) > $repeat) {
                    $len = sizeof($value['data']['conditions']);
                } else {
                    $len = $repeat;
                }
                if ($len > 0) {

                    $html .= sprintf('
                    <tr>
                    <th scope="row" rowspan="%s">
                    ', $len);
                } else {
                    $html .= '
                        <tr>
                        <th scope="row">
                        ';
                }
                $html .= 'Conditions';
                $html .= '</th>';
                $html .= '<td>';
                $html .= $value['id'][0];
                $html .= '</td>';
                $html .= '<td>';
                $html .= $value['title'][0];
                $html .= '</td>';
                $count = 0;
                foreach ($value['data']['conditions'] as $index => $field) {
                    $html .= '<td>';
                    $html .= $field['field'];
                    $html .= '</td>';
                    $html .= '<td>';
                    $html .= $field['value'];
                    $html .= '</td>';
                    $html .= '<td>';
                    $html .= $field['type'];
                    $html .= '</td>';
                    if (isset($value['connection']['inputs'])) {
                        $count = 1;
                        foreach ($value['connection']['inputs'] as $node) {
                            $html .= "<td> Node(connection) ID:";
                            $html .= $node['node_id'];
                            $html .= "</td>";
                            if ($count === 3 && $node['node_id']) {
                                // dd(end($node));
                                $html .= '</tr>';
                            }
                            $count++;
                            if ($count > 3) {
                                if ($value['connection']['inputs'] != end($node)) {
                                    $html .= '<tr><td></td><td></td><td></td><td></td><td></td>';
                                }
                                $count = 1;
                            }
                        }
                        $html .= '</tr>';
                    }
                    $html .= '<tr>';

                    if ($count < $len - 1) {
                        $html .= '<td></td>';
                        $html .= '<td></td>';
                        $count += 1;
                    }

                    continue;
                }

                $html .= '<tr>';
                $html .= '</tr>';
                # code...
            }
            // foreach ($value as $Jkey => $Jvalue) {
            //     // dd($Jvalue);
            //     foreach ($Jvalue as $Nkey => $Nvalue) {
            //         dd($Nkey);
            //     }
            //     // foreach ($Jvalue as $Nkey => $Nvalue) {
            //     //     dd($Nkey);
            //     // }
            //     // $html .= '<td>';
            //     // $html .= $key;
            //     // $html .= '</td>';
            // }

            $html .= '</tbody>';
            $html .= '</table>';

            return $html;
        }

        $html = log_json($json, $table, $default);

        function get_context($json) {}
        return $this->data = [
            'html' => $html,
        ];
    }
}
