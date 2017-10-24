<?php
return [
    "navbar" => [
        "config" => [
            "navbar-class" => "navbar"
        ],
        "items" => [
            "frontpage" => [
                "icon"      => "home",
                "title"     => "Start",
                "route"     => "",
                "available" => null

            ],
            "questions" => [
                "icon"      => "question",
                "title"     => "Frågor",
                "route"     => "question",
                "available" => null

            ],
            "tag" => [
                "icon"      => "tags",
                "title"     => "Taggar",
                "route"     => "tag",
                "available" => null

            ],
            "about" => [
                "icon"      => "info-circle",
                "title"     => "Om",
                "route"     => "about",
                "available" => null

            ],
            "login" => [
                "icon"  => "lock",
                "title"  => "Login",
                "route" => "user/login",
                "available" => null
            ],
            "logout" => [
                "icon"  => "user-circle-o",
                "title"  => "Admin",
                "route" => "#",
                "available" => "administrator",
                "submenu" => [
                    "items" => [
                        "dashboard" => [
                            "icon"      => "dashboard",
                            "title"     => "Dashboard",
                            "route"     => "admin",
                            "available" => "administrator",
                        ],
                        "users" => [
                            "icon"      => "users",
                            "title"     => "QandA - resultat",
                            "route"     => "qanda/user/list",
                            "available" => null

                        ],
                        "logout" => [
                            "icon"      => "sign-out",
                            "title"     => "Logout",
                            "route"     => "user/logout",
                            "available" => "administrator",
                        ]
                    ]
                ]
            ]
        ]
    ],
    "social" => [
        "config" => [
            "navbar-class" => "social-links"
        ],
        "items" => [
            "github" => [
                "icon"      => "github",
                "title"     => "Github",
                "route"     => "https://github.com/ptorn/ramverk1-QandA",
                "available" => null,
            ],
            "email" => [
                "icon"      => "envelope",
                "title"     => "E-post",
                "route"     => "mailto:peder.tornberg@gmail.com",
                "available" => null,
            ]
        ]
    ]
];
