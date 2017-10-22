<?php
$url = $this->di->get("url");
?>
<h1>Alla taggar</h1>
<?php foreach ($allTags as $tag) : ?>
<div class="tag-item">
    <a href="<?= $url->create("tag/id/" . $tag->id) ?>">
        <?= $tag->name ?>
    </a>
</div>
<?php endforeach; ?>
