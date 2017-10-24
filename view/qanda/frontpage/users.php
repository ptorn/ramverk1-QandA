<?php
$url = $this->di->get("url");
?>
<div class="widget most-active">
    <h2>Mest aktiva</h2>

    <?php foreach ($users as $username => $score) : ?>
    <div class="user">
        <!-- <a href="<?= $url->create("qanda/user/id/" . $user->id) ?>" title="<?= $username ?>"> -->
            <?= $username ?> (Rang: <?= $score ?>)
        <!-- </a> -->
    </div>
    <?php endforeach; ?>
</div>
