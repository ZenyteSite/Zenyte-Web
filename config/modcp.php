<?php
/*
|--------------------------------------------------------------------------
| ModCP Configuration
|--------------------------------------------------------------------------
|
| Used to configure modcp specific settings
|
*/
return [
    'punishment_proof_bucket' => 'modcp/punishments/proof',
    'accepted_punishment_file_types' => [
        'jpeg',
        'jpg',
        'png',
        'gif',
        'mp4',
        'wav',
        'txt',
    ],
    'punishment_filters' => [
        'ban',
        'mute',
        'ip mute',
        'mac mute',
        'ip ban',
        'mac ban'
    ],
    'daily_osgp_donation_limits' => [ //Key is the group id, value is the daily amount in million that they're allowed to take
            6 => 400,
            7 => 400,
            20 => 400,
            4 => 400,
            12 => 400,
            11 => 400,
            19 => 400,
            25 => 400,
            24 => 400,
    ]
];