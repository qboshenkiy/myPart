<!DOCTYPE html>
<html lang="en">
<?php

function parse_Json($json)
{
    if (!isset($json['drawflow']['Home']['data'])) {
        return "<p style=\"color:red;\">Error: Invalid JSON structure.</p>";
    }
    $html = '<div>';
    $table = [
        'process' => [
            'title' => [],
            'label' => [],
            'type' => [],
            'value' => [],
        ],
        'start' => [
            'title' => [],
            'label' => [],
            'type' => [],
            'value' => [],
        ],
        'conditions' => [
            'title' => [],
            'field' => [],
            'type' => [],
            'value' => [],
        ],
        'end' => [
            ''
        ]
    ];

    function vardump($var)
    {
        echo '<pre>';
        print_r($var);
        echo '</pre>';
    }
    $id = 0;
    if (isset($json['drawflow']['Home']['data'])) {
        foreach ($json['drawflow']['Home']['data'] as $node) {
            if ($node['name'] === 'condition' && isset($node['data']['conditions'])) {
                array_push($table['conditions']['title'], [$node['data']['title']]);
                foreach ($node['data']['conditions'] as $item) {
                    array_push($table['conditions']['field'], [$item['field']]);
                    array_push($table['conditions']['type'], [$item['type']]);
                    if (isset($item['value'])) {
                        array_push($table['conditions']['value'], [$item['value']]);
                    }
                    $id++;
                }
            }
            if ($node['name'] === 'process' && isset($node['data']['fields'])) {
                foreach ($node['data']['fields'] as $item) {
                    array_push($table['process']['title'], [$node['data']['title']]);
                    if (isset($item['label'])) {
                        array_push($table['process']['label'], [$item['label']]);
                    }
                    if (isset($item['type'])) {
                        array_push($table['process']['type'], [$item['type']]);
                    }
                    if (isset($item['value'])) {
                        array_push($table['process']['value'], [$item['value']]);
                    }
                    if (isset($item['value'])) {
                        array_push($table['process']['value'], [$item['value']]);
                    }
                    $id++;
                }
            }
            if ($node['name'] === 'start' && isset($node['data']['fields'])) {
                foreach ($node['data']['fields'] as $item) {
                    array_push($table['start']['title'], [$node['data']['title']]);
                    if (isset($item['label']) || isset($item['type'])) {
                        array_push($table['start']['label'], [$item['label']]);
                        array_push($table['start']['type'], [$item['type']]);
                    }
                    if (isset($item['value'])) {
                        array_push($table['start']['value'], [$item['value']]);
                    }
                    if (isset($item['value'])) {
                        array_push($table['start']['value'], [$item['value']]);
                    }
                    $id++;
                }
            }
        }
    }
    // vardump($table);
    
    
    $html .= '<table class="var_dump">';
    foreach ($table['start']['title'] as $index => $title) {
        $html .= '<tr><th>Title</th><th>Field</th><th>Type</th><th>Value</th></tr>';
        $title = isset($table['start']['title'][$index]) ? htmlspecialchars($table['start']['title'][$index][0]) : '';
        $field = isset($table['start']['label'][$index]) ? htmlspecialchars($table['start']['label'][$index][0]) : '';
        $type = isset($table['start']['type'][$index]) ? htmlspecialchars($table['start']['type'][$index][0]) : '';
        $value = isset($table['start']['value'][$index]) ? htmlspecialchars($table['start']['value'][$index][0]) : '';
        $html .= "<tr>
        <td class=\"conn_td\">$title</td>
        <td class=\"conn_td\">$field</td>
        <td class=\"conn_td\">$type</td>
        <td class=\"conn_td\">$value</td>
        </tr>";
    }
    $html .= '</table>';
    $html .= '<table class="var_dump">';
    foreach ($table['process']['title'] as $index => $title) {
        $html .= '<tr><th>Title</th><th>Field</th><th>Type</th><th>Value</th></tr>';
        $title = isset($table['process']['title'][$index]) ? htmlspecialchars($table['process']['title'][$index][0]) : '';
        $field = isset($table['process']['label'][$index]) ? htmlspecialchars($table['process']['label'][$index][0]) : '';
        $type = isset($table['process']['type'][$index]) ? htmlspecialchars($table['process']['type'][$index][0]) : '';
        $value = isset($table['process']['value'][$index]) ? htmlspecialchars($table['process']['value'][$index][0]) : '';
        $html .= "<tr>
        <td class=\"conn_td\">$title</td>
        <td class=\"conn_td\">$field</td>
        <td class=\"conn_td\">$type</td>
        <td class=\"conn_td\">$value</td>
        </tr>";
    }
    $html .= '</table>';
    $html .= '<table class="var_dump">';
    foreach ($table['conditions']['title'] as $index => $title) {
        $html .= '<tr><th>Title</th><th>Field</th><th>Type</th><th>Value</th></tr>';
        $title = isset($table['conditions']['title'][$index]) ? htmlspecialchars($table['conditions']['title'][$index][0]) : '';
        $field = isset($table['conditions']['field'][$index]) ? htmlspecialchars($table['conditions']['field'][$index][0]) : '';
        $type = isset($table['conditions']['type'][$index]) ? htmlspecialchars($table['conditions']['type'][$index][0]) : '';
        $value = isset($table['conditions']['value'][$index]) ? htmlspecialchars($table['conditions']['value'][$index][0]) : '';
        $html .= "<tr>
        <td class=\"conn_td\">$title</td>
        <td class=\"conn_td\">$field</td>
        <td class=\"conn_td\">$type</td>
        <td class=\"conn_td\">$value</td>
        </tr>";
    }
    $html .= '</table>';
    
    echo $html;
    $html .= '</table>';
    $html .= '</div>';
    // foreach ($table['start'] as $start) {
        //     echo $start;
        // }
        // foreach ($table['conditions'] as $cond) {
            //     if (isset($cond['field'])) {
                //         $field = htmlspecialchars($cond['field']);
                //     } else {
                    //         $field = '';
                    //     }
                    //     if (isset($cond['type'])) {
    //         $type = htmlspecialchars($cond['type']);
    //     } else {
    //         $type = '';
    //     }
    //     if (isset($cond['value'])) {
    //         $value = htmlspecialchars($cond['value']);
    //     } else {
    //         $value = '';
    //     }
    //     $html .= "<tr>
    //         <td class=\"conn_td\">$field</td>
    //         <td class=\"conn_td\">$type</td>
    //         <td class=\"conn_td\">$value</td>
    //         </tr>";
    //     echo $field;
    // }
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="json.css">
    <style>
        table, th, td {
            width: 700px;
            border-collapse: collapse;
            border: solid 1px black;
            text-align: center;
        }
        div{
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
    </style>
</head>

<body>
    <?php
    $file = 'example.json';
    if (file_exists($file)) {
        $json = json_decode(file_get_contents($file), true);
        $html = parse_Json($json);
        echo $html;
    } else {
        echo "<p style=\"color:red;\">Error: File '$file' not found.</p>";
    }
    ?>
</body>

</html>