<?php
$url = $this->di->get("url");
?>
<div class="awnser-post" style="margin-left:50px;">
    <h2>
        <a href="<?= $url->create("question/" . $questionIdUrl . "/awnser/" . $awnser->id) ?>">
            <?= $awnser->title; ?>
        </a>
    </h2>
    <div class="awnser-content">
        <?= $awnser->content; ?>
    </div>
    <div class="gravatar">
        <img src="<?= $awnser->gravatar; ?>">
    </div>
    <div class="author">
        Skriven av: <?= $awnser->firstname . " " . $awnser->lastname; ?>
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
    <?php endif; ?>
</div>
