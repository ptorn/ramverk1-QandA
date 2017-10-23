<?php
$url = $this->di->get("url");
?>
<div class="widget most-active">
    <h2>Populära taggar</h1>

    <?php foreach ($tags as $tag => $score) : ?>
    <div class="user">
        <a href="<?= $url->create("tag/id/" . $tagsData[$tag]->id) ?>" title="<?= $tag ?>">
            <?= $tag ?>: (<?= $score ?>)
        </a>
    </div>
    <?php endforeach; ?>
</div>
