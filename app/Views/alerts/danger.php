<style>
    .success {
        background-color: lightgreen;
        color: white;
        text-align: center;
        text-transform: uppercase;
        font-size: large;
        padding: 10px 20px;
        border-radius: 10px;

    }
</style>


<div class="success alert">
    <ul>
        <?php foreach (session('errors') as $item): ?>
            <li><?= $item ?></li>
        <?php endforeach ?>
    </ul>
</div>