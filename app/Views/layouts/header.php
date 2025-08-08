
<style>
    * {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        text-rendering: optimizeLegibility;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        font-kerning: auto;
        margin: 0;
        padding: 0;
    }
    html {
        font-size: 10pt;
        line-height: 1.4;
        font-weight: 400;
        font-family: 'Source Sans Pro', 'Open Sans', Roboto, 'HelveticaNeue-Light', 'Helvetica Neue Light', 'Helvetica Neue', 'Myriad Pro', 'Segoe UI', Myriad, Helvetica, 'Lucida Grande', 'DejaVu Sans Condensed', 'Liberation Sans', 'Nimbus Sans L', Tahoma, Geneva, Arial, sans-serif;
        -webkit-text-size-adjust: 100%;
    }

    header {
        background-color: black;
    }

    body {
        position: relative;
        margin: 0;
        background: #eee;
    }

    section {
        height: 100vh;
        background: coral;
    }

    section span {
        margin: 0;
        font-size: 400%;
        text-align: center;
        line-height: 1;
        padding-top: calc(50vh - 20pt);
        display: block;
        font-weight: 700;
    }

    header {
        width: 100%;
        font-size: 140%;
        position: absolute;
        top: 100vh;
        left: 0;
        transition: opacity .2s ease-in-out;
        text-align: center;
        align-items: center;
    }

    .header h1 {
        font-weight: 600;
        display: inline;
        margin: 0;
        padding: 0;
        font-size: inherit;
    }

    nav a {
        display: inline-block;
        outline: none;
        text-decoration: none;
        padding: 0 .5em;
        color: white;
        transition: opacity .2s ease-in-out;
    }

    .list>a {
        color: black;
        z-index: 2;
    }

    nav a:hover,
    nav a:focus {
        color: cyan;
    }

    article {
        margin: 5em auto 0;
        padding: 1em;
        font-size: 140%;
        max-width: 800px;
        background: white;
        box-shadow: rgba(0, 0, 0, .05) 0 3px 15px;
    }

    article p {
        margin: 0;
        color: white;
    }

    article p+p {
        margin-top: .7em;
    }

    header {
        position: sticky;
        left: 0;
        top: 0;
        display: flex;
        justify-content: space-around;
        z-index: 1000;
    }

    span.link {
        color: white;
        transition: 0.3s;
        padding: 8px 20px;
        border-radius: 10px;
    }

    span.link:hover {
        transition: 0.3s;
        color: rgb(55, 97, 161);
        text-decoration: underline;
    }


    label {
        display: flex;
        cursor: pointer;
        position: relative;
    }

    ul {
        list-style: none;
        transition: 0.3s;
    }

    .header {
        display: flex;
        align-items: center;
        justify-content: space-around;
        color: white;
        text-transform: capitalize;
    }


    .flex-menu {
        display: flex;
        align-items: center;
        gap: 20px;
        margin: 10px;
    }



    .ava {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .flex-btn {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .circle {
        border-radius: 50%;
    }


    .navbar {
        overflow: hidden;
        background-color: #333;
    }

    .navbar a {
        float: left;
        color: white;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
    }

    .dropdown {
        float: left;
        overflow: hidden;
    }

    .dropdown .dropbtn {
        cursor: pointer;
        border: none;
        outline: none;
        color: white;
        background-color: black;
        margin: 0;
    }

    .navbar a:hover,
    .dropdown:hover .dropbtn,
    .dropbtn:focus {
        color: cyan;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        top: 0;
        right: 0;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    .dropdown-content a {
        float: none;
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        text-align: right;
    }


    .show {
        display: block;
    }
</style>
<header>
    <div class="wrapper">
        <div class="header">
            <?php if (session()->has('user_id')): ?>
                <div class="ava">
                    <img src="<?= base_url('image/avatars/' . $avatar) ?>" class="circle" alt="" width="50" height="50">
                    <h1><?= session('user_name') ?></h1>
                </div>
            <?php else: ?>
                <h1>MyPart</h1>
            <?php endif ?>
            <nav>
                <div class="flex-menu">
                    <div class="navbar">
                        <div class="dropdown">
                            <a class="dropbtn" onclick="myFunction()">Menu
                                <i class="fa fa-caret-down"></i>
                            </a>
                            <div class="dropdown-content" id="myDropdown">
                                <?php if (session()->has('user_id')): ?>
                                    <a href="<?= base_url('home/') ?>">Home</a>
                                    <a href="<?= base_url('user/profile/' . session('id')) ?>">Profile</a>
                                    <a href="<?= base_url('drawflow/index') ?>">Drawflow</a>
                                    <a href="<?= base_url('drawflow/parser') ?>">Parser</a>
                                    <a href="<?= base_url('note/note') ?>">Note</a>
                                    <a href="<?= base_url('drawflow/test') ?>">Note</a>
                                    <a href="<?= base_url('user/profile_edit') ?>">Settings</a>
                                    <a href="<?= base_url('signup/logout') ?>">Logout</a>
                                <?php else: ?>
                                    <a href='<?= site_url('signup/login') ?>'>SignIn</a>
                                    <a href='<?= site_url('signup/register') ?>'>SignUp</a>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</header>
<script>
    /* Когда пользователь нажимает на кнопку,
        переключаться между скрытием и отображением раскрывающегося содержимого */
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    // Закройте раскрывающийся список, если пользователь щелкнет за его пределами
    window.onclick = function(e) {
        if (!e.target.matches('.dropbtn')) {
            var myDropdown = document.getElementById("myDropdown");
            if (myDropdown.classList.contains('show')) {
                myDropdown.classList.remove('show');
            }
        }
    }
</script>