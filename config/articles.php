<?php

return [

    'cache_ttl_minutes' => env('ARTICLES_CACHE_TTL_MINUTES', 15),

    'no_image_url' => env('ARTICLES_NO_IMAGE_URL', config('app.url') . '/images/no-image.jpg'),

    'hours_to_go_back' => [

        'all_news' => (int) env('ARTICLES_HOURS_TO_GO_BACK', 8),

    ],

];
