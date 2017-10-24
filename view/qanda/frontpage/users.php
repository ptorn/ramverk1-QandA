<?php
$url = $this->di->get("url");
var_dump($users);
?>
<div class="widget most-active">
    <h2>Mest aktiva</h2>

    <?php foreach ($users as $user) : ?>
    <div class="user">
        <a href="<?= $url->create("qanda/user/id/" . $user->id) ?>" title="<?= $user->username ?>">
            <?= $user->username ?> (Rang: <?= $user->score ?>)
        </a>
    </div>
    <?php endforeach; ?>
</div>
