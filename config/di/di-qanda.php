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
                $questionService = new \Peto16\Qanda\QuestionService($this);
                return $questionService;
            }
        ],
        "questionController" => [
            "shared" => true,
            "callback" => function () {
                $questionController = new \Peto16\Qanda\QuestionController();
                $questionController->setDI($this);
                $questionController->init();
                return $questionController;
            }
        ],
    ],
];
