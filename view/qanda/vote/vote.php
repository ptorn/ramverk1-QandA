<?php
$url = $this->di->get("url");
$nrVotesUp = isset($nrVotesUp) ? $nrVotesUp : 0;
$nrVotesDown = isset($nrVotesDown) ? $nrVotesDown : 0;
?>
<div class="score">
    <div class="vote" class="col-md-1">
        <form method="post" action="<?= $url->create("qanda/vote") ?>" class="col-md-1 ml-0 pl-0 mr-0 pr-0">
            <input type="hidden" name="type" value="<?= $type ?>">
            <input type="hidden" name="id" value="<?= $id ?>">
            <input type="hidden" name="vote" value="1">
            <input type="hidden" name="url" value="<?= $urlReturn ?>">
            <button class="btn btn-success" type="submit" name="action" value="vote">
                <i class="fa fa-thumbs-up" aria-hidden="true"></i> (<?= $nrVotesUp ?>)
            </button>
        </form>
        <form method="post" action="<?= $url->create("qanda/vote") ?>" class="col-md-11 ml-0 pl-0 mr-0 pr-0">
            <input type="hidden" name="type" value="<?= $type ?>">
            <input type="hidden" name="id" value="<?= $id ?>">
            <input type="hidden" name="vote" value="0">
            <input type="hidden" name="url" value="<?= $urlReturn ?>">
            <button class="btn btn-danger" type="submit" name="action" value="vote">
                <i class="fa fa-thumbs-down" aria-hidden="true"></i> (<?= $nrVotesDown ?>)
            </button>
        </form>

    </div>
</div>
<div class="score" class="col-md-10">
    <span class="label label-info">Rang: <?= $nrVotesUp - $nrVotesDown ?></span>
</div>
