<?php
/**
 * Configuration file for DI container.
 */
return [
    // Services to add to the container.
    "services" => [
        "questionService" => [
            "shared" => true,
            "callback" => function () {
                $questionService = new \Peto16\Qanda\Question\QuestionService($this);
                return $questionService;
            }
        ],
        "questionController" => [
            "shared" => true,
            "callback" => function () {
                $questionController = new \Peto16\Qanda\Question\QuestionController();
                $questionController->setDI($this);
                $questionController->init();
                return $questionController;
            }
        ],
        "awnserService" => [
            "shared" => true,
            "callback" => function () {
                $awnserService = new \Peto16\Qanda\Awnser\AwnserService($this);
                return $awnserService;
            }
        ],
        "awnserController" => [
            "shared" => true,
            "callback" => function () {
                $awnserController = new \Peto16\Qanda\Awnser\AwnserController();
                $awnserController->setDI($this);
                $awnserController->init();
                return $awnserController;
            }
        ],
        "commentService" => [
            "shared" => true,
            "callback" => function () {
                $commentService = new \Peto16\Qanda\Comment\CommentService($this);
                return $commentService;
            }
        ],
        "commentController" => [
            "shared" => true,
            "callback" => function () {
                $commentController = new \Peto16\Qanda\Comment\CommentController();
                $commentController->setDI($this);
                $commentController->init();
                return $commentController;
            }
        ],
        "qandaUserController" => [
            "shared" => true,
            "callback" => function () {
                $qandaUserController = new \Peto16\Qanda\User\UserController();
                $qandaUserController->setDI($this);
                $qandaUserController->init();
                return $qandaUserController;
            }
        ],
        "tagController" => [
            "shared" => true,
            "callback" => function () {
                $tagController = new \Peto16\Qanda\Tag\TagController();
                $tagController->setDI($this);
                $tagController->init();
                return $tagController;
            }
        ],
        "tagService" => [
            "shared" => true,
            "callback" => function () {
                $tagService = new \Peto16\Qanda\Tag\TagService($this);
                return $tagService;
            }
        ],
    ],
];
