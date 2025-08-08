<!DOCTYPE html>
<html lang="en">
<?= $this->extend('layouts/default') ?>
<?= $this->section('drawflow') ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="json.css">
    <style>
        table {
            border-collapse: collapse;
            border: 2px solid rgb(140 140 140);
            font-family: sans-serif;
            font-size: 0.8rem;
            letter-spacing: 1px;
        }

        caption {
            caption-side: bottom;
            padding: 10px;
            font-weight: bold;
        }

        thead,
        tfoot {
            background-color: rgb(228 240 245);
        }

        th,
        td {
            border: 1px solid rgb(160 160 160);
            padding: 8px 10px;
        }

        td:last-of-type {
            text-align: center;
        }

        tbody>tr:nth-of-type(even) {
            background-color: rgb(237 238 242);
        }

        tfoot th {
            text-align: right;
        }

        tfoot td {
            font-weight: bold;
        }
    </style>
</head>

<body>
<?= $html ?>
</body>

</html>
<?= $this->endSection() ?>