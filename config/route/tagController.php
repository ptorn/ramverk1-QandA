<?php
return [
    "mount"     => "tag",
    "routes"    => [
        [
            "info" => "Tags",
            "requestMethod" => "get",
            "path" => "",
            "callable" => ["tagController", "getTagsPage"],
        ],
        [
            "info" => "Questions with tag",
            "requestMethod" => "get",
            "path" => "id/{id:digit}",
            "callable" => ["tagController", "getQuestionsToTagPage"],
        ],
    ]
];
