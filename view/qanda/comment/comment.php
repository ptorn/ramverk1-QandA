<?php
$url = $this->di->get("url");
?>
<div class="comment-post" style="margin-left:50px;">
    <h2><?= htmlentities($comment->title); ?></h2>
    <div class="awnser-content">
        <?= htmlentities($comment->content); ?>
    </div>
    <div class="gravatar">
        <img src="<?= htmlentities($comment->gravatar); ?>">
    </div>
    <div class="author">
        Skriven av: <?= htmlentities($comment->firstname) . " " . htmlentities($comment->lastname); ?>
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
    <?php endif ; ?>
</div>
