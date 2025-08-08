
<style>
    .error {
        background-color:rgba(255, 73, 73, 0.71);
        color: white;
        text-align: center;
        font-size: medium;
        border-radius: 10px;

    }
    ul{
        padding: 10px 20px;
        list-style: none;
    }
</style>



<div class="error alert">
    <ul>
        <?php foreach (session('errors') as $item): ?>
            <li><?= $item ?></li>
        <?php endforeach ?>
    </ul>
</div>
