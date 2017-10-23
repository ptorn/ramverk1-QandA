<?php
return [
    "mount"     => "question/{id:digit}/awnser",
    "routes"    => [
        [
            "info" => "Awnser",
            "requestMethod" => "get|post",
            "path" => "{id:digit}",
            "callable" => ["awnserController", "getPostAwnserPage"],
        ],
        [
            "info" => "Delete awnser",
            "requestMethod" => "get",
            "path" => "delete/{id:digit}",
            "callable" => ["awnserController", "delAwnser"],
        ],
        [
            "info" => "Edit awnser post",
            "requestMethod" => "get|post",
            "path" => "edit/{id:digit}",
            "callable" => ["awnserController", "getPostEditAwnser"],
        ],
        [
            "info" => "Accept awnser post",
            "requestMethod" => "get",
            "path" => "{id:digit}/accept",
            "callable" => ["awnserController", "getAcceptAwnser"],
        ]
    ]
];
