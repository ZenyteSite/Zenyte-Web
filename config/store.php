<?php

/*
|--------------------------------------------------------------------------
| Store Configuration
|--------------------------------------------------------------------------
|
| Used to configure store specific settings.
|
*/

return [
    'osgp_rate' => env('OSGP_RATE', 0.60),
    'sale' => [
        'osgp' => [
            'enabled' => true, //If this is false, the below value will be ignored.
            'amount' => '15' //An additional percentage of the normal credit amount. I.e. 15 would be 15% extra credits.
        ],
        'crypto' => [
            'enabled' => true, //If this is false, the below value will be ignored.
            'amount' => '25' //An additional percentage of the normal credit amount. I.e. 15 would be 15% extra credits.
        ],
        'paypal' => [
            'enabled' => false, //If this is false, the below value will be ignored.
            'amount' => '15' //An additional percentage of the normal credit amount. I.e. 15 would be 15% extra credits.
        ],
    ],
    'osgp_webhook' => 'https://discordapp.com/api/webhooks/739481628971237446/se5dDP_Sb2FwUp7KwBEdoVUXD2ELsyblEgkDOuVULV7QqcUC_pnr3FdGiK5JeRDmnfpN', //Normally https://discordapp.com/api/webhooks/708029649770250353/pkztHDlKkRw-GSlDjft3wff4vzfHZv9O_QtyWDHIUpvUYmtUimrZ5Lx88tiU7RiL6VdZ
    'product_images_bucket' => 'store/products',
    'credit_images_bucket' => 'store/credits',
    'no_image_found_url' => 'store/No-Image-Found-400x264.png',
];