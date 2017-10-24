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



    public function addVote($type, $postId, $vote)
    {
        $userId = $this->userService->getCurrentLoggedInUser()->id;
        if ($this->checkIfUserVoted($type, $postId, $userId)) {
            throw new Exception("User has already voted", 1);
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



    public function checkIfUserVoted($type, $postId, $userId)
    {
        if(empty($this->voteStorage->checkIfUserVoted($type, $postId, $userId))) {
            return false;
        }
        return true;
    }



    public function getAllVotesByField($field, $data)
    {
        return $this->voteStorage->getAllVotesByField($field, $data);
    }



    public function getAllVotesUp($field, $data)
    {
        return $this->voteStorage->getAllVotesUp($field, $data);
    }


    public function getAllVotesDown($field, $data)
    {
        return $this->voteStorage->getAllVotesDown($field, $data);
    }
}
