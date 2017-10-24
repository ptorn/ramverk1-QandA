<?php

namespace Peto16\Qanda\Vote;

/**
 * Interface for VoteStorage
 */
interface VoteStorageInterface
{
    public function createVote(Vote $vote);
    public function getAllVotesUp($field, $data);
    public function getAllVotesDown($field, $data);
    public function getVoteByField($field, $data);
    public function checkIfUserVoted($type, $typeId, $userId);
    public function getAllVotesByField($field, $data);
}
