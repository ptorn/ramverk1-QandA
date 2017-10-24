<?php

namespace Peto16\Qanda\Vote;

/**
 * Interface for VoteStorage
 */
interface VoteStorageInterface
{
    public function createVote(Vote $vote);
}
