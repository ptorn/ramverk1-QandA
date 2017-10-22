<?php
return [
    "mount"     => "qanda/user",
    "routes"    => [
        [
            "info" => "List users",
            "requestMethod" => "get|post",
            "path" => "list",
            "callable" => ["qandaUserController", "getPostListUsersPage"],
        ],
        [
            "info" => "List user by id",
            "requestMethod" => "get",
            "path" => "id/{id:digit}",
            "callable" => ["qandaUserController", "getUserPage"],
        ],
    ]
];
