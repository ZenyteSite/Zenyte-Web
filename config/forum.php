<?php
/*
|--------------------------------------------------------------------------
| Forum Configuration
|--------------------------------------------------------------------------
|
| Used to enable and configure the forum bridge.
| Also used for forum specific integrations and services
|
*/
return [
    'FORUM_PATH' => 'C:\/wamp64\/www\/community\/',
    'FORUM_LINK' => 'http://localhost/forums/index.php?',
    'FORUM_ASSETS_LINK' => 'http://localhost/forums/uploads',
    'FORUM_REGISTER_LINK' => 'http://localhost/forums/index.php?/register',
    'FORUM_LOGIN_LINK' => 'http://localhost/forums/index.php?/login',
    'HOMEPAGE_BOARD' => 2, //Normally 9
    'HOMEPAGE_TOPIC_LIMIT' => 5, //Normally 5
    'ENABLE_SEO' => 'false',
    'ranks' => [
        'Moderator' => [
            6 => 'Moderator',
            7 => 'Forum Moderator',
            20 => 'Senior Moderator'
        ],
        'Administrator' => [
            4 => 'Administrator',
            12 => 'Administrator',
            11 => 'Developer',
            19 => 'Web Developer',
            25 => 'Financial Officer',
            24 => 'Manager'
        ],
        'Owner' => [
            'Harry',
            'Corey',
            'Kris',
            'Tommeh',
            'Noele',
            'Chris',
        ]
    ],
];
