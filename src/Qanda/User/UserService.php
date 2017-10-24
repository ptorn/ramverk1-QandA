<?php

namespace Peto16\Qanda\User;

/**
 * Service class for user.
 */
class UserService
{

    private $session;
    private $userService;
    private $queService;
    private $awnserService;
    private $comService;
    private $tagService;
    private $voteService;



    /**
     * Constructor for AwnserService
     *
     * @param object            $di dependency injection.
     */
    public function __construct($di)
    {
        $this->session          = $di->get("session");
        $this->userService      = $di->get("userService");
        $this->queService       = $di->get("questionService");
        $this->awnserService    = $di->get("awnserService");
        $this->comService       = $di->get("commentService");
        $this->tagService       = $di->get("tagService");
        $this->voteService      = $di->get("voteService");

    }



    public function filterDeleted($data)
    {
        return array_filter($data, function ($item) {
            return $item->deleted === null;
        });
    }



    public function calculateUserScore($userId)
    {
        $questions    = $this->queService->getAllQuestionsByField("userId", $userId);
        $awnsers      = $this->awnserService->getAllAwnsersByField("userId", $userId);
        $comments     = $this->comService->getAllCommentsByField("userId", $userId);

        $nrVotes        = 0;
        foreach ($questions as $question) {
            $nrVotes += sizeof($this->voteService->getAllVotesUp("questionId", $question->id));
        }
        foreach ($awnsers as $awnser) {
            $nrVotes += sizeof($this->voteService->getAllVotesUp("awnserId", $awnser->id));
        }
        foreach ($comments as $comment) {
            $nrVotes += sizeof($this->voteService->getAllVotesUp("commentId", $comment->id));
        }
        return sizeof($questions) + sizeof($awnsers) + sizeof($comments) + $nrVotes;
    }



    public function getMostActiveUsers()
    {
        $allUsers   = $this->userService->findAllUsers();
        $highScore  = [];
        foreach ($allUsers as $user) {
            if ($user->deleted === null) {
                $highScore[$this->calculateUserScore($user->id)] = $user;
            }
        }
        krsort($highScore, SORT_NUMERIC);
        return $highScore;
    }
}
