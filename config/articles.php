<?php

return [

    'cache_ttl_minutes' => env('ARTICLES_CACHE_TTL_MINUTES', 15),

    'no_image_url' => env('ARTICLES_NO_IMAGE_URL', config('app.url') . '/images/no-image.jpg'),

    'hours_to_go_back' => [

        'all_news' => (int) env('HOURS_TO_GO_BACK_ALL_NEWS', 8),

        'grouped' => (int) env('HOURS_TO_GO_BACK_GROUPED', 16),

        'provider' => (int) env('HOURS_TO_GO_BACK_PROVIDER', 24),

    ],

];
