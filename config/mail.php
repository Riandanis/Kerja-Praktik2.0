<?php

return [
    'driver' => env('MAIL_DRIVER', 'smtp'),


    'host' => env('MAIL_HOST', 'smtp.gmail.com'),
    'port' => env('MAIL_PORT', 587),

    'from' => [
        'address' => "dimas0308@gmail.com",
        'name' => "dimas hirda",
    ],
    'encryption' => env('MAIL_ENCRYPTION', 'tls'),


    'username' => 'dimas0308@gmail.com',

    'password' => 'inadewi4',


    'sendmail' => '/usr/sbin/sendmail -bs',

    'markdown' => [
        'theme' => 'default',

        'paths' => [
            resource_path('views/vendor/mail'),
        ],
    ],

];
