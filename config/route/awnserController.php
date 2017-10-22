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
        // [
        //     "info" => "Question by id",
        //     "requestMethod" => "get|post",
        //     "path" => "{id:digit}",
        //     "callable" => ["questionController", "getQuestionByIdPage"],
        // ],
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
        ]
    ]
];
