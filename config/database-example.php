<?php

return [
    "dsn"             => "mysql:host=XXXXXXX;port=3306;dbname=XXXXX;",
    "username"        => "XXXXXXXXX",
    "password"        => "XXXXXXXXX",
    "driver_options"  => [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"],
    "fetch_mode"      => \PDO::FETCH_OBJ,
    "table_prefix"    => null,
    "session_key"     => "Anax\Database",
    // True to be very verbose during development
    "verbose"         => false,
    // True to be verbose on connection failed
    "debug_connect"   => false,
];
