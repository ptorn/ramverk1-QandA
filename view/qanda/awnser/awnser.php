<?php
$url = $this->di->get("url");
?>
<div class="awnser-post">
    <h2>
        <a href="<?= $url->create("question/" . $questionIdUrl . "/awnser/" . $awnser->id) ?>">
            <?= $awnser->title; ?>
        </a>
    </h2>
    <?php if ($awnser->accept) : ?>
    <div class="alert alert-info">
        Accepterat svar
    </div>
    <?php endif; ?>
    <div class="awnser-content">
        <?= $awnser->content; ?>
    </div>
    <div class="gravatar">
        <img src="<?= $awnser->gravatar; ?>">
    </div>
    <div class="author">
        Skriven av: <?= $awnser->firstname . " " . $awnser->lastname; ?>
    </div>
    <div class="edit">
        <?php if ($awnser->owner || $awnser->userAdmin) : ?>
        <a href="<?= $url->create("question/" . $questionIdUrl . "/awnser/edit/" . $awnser->id); ?>">
            Redigera
        </a> -
        <a href="<?= $url->create("question/" . $questionIdUrl . "/awnser/delete/" . $awnser->id) ?>">
            Radera
        </a> -
        <?php endif; ?>
        <?php if ($question->owner && !$awnser->accept) : ?>
        <a href="<?= $url->create("question/" . $questionIdUrl . "/awnser/" . $awnser->id . "/accept"); ?>">
                Acceptera
        </a> -
        <?php endif; ?>
    </div>

    <?php include(dirname(__FILE__) . "/../vote/vote.php"); ?>

    <hr>
    <?php if ($this->regionHasContent("comment")) : ?>
    <div class="comments">
        <h2>Kommentar</h2>
        <?php $this->renderRegion("comment") ?>
    </div>
    <?php endif; ?>
</div>
