<?php
$url = $this->di->get("url");
?>
<div class="awnser-post" style="margin-left:50px;">
    <h2>
        <a href="<?= $url->create("question/" . $questionIdUrl . "/awnser/" . $awnser->id) ?>">
            <?= htmlentities($awnser->title); ?>
        </a>
    </h2>
    <div class="awnser-content">
        <?= htmlentities($awnser->content); ?>
    </div>
    <div class="gravatar">
        <img src="<?= htmlentities($awnser->gravatar); ?>">
    </div>
    <div class="author">
        Skriven av: <?= htmlentities($awnser->firstname) . " " . htmlentities($awnser->lastname); ?>
    </div>
    <?php if ($awnser->owner || $awnser->userAdmin) : ?>
    <div class="edit">
        <a href="<?= $url->create("question/" . $questionIdUrl . "/awnser/edit/" . $awnser->id); ?>">
            Edit
        </a> -
        <a href="<?= $url->create("question/" . $questionIdUrl . "/awnser/delete/" . $awnser->id) ?>">
            Delete
        </a>
    </div>
    <?php endif ; ?>
</div>
