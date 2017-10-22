<?php
$url = $this->di->get("url");
?>
<?php if (isset($result)) : ?>
    <div class="notice"><?= $result ; ?></div>
<?php endif ; ?>
<?php foreach ($questions as $question) : ?>
    <?php if ($question->deleted === null) : ?>
        <div class="question-post">
            <h2>
                <a href="<?= $url->create("question/" . $question->id) ?>">
                    <?= htmlentities($question->title); ?>
                </a>
            </h2>
            <div class="question-content">
                <?= htmlentities($question->content); ?>
            </div>
            <div class="gravatar">
                <img src="<?= htmlentities($question->gravatar); ?>">
            </div>
            <div class="author">
                Skriven av: <?= htmlentities($question->firstname) . " " . htmlentities($question->lastname); ?>
            </div>
            <?php if ($question->owner || $question->userAdmin) : ?>
            <div class="edit">
                <a href="<?= $url->create("question/edit/" . $question->id); ?>">
                    Edit
                </a> -
                <a href="question/delete/<?= $question->id ?>">
                    Delete
                </a>
            </div>
            <?php endif ; ?>
        </div>
    <?php endif ; ?>
<?php endforeach ; ?>
