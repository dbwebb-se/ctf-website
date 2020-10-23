<?php
/**
 * Supply the basis for the navbar as an array.
 */
return [
    // Use for styling the menu
    "id" => "rm-menu",
    "wrapper" => null,
    "class" => "rm-default rm-mobile",

    // Here comes the menu items
    "items" => [
        [
            "text" => "Home",
            "url" => "",
            "title" => "The home page.",
        ],
        [
            "text" => "CTF",
            "url" => "ctf",
            "title" => "Choose and work with the CTFs.",
        ],
        [
            "text" => "About",
            "url" => "about",
            "title" => "About this website.",
        ],
    ],
];
