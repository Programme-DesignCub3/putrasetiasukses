<?php

declare(strict_types=1);

// config for Awcodes/Botly
return [
    'defaults' => [
        'rules' => [],
        'sitemaps' => [],
        'ai_crawlers' => [],
    ],
    'persistent_rules' => [
        [
            'user_agent' => '*',
            'directive' => 'disallow',
            'path' => '/admin',
        ],
    ],
];
