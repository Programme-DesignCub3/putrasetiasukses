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

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('main_image')
                    ->label(__('admin.table.product.image'))
                    ->collection(Product::MainImageCollection),
                TextColumn::make('name')
                    ->label(__('admin.table.product.name'))
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('category_names')
                    ->label(__('admin.table.product.category'))
                    ->badge(),
                IconColumn::make('is_published')
                    ->label(__('admin.table.product.published'))
                    ->boolean(),
                TextColumn::make('updated_at')
                    ->label(__('admin.table.product.updated'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                TernaryFilter::make('is_published')
                    ->label(__('admin.table.filters.published'))
                    ->trueLabel(__('admin.table.filters.published_true'))
                    ->falseLabel(__('admin.table.filters.published_false')),
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
