<?php
return [
    "mount"     => "admin",
    "routes"    => [
        [
            "info" => "Dashboard.",
            "requestMethod" => "get",
            "path" => "",
            "callable" => ["adminController", "dashboard"],
        ]
    ]
];
