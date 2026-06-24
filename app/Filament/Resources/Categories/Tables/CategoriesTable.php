<?php

namespace App\Filament\Resources\Categories\Tables;

use App\Models\Category;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('category_image')
                    ->label('Image')
                    ->collection(Category::ImageCollection),
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),
                TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        Category::TypeProduct => 'Produk',
                        Category::TypeArticle => 'Artikel / News',
                        Category::TypeProject => 'Project',
                        default => $state,
                    })
                    ->searchable(),
                TextColumn::make('slug')
                    ->searchable(),
                TextColumn::make('articles_count')
                    ->label('Artikel')
                    ->counts('articles')
                    ->sortable(),
                TextColumn::make('products_count')
                    ->label('Produk')
                    ->counts('products')
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Tipe')
                    ->options([
                        Category::TypeProduct => 'Produk',
                        Category::TypeArticle => 'Artikel / News',
                        Category::TypeProject => 'Project',
                    ]),
            ])
            ->modifyQueryUsing(fn ($query) => $query->withCount(['articles', 'products']))
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
