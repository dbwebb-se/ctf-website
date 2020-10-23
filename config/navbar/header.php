<?php
/**
 * Supply the basis for the navbar as an array.
 */
return [
    // Use for styling the menu
    "wrapper" => null,
    "class" => "my-navbar rm-default rm-desktop",

    // Here comes the menu items
    "items" => [
        [
            "text" => "Home",
            "url" => "",
            "title" => "The home page.",
        ],
        [
            "text" => "About",
            "url" => "about",
            "title" => "About this website.",
        ],
        [
            "text" => "Dev",
            "url" => "dev",
            "title" => "Anax development utilities",
        ],
    ],
];
