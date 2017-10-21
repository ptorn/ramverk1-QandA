<?php
/**
 * Configuration file for DI container.
 */
return [
    // Services to add to the container.
    "services" => [
        "adminController" => [
            "shared" => true,
            "callback" => function () {
                $adminController = new \Peto16\Admin\AdminController();
                $adminController->setDI($this);
                // $adminController->init();
                return $adminController;
            }
        ],
    ],
];
