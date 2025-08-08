<?= $this->extend('layouts/default'); ?>


<?= $this->section('content') ?>
<style>
    .card-big-shadow {
        max-width: 320px;
        position: relative;
    }

    .coloured-cards .card {
        margin-top: 30px;
    }

    .card[data-radius="none"] {
        border-radius: 0px;
    }

    .card {
        border-radius: 8px;
        box-shadow: 0 2px 2px rgba(204, 197, 185, 0.5);
        background-color: #FFFFFF;
        color: #252422;
        margin-bottom: 20px;
        position: relative;
        z-index: 1;
    }


    .card[data-background="image"] .title,
    .card[data-background="image"] .stats,
    .card[data-background="image"] .category,
    .card[data-background="image"] .description,
    .card[data-background="image"] .content,
    .card[data-background="image"] .card-footer,
    .card[data-background="image"] small,
    .card[data-background="image"] .content a,
    .card[data-background="color"] .title,
    .card[data-background="color"] .stats,
    .card[data-background="color"] .category,
    .card[data-background="color"] .description,
    .card[data-background="color"] .content,
    .card[data-background="color"] .card-footer,
    .card[data-background="color"] small,
    .card[data-background="color"] .content a {
        color: #FFFFFF;
    }

    .card.card-just-text .content {
        padding: 50px 65px;
        text-align: center;
    }

    .card .content {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        width: 350px;
        height: 400px;
        box-shadow: 10px 5px 5px rgba(37, 36, 34, 0.33);
        padding: 20px 20px 10px 20px;
    }

    .card[data-color="blue"] .category {
        color: #7a9e9f;
    }

    .card .category,
    .card .label {
        font-size: 14px;
        margin-bottom: 0px;
    }



    h4,
    .h4 {
        font-size: 1.5em;
        font-weight: 600;
        line-height: 1.2em;
    }

    h6,
    .h6 {
        font-size: 0.9em;
        font-weight: 600;
        text-transform: uppercase;
    }

    .card .description {
        font-size: 16px;
        color: #66615b;
    }

    .content-card {
        margin-top: 30px;
    }

    a:hover,
    a:focus {
        text-decoration: none;
    }

    /*======== COLORS ===========*/
    .card[data-color="blue"] {
        width: 350px;
        background: #b8d8d8;
    }

    .card[data-color="blue"] .description {
        color: #506568;
    }

    .card[data-color="green"] {
        width: 350px;
        background: #d5e5a3;
    }

    .card[data-color="green"] .description {
        color: #60773d;
    }

    .card[data-color="green"] .category {
        color: #92ac56;
    }

    .card[data-color="yellow"] {
        width: 350px;
        background: #ffe28c;
    }

    .card[data-color="yellow"] .description {
        color: #b25825;
    }

    .card[data-color="yellow"] .category {
        color: #d88715;
    }

    .card[data-color="brown"] {
        width: 350px;
        background: #d6c1ab;
    }

    .card[data-color="brown"] .description {
        color: #75442e;
    }

    .card[data-color="brown"] .category {
        color: #a47e65;
    }

    .card[data-color="purple"] {
        width: 350px;
        background: #baa9ba;
    }

    .card[data-color="purple"] .description {
        color: #3a283d;
    }

    .card[data-color="purple"] .category {
        color: #5a283d;
    }

    .card[data-color="orange"] {
        width: 350px;
        background: #ff8f5e;
    }

    .card[data-color="orange"] .description {
        color: #772510;
    }

    .card[data-color="orange"] .category {
        color: #e95e37;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;

        gap: 20px;
    }

    .center {
        display: flex;
        flex-direction: column;
        gap: 2px;
        text-align: left;
    }





    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    h1 {
        font-size: 24px;
    }

    .note {
        background-color: #7a9e9f;
        width: 400px;
        height: 550px;
        margin: 0 auto;
        padding: 40px 30px 10px 30px;
        color: black;
        text-shadow: #33333381 1px 1px 1px;
    }

    .form-header {
        display: flex;
        align-items: end;
        justify-content: space-between;
    }

    .container-flex {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 480px;
    }

    .green {
        color: green;
        background-color: lightgreen;
    }

    .red {
        color: red;
        background-color: tomato;
    }

    .gray {
        color: gray;
        background-color: lightgray;
    }

    select {
        text-align: right;
        background-color: transparent;
        border: none;
        border-radius: none;
        font-weight: 600;
    }

    select:focus {
        background-color: transparent;
        border: none;
        outline: none;
        border-radius: none;
    }

    option {
        margin: 5px;
        width: 100px;
        border-radius: none;
        text-align: center;
        padding: 5px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-date {
        display: flex;
        gap: 10px;
        justify-content: right;
    }

    input[type="date"] {
        border: none;
        background-color: transparent;
        width: 18px;

    }

    .hidde {
        display: none;
    }

    .container-flex>.form-group {
        gap: 10px;
    }

    .form-group input[type="text"] {
        background-color: transparent;
        border: none;
        border-bottom: 1px solid #333;
    }

    input:focus {

        outline: none;
    }

    .fixed-content {
        width: 100%;
        height: 100%;
        position: relative;
        background-color: black;
    }

    .note {
        position: fixed;
        top: 100px;
        left: 0;
        z-index: 1004;
        right: 0;
    }
</style>
<div class="container flex bootstrap snippets bootdeys">
    <div class="row">
        <div class="col-md-4 col-sm-6 content-card">
            <div class="card-big-shadow">
                <div class="card card-just-text" data-background="color" data-color="blue" data-radius="none">
                    <div class="content">
                        <div>
                            <h6 class="category">Выполненые</h6>
                            <h4 class="title"><a href="#">Задача</a></h4>
                        </div>
                        <div class="center text-left">
                            <p class="description">1. Сделать SignUp/Profile</p>
                            <p class="description">2. Сделать Note</p>
                            <p class="description">4. Сделать Posts</p>
                            <p class="description">3. Сделать Message/Group</p>
                        </div>
                        <div>
                            <b class="description">17.11.04</b>
                        </div>
                    </div>
                </div>
            </div> <!-- end card -->
        </div>

        <?php foreach ($note as $item): ?>
            <div class="col-md-4 col-sm-6 content-card">
                <div class="card-big-shadow">
                    <div class="card card-just-text" data-background="color" data-color="green" data-radius="none">
                        <div class="content">
                            <div>
                                <h6 class="category"><?= $item['action'] ?></h6>
                                <h4 class="title"><a href="#"><?= $item['title'] ?></a></h4>
                            </div>
                            <div class="center text-left">
                                <p class="description"><?= $item['description'] ?></p>
                            </div>
                            <div>
                                <b class="description"><?= $item['date'] ?></b>
                            </div>
                        </div>
                    </div> <!-- end card -->
                </div>
            </div>
        <?php endforeach ?>

        <div class="col-md-4 col-sm-6 content-card">
            <div class="card-big-shadow">
                <div class="card card-just-text" data-background="color" data-color="yellow" data-radius="none">
                    <div class="content">
                        <div>
                            <h6 class="category">Выполненые</h6>
                            <h4 class="title"><a href="#">Задача</a></h4>
                        </div>
                        <div class="center text-left">
                            <p class="description">1. Сделать SignUp/Profile</p>
                            <p class="description">2. Сделать Note</p>
                            <p class="description">4. Сделать Posts</p>
                            <p class="description">3. Сделать Message/Group</p>
                        </div>
                        <div>
                            <b class="description">17.11.04</b>
                        </div>
                    </div>
                    <div>
                    </div>
                </div> <!-- end card -->
            </div>
        </div>

        <div class="col-md-4 col-sm-6 content-card">
            <div class="card-big-shadow">
                <div class="card card-just-text" data-background="color" data-color="brown" data-radius="none">
                    <div class="content">
                        <div>
                            <h6 class="category">Выполненые</h6>
                            <h4 class="title"><a href="#">Задача</a></h4>
                        </div>
                        <div class="center text-left">
                            <p class="description">1. Сделать SignUp/Profile</p>
                            <p class="description">2. Сделать Note</p>
                            <p class="description">4. Сделать Posts</p>
                            <p class="description">3. Сделать Message/Group</p>
                        </div>
                        <div>
                            <b class="description">17.11.04</b>
                        </div>
                    </div>
                    <div>
                    </div>
                </div> <!-- end card -->
            </div>
        </div>

        <div class="col-md-4 col-sm-6 content-card">
            <div class="card-big-shadow">
                <div class="card card-just-text" data-background="color" data-color="purple" data-radius="none">
                    <div class="content">
                        <div>
                            <h6 class="category">Выполненые</h6>
                            <h4 class="title"><a href="#">Задача</a></h4>
                        </div>
                        <div class="center text-left">
                            <p class="description">1. Сделать SignUp/Profile</p>
                            <p class="description">2. Сделать Note</p>
                            <p class="description">4. Сделать Posts</p>
                            <p class="description">3. Сделать Message/Group</p>
                        </div>
                        <div>
                            <b class="description">17.11.04</b>
                        </div>
                    </div>
                </div>
            </div> <!-- end card -->
        </div>


        <div class="col-md-4 col-sm-6 content-card">
            <div class="card-big-shadow">
                <div class="card card-just-text" data-background="color" data-color="orange" data-radius="none">
                    <div class="content">
                        <div>
                            <h6 class="category">Выполненые</h6>
                            <h4 class="title"><a href="#">Задача</a></h4>
                        </div>
                        <div class="center text-left">
                            <p class="description">1. Сделать SignUp/Profile</p>
                            <p class="description">2. Сделать Note</p>
                            <p class="description">4. Сделать Posts</p>
                            <p class="description">3. Сделать Message/Group</p>
                        </div>
                        <div>
                            <b class="description">17.11.04</b>
                        </div>
                    </div>

                </div> <!-- end card -->
            </div>
        </div>
    </div>
</div>
</div>
</div>
<div class="fixed-content">
    <div class="note">
        <?= form_open('note/note_add') ?>
        <div class="container-flex">
            <div class="form-header">
                <div class="title">
                    <h1>My Note</h1>
                </div>
                <div class="form-group">
                    <div class="action">
                        <select name="action" id="">
                            <option value="Выполнено"><span class="green">Выполнено</span></option>
                            <option value="Важное"><span class="red">Важное</span></option>
                            <option value="Отложеное"><span class="gray">Отложеное</span></option>
                            <option value="В процессе"><span class="orange">В процессе</span></option>
                        </select>
                    </div>
                    <div class="form-date">
                        <label for="">Date</label>
                        <input type="date" name="date">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="">Description:</label>
                <input type="text" name="description">


            </div>
            <div class="form-group">
                <label for="task">Node: </label>
                <input type="text" name="task">
                <select name="user_id" id="" class="hidde">
                    <option type="text" value="<?php echo session('user_id') ?>"> </option>
                </select>
            </div>
            <div class="task_id">
                <p class="id">ID: 1</p>
                <button type="submit">Add</button>
            </div>
        </div>
        <?= form_close() ?>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const inputs = document.querySelectorAll('.form-group input[type="text"]');

        inputs.forEach((input, i) => {
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    if (inputs[i + 1]) inputs[i + 1].focus();
                }
            });

            input.addEventListener('input', () => {
                if (input.scrollWidth > input.clientWidth) {
                    if (inputs[i + 1]) inputs[i + 1].focus();
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>