<?php
return [
    "mount"     => "question/{questionId:digit}/awnser/{awnserId:digit}/comment",
    "routes"    => [
        [
            "info" => "Delete comment",
            "requestMethod" => "get",
            "path" => "delete/{commentId:digit}",
            "callable" => ["commentController", "delComment"],
        ],
        [
            "info" => "Edit comment post",
            "requestMethod" => "get|post",
            "path" => "edit/{commentId:digit}",
            "callable" => ["commentController", "getPostEditComment"],
        ]
    ]
];
