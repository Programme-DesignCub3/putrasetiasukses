<?php

namespace App\Filament\Resources\Products\Tables;

use App\Models\Product;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('main_image')
                    ->label('Gambar')
                    ->collection(Product::MainImageCollection)
                    ->filterMediaUsing(function (Collection $media): Collection {
                        $locale = app()->getLocale();
                        $filtered = $media->filter(fn (Media $item): bool => $item->getCustomProperty('locale') === $locale);

                        if ($filtered->isNotEmpty()) {
                            return $filtered;
                        }

                        return $media->filter(fn (Media $item): bool => $item->getCustomProperty('locale') === 'id');
                    }),
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('category_names')
                    ->label('Kategori')
                    ->badge(),
                IconColumn::make('is_published')
                    ->label('Published')
                    ->boolean(),
                TextColumn::make('updated_at')
                    ->label('Diubah')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                TernaryFilter::make('is_published')
                    ->label('Published')
                    ->trueLabel('Published')
                    ->falseLabel('Draft'),
            ])
            ->modifyQueryUsing(fn ($query) => $query->with('categories'))
            ->defaultSort('order_column')
            ->reorderable('order_column')
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
