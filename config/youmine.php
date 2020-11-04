<?php

return [
    'vk' => [
        'redirect' => env('VK_REDIRECT', 'https://youmine.ru/login')
    ],
    'sub' => [
        'price' => [
            'month' => env('SUB_PRICE_MONTH', 200),
            'lifetime' => env('SUB_PRICE_LIFETIME', 1000)
        ]
    ]
];