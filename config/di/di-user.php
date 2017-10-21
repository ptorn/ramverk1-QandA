<?php
/**
 * Configuration file for DI container.
 */
return [
    // Services to add to the container.
    "services" => [
        "userService" => [
            "shared" => true,
            "callback" => function () {
                $user = new \Peto16\User\UserService($this);
                return $user;
            }
        ],
        "userController" => [
            "shared" => true,
            "callback" => function () {
                $userController = new \Peto16\User\UserController();
                $userController->setDI($this);
                $userController->init();
                return $userController;
            }
        ],
    ],
];
