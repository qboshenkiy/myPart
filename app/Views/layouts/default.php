<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title', true) ?></title>
    
</head>
<style>
    .wrapper {
        width: 1100px;
        margin: 0 auto;
        z-index: 1;
        padding: 10px;
    }
    .title {
        font-size: xx-large;
        font-family: Arial, Helvetica, sans-serif;
        margin-bottom: 25 px;
        text-align: center;
    }
    .sub-title {
        font-size: small;
        text-align: center;
        margin-bottom: 65px;
    }
    .alert{
        position: fixed;
        left: 40px;
        bottom: 70px;
    }
    .circle{
        border-radius: 50%;
    }
</style>

<body>
    <?= view('layouts/header'); ?>
    <?= $this->renderSection('drawflow'); ?>
    <?php if (session()->has('success')): ?>
        <?= view('alerts/success') ?>
    <?php endif ?>
    <main>
        <div class="wrapper">
            <?= $this->renderSection('content'); ?>
        </div>
    </main>
</body>

</html>