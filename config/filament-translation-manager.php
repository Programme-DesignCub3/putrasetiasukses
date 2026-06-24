<?php

use Filament\Support\Icons\Heroicon;

return [
    'locales' => ['id', 'en', 'zh'],
    'gate' => null,
    'ignore_groups' => [
        'auth',
        'pagination',
        'passwords',
        'validation',
    ],
    'navigation_sort' => 95,
    'navigation_group' => 'Website',
    'prefix_tabs' => [
        'site' => 'Website',
        'filament' => 'Filament',
    ],
    'widget' => [
        'enabled' => false,
        'gate' => null,
        'sort' => null,
    ],
    'navigation_icon' => Heroicon::OutlinedLanguage,
];
