<?php
$url = $this->di->get("url");
?>
<h1>Användarinformation för <?= $user->firstname ?> <?= $user->lastname ?></h1>
<div class="row">
    <div class="col-md-2 col-xs-12">
        <img src="<?= $gravatarUrl; ?>">
    </div>
    <div class="col-md-10 col-xs-12">
        <ul class="list-group col-md-5">
            <li class="list-group-item"><strong>Förnamn: </strong><?= $user->firstname; ?></li>
            <li class="list-group-item"><strong>Efternamn: </strong><?= $user->lastname; ?></li>
            <li class="list-group-item"><strong>Epost: </strong><?= $user->email; ?></li>
            <li class="list-group-item"><strong>Aktiverad: </strong><?= $user->enabled; ?></li>
            <li class="list-group-item"><strong>Administrator: </strong><?= $user->administrator; ?></li>
            <li class="list-group-item"><strong>Rang: </strong><?= $userPoints; ?></li>
        </ul>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-xs-12">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#questions">Frågor</a></li>
            <li><a data-toggle="tab" href="#awnsers">Svar</a></li>
            <li><a data-toggle="tab" href="#comments">Kommentarer</a></li>
            <li><a data-toggle="tab" href="#votes">Röster</a></li>
        </ul>

        <div class="tab-content">
            <div id="questions" class="tab-pane fade in active">
                <h3>Frågor</h3>
                <?php foreach ($questions as $question) : ?>
                <div class="question-item">
                    <div class="question-title">
                        <a href="<?= $url->create("question/" . $question->id) ?>" title="<?= $question->title ?>">
                            <?= $question->title ?>
                        </a>
                    </div>
                    <div class="question-content">
                        <?= $question->content ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div id="awnsers" class="tab-pane fade">
                <h3>Svar</h3>
                <?php foreach ($awnsers as $awnser) : ?>
                <div class="awnser-item">
                    <div class="awnser-title">
                        <a href="<?= $url->create("question/" . $awnser->questionId . "/awnser/" . $awnser->id) ?>" title="<?= $awnser->title ?>">
                            <?= $awnser->title ?>
                        </a>
                    </div>
                    <div class="awnser-content">
                        <?= $awnser->content ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div id="comments" class="tab-pane fade">
                <h3>Kommentarer</h3>
                <?php foreach ($comments as $comment) : ?>
                <div class="comment-item">
                    <div class="comment-title">
                        <a href="<?= $url->create("question/" . $comment->questionId . "/awnser/" . $comment->awnserId) ?>" title="<?= $comment->title ?>">
                            <?= $comment->title ?>
                        </a>
                    </div>
                    <div class="comment-content">
                        <?= $comment->content ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div id="votes" class="tab-pane fade">
                <h3>Röster</h3>
                <div class="vote-item">
                    <div class="vote-content">
                        <?= $user->firstname; ?> <?= $user->lastname; ?> har röstat <?= $nrVotes; ?> gånger.
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
