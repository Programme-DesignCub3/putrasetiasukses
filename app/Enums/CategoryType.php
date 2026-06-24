<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum CategoryType: string implements HasLabel
{
    case Product = 'product';
    case Article = 'article';
    case Project = 'project';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Product => 'Produk',
            self::Article => 'Artikel / News',
            self::Project => 'Project',
        };
    }
}
