<?php
return [
    "mount"     => "qanda/vote",
    "routes"    => [
        [
            "info" => "Vote Up",
            "requestMethod" => "post",
            "path" => "",
            "callable" => ["voteController", "postVote"],
        ],
    ]
];
