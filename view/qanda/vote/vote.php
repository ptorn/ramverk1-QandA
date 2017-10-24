<?php
$url = $this->di->get("url");
$nrVotesUp = isset($nrVotesUp) ? $nrVotesUp : 0;
$nrVotesDown = isset($nrVotesDown) ? $nrVotesDown : 0;
?>
<?php if ($loggedInUser) : ?>
<div class="vote">
    <form method="post" action="<?= $url->create("qanda/vote") ?>" class="col-md-1 ml-0 pl-0 mr-0 pr-0">
        <input type="hidden" name="type" value="<?= $type ?>">
        <input type="hidden" name="id" value="<?= $id ?>">
        <input type="hidden" name="vote" value="1">
        <input type="hidden" name="url" value="<?= $urlReturn ?>">
        <button class="btn btn-success" type="submit" name="action" value="vote">
            <i class="fa fa-thumbs-up" aria-hidden="true"></i> (<?= $nrVotesUp ?>)
        </button>
    </form>
    <form method="post" action="<?= $url->create("qanda/vote") ?>">
        <input type="hidden" name="type" value="<?= $type ?>">
        <input type="hidden" name="id" value="<?= $id ?>">
        <input type="hidden" name="vote" value="0">
        <input type="hidden" name="url" value="<?= $urlReturn ?>">
        <button class="btn btn-danger" type="submit" name="action" value="vote">
            <i class="fa fa-thumbs-down" aria-hidden="true"></i> (<?= $nrVotesDown ?>)
        </button>
    </form>
</div>
<?php endif; ?>
