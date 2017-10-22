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

    }

    public function filterDeleted($data)
    {
        return array_filter($data, function ($item) {
            return $item->deleted === null;
        });
    }



    public function calculateUserScore($userId)
    {
        $nrQuestions = sizeof($this->queService->getAllQuestionsByField("userId = ?", $userId));
        $nrAwnsers = sizeof($this->awnserService->getAllAwnsersByField("userId = ?", $userId));
        $nrComments = sizeof($this->comService->getAllCommentsByField("userId = ?", $userId));
        return $nrQuestions + $nrAwnsers + $nrComments;
    }
}
