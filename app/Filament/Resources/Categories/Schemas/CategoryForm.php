<?php

namespace App\Filament\Resources\Categories\Schemas;

use App\Models\Category;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Kategori')
                    ->schema([
                        Select::make('type')
                            ->label('Tipe')
                            ->options([
                                Category::TypeProduct => 'Produk',
                                Category::TypeArticle => 'Artikel',
                                Category::TypeProject => 'Project',
                            ])
                            ->required(),
                        TextInput::make('slug')
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('Kosongkan saat membuat kategori agar slug dibuat otomatis.'),
                        TextInput::make('name.id')
                            ->label('Name (ID)')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('name.en')
                            ->label('Name (EN)')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('name.zh')
                            ->label('Name (ZH)')
                            ->required()
                            ->maxLength(255),
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                    ])
                    ->columns(3),
            ]);
    }
}
