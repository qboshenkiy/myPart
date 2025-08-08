
<style>
    .success {
        background-color: lightgreen;
        color:#368a46;
        font-size: medium;
        border-radius: 10px;
        text-align: center;

        
    }
     p{
        margin: 20px 20px 20px 20px;
        list-style: none;
        text-align: center;
    }
</style>



<div class="success alert">
        <?php foreach (session('success') as $item): ?>
            <p><?= $item ?></p>
        <?php endforeach ?>
</div>
