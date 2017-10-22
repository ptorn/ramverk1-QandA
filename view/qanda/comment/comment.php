<?php
$url = $this->di->get("url");
?>
<div class="comment-post" style="margin-left:50px;">
    <h2><?= $comment->title; ?></h2>
    <div class="awnser-content">
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
            Edit
        </a> -
        <a href="<?= $url->create("question/" . $questionIdUrl . "/awnser/" . $awnserIdUrl . "/comment/delete/" . $comment->id) ?>">
            Delete
        </a>
    </div>
    <?php endif; ?>
</div>
