<?php
return [
    "mount" => "user",
    "routes" => [
        [
            "info" => "Login user.",
            "requestMethod" => "get|post",
            "path" => "login",
            "callable" => ["userController", "getPostLogin"],
        ],
        [
            "info" => "Create a user.",
            "requestMethod" => "get|post",
            "path" => "create",
            "callable" => ["userController", "getPostCreateUser"],
        ],
        [
            "info" => "Update a user.",
            "requestMethod" => "get|post",
            "path" => "update/{id:digit}",
            "callable" => ["userController", "getPostUpdateUser"],
        ],
        [
            "info" => "Logout user.",
            "requestMethod" => "get",
            "path" => "logout",
            "callable" => ["userController", "logout"],
        ],
        [
            "info" => "Delete a user.",
            "requestMethod" => "get|post",
            "path" => "delete/{id:digit}",
            "callable" => ["userController", "getPostDeleteUser"],
        ]
    ]
];
