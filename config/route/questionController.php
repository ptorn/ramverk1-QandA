<?php
return [
    "mount"     => "question",
    "routes"    => [
        [
            "info" => "Question",
            "requestMethod" => "get|post",
            "path" => "",
            "callable" => ["questionController", "getQuestionsPage"],
        ],
        [
            "info" => "Delete question",
            "requestMethod" => "get",
            "path" => "delete/{id:digit}",
            "callable" => ["questionController", "delQuestion"],
        ],
        [
            "info" => "Edit question post",
            "requestMethod" => "get|post",
            "path" => "edit/{id:digit}",
            "callable" => ["questionController", "getPostEditQuestion"],
        ]
    ]
];
