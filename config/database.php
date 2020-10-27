<?php
/**
 * Config file for Database.
 *
 * Example for MySQL.
 *  "dsn" => "mysql:host=localhost;dbname=test;",
 *  "username" => "test",
 *  "password" => "test",
 *  "driver_options"  => [
 *      \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"
 *  ],
 *
 *  "dsn" => "sqlite::memory:",
 *  "dsn" => "sqlite:$path",
 *
 */
return [
    //"dsn"             => null,
    "dsn"             => "sqlite:" . ANAX_INSTALL_PATH . "/data/ctf/db/ctf.sqlite",
    "username"        => null,
    "password"        => null,
    "driver_options"  => null,
    "fetch_mode"      => \PDO::FETCH_OBJ,
    "table_prefix"    => null,
    "session_key"     => "Anax\Database",
    "emulate_prepares" => false,

    // True to be very verbose during development
    "verbose"         => null,

    // True to be verbose on connection failed
    "debug_connect"   => false,
];
