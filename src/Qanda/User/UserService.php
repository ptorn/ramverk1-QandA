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
     * Constructor for UserService
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



    /**
     * Filter deleted items.
     * @param  array       $data array to be filtered
     * @return array       filtered array
     */
    public function filterDeleted($data)
    {
        return array_filter($data, function ($item) {
            return $item->deleted === null;
        });
    }



    /**
     * Calculate the userscore
     * @param  int          $userId User id
     * @return int          total score
     */
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



    /**
     * Get most active users
     * @return array array with most active users
     */
    public function getMostActiveUsers()
    {
        $allUsers   = $this->userService->findAllUsers();
        $highScore  = [];
        $userScore  = [];
        $userData   = [];
        foreach ($allUsers as $user) {
            if ($user->deleted === null && $user->enabled === 1) {
                $user->score = $this->calculateUserScore($user->id);
                $userScore[$user->id] = $this->calculateUserScore($user->id);
                $userData[$user->id] = $user;
            }
        }
        arsort($userScore, SORT_NUMERIC);

        foreach ($userScore as $key => $value) {
            $highScore[] = $userData[$key];
        }
        return $highScore;
    }
}
