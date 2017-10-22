<?php
return [
    "mount"     => "question/{id:digit}/awnser/{id:digit}",
    "routes"    => [
        // [
        //     "info" => "Question",
        //     "requestMethod" => "get|post",
        //     "path" => "",
        //     "callable" => ["questionController", "getQuestionsPage"],
        // ],
        // [
        //     "info" => "Question by id",
        //     "requestMethod" => "get|post",
        //     "path" => "{id:digit}",
        //     "callable" => ["questionController", "getQuestionByIdPage"],
        // ],
        [
            "info" => "Delete comment",
            "requestMethod" => "get",
            "path" => "delete/{id:digit}",
            "callable" => ["commentController", "delComment"],
        ],
        [
            "info" => "Edit comment post",
            "requestMethod" => "get|post",
            "path" => "edit/{id:digit}",
            "callable" => ["awnserController", "getPostEditAwnser"],
        ]
    ]
];
