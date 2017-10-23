<?php
$url = $this->di->get("url");
?>
<div class="comment-post">
    <h2><?= $comment->title; ?></h2>
    <div class="comment-content">
        <?= $comment->content; ?>
    </div>
    <div class="gravatar">
        <img src="<?= $comment->gravatar; ?>">
    </div>
    <div class="author">
        Skriven av: <?= $comment->firstname . " " . $comment->lastname; ?>
    </div>
    <?php if ($comment->owner || $comment->userAdmin) : ?>
    <div class="edit">
        <a href="<?= $url->create("question/" . $questionIdUrl . "/awnser/" . $awnserIdUrl . "/comment/edit/" . $comment->id); ?>">
            Redigera
        </a> -
        <a href="<?= $url->create("question/" . $questionIdUrl . "/awnser/" . $awnserIdUrl . "/comment/delete/" . $comment->id) ?>">
            Radera
        </a>
    </div>
    <?php endif; ?>
</div>
<hr>
