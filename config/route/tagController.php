<?php
return [
    "mount"     => "tags",
    "routes"    => [
        [
            "info" => "Tags",
            "requestMethod" => "get",
            "path" => "",
            "callable" => ["tagController", "getTagsPage"],
        ],
    ]
];
