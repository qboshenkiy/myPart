<?= $this->extend('layouts/default'); ?>


<?= $this->section('content') ?><div class="container">
    <style>
        @import url(https://fonts.googleapis.com/css?family=Open+Sans:300);

        .jumbotron-flat {
            height: 100%;
            border: 1px solid #4DB8FF;
            background: white;
            width: 100%;
            text-align: center;
            overflow: auto;
            color: black;
        }

        .paymentAmt {
            color: black;
            font-size: 80px;
        }

        .centered {
            text-align: center;
        }

        .title {
            padding-top: 15px;
            color: black;
        }

        .row {
            display: flex;
            gap: 50px;
            align-items: center;
        }

        .form-control {
            width: 450px;
            padding: 10px 30px;
            border-radius: 5px;
            border: solid 1px rgba(34, 34, 34, 0.22);
            background-color: transparent;
        }

        .form-group {
            display: flex;
            justify-content: space-between;
            gap: 40px;
        }


        .form-horizontal {
            display: flex;
            flex-direction: row;
            margin: 50px 0px;
            gap: 100px;
        }

        .col-md-3 {
            display: flex;
            font-weight: 800;
            font-size: 16px;
        }

        .col-md-8 {
            display: flex;
            gap: 5px;
        }

        .col-md-9 {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        h3 {
            font-weight: 800;
            font-size: 20px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            width: 150px;
        }

        .btn-primary {
            background-color: #4DB8FF;
            color: white;
        }

        .btn-default {
            background-color: #777;
            color: white;
        }

        .w-300 {
            width: 300px;
        }
    </style>
    <h1>Edit Profile</h1>
    <hr>
    <div class="row">
        <div class="form-horizontal">
            <div class="col-md-3">
                <div class="text-center">
                    <?php if ($avatar): ?>
                        <img src="<?= base_url('image/avatars/' . $avatar) ?>" alt="" width="300px" class="<?php if ($avatar != 'avatar.png'): 'circle' ?><?php endif ?>">
                    <?php else: ?>
                        <img src="https://png.pngitem.com/pimgs/s/150-1503945_transparent-user-png-default-user-image-png-png.png" class="avatar img-circle" alt="avatar">
                    <?php endif ?>

                    <h6>Upload a different photo...</h6>

                    <?= form_open_multipart('user/profile_edit') ?>
                    <input type="file" id="avatar" name="avatar" class="avatar btn btn-default w-300">
                    <input type="submit" value="update">
                    <?= form_close() ?>
                </div>
            </div>
            <?= form_open('user/profile_edit') ?>
            <div class="col-md-9 personal-info">
                <h3>Personal info</h3>
                <form action="" method=""></form>
                <div class="form-group">
                    <label class="col-md-3 control-label">Username:</label>
                    <div class="col-md-8">
                        <input class="form-control" name="firstname" type="text" value="<?= $firstname ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Lastname:</label>
                    <div class="col-lg-8">
                        <input class="form-control" name="lastname" type="text" value="<?= $lastname ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Email:</label>
                    <div class="col-lg-8">
                        <input class="form-control" name="email" type="text" value="<?= $email ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Description:</label>
                    <div class="col-lg-8">
                        <textarea class="form-control" name="description" type="text"><?= $description ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Number:</label>
                    <div class="col-lg-8">
                        <input class="form-control" name="phone" type="text" value="<?= $phone ?>">
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-md-3 control-label">Password:</label>
                    <div class="col-md-8">
                        <input class="form-control" type="password" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Confirm password:</label>
                    <div class="col-md-8">
                        <input class="form-control" type="password" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"></label>
                    <div class="col-md-8">
                        <input type="submit" class="btn btn-primary" value="Save Changes">
                        <span></span>
                        <input type="reset" class="btn btn-default" value="Cancel">
                    </div>
                </div>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>
<hr>
<?= $this->endSection() ?>