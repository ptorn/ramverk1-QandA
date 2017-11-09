<?php

namespace Peto16\Qanda\Vote;

/**
 * Service class for vote.
 */
class VoteService
{

    private $voteStorage;
    private $userService;

    /**
     * Constructor for TagService
     *
     * @param object            $di dependency injection.
     */
    public function __construct($di)
    {
        $this->voteStorage = new VoteStorage();
        $this->voteStorage->setDb($di->get("db"));
        $this->userService      = $di->get("userService");

    }



    /**
     * Add a vote
     * @param string    $type   type of item
     * @param int       $postId id of item
     * @param bool      $vote   vote
     */
    public function addVote($type, $postId, $vote)
    {
        $userId = $this->userService->getCurrentLoggedInUser()->id;
        if ($this->checkIfUserVoted($type, $postId, $userId)) {
            $this->voteStorage->changeVote($type, $postId, $userId, $vote);
            return;
        }

        $newVote = new Vote();
        switch ($type) {
            case 'awnserId':
                $newVote->awnserId = $postId;
                break;
            case 'questionId':
                $newVote->questionId = $postId;
                break;
            case 'commentId':
                $newVote->commentId = $postId;
                break;
            default:
                break;
        }
        $newVote->vote = (bool)$vote;
        $newVote->userId = $userId;
        $this->voteStorage->createVote($newVote);
    }



    /**
     * Check if user voted
     * @param string        $type   type of item
     * @param int           $postId id of item
     * @param int           $userId user id.
     * @return boolean      true or false
     */
    public function checkIfUserVoted($type, $postId, $userId)
    {
        if (empty($this->voteStorage->checkIfUserVoted($type, $postId, $userId))) {
            return false;
        }
        return true;
    }



    /**
     * Get all votes by field
     * @param  string       $field string with field
     * @param  mixed        $data  data to search for
     * @return array        array with all votes
     */
    public function getAllVotesByField($field, $data)
    {
        return $this->voteStorage->getAllVotesByField($field, $data);
    }



    /**
     * Get all votes up
     * @param  string       $field field to search
     * @param  mixed        $data  data to find
     * @return array        array with all votes thumbs up
     */
    public function getAllVotesUp($field, $data)
    {
        return $this->voteStorage->getAllVotesUp($field, $data);
    }



    /**
     * Get all votes down
     * @param  string       $field field to search
     * @param  mixed        $data  data to find
     * @return array        array with all votes thumbs down
     */
    public function getAllVotesDown($field, $data)
    {
        return $this->voteStorage->getAllVotesDown($field, $data);
    }
}
