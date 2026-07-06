<?php

namespace App\Filament\Resources\ProductCategories\Tables;

use App\Models\ProductCategory;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ProductCategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('category_image')
                    ->label(__('admin.table.product_category.image'))
                    ->collection(ProductCategory::ImageCollection),
                TextColumn::make('name')
                    ->label(__('admin.table.product_category.name'))
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('slug')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('products_count')
                    ->label(__('admin.table.product_category.product_count'))
                    ->counts('products')
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label(__('admin.table.product_category.active'))
                    ->boolean(),
                TextColumn::make('updated_at')
                    ->label(__('admin.table.product_category.updated'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label(__('admin.table.filters.active'))
                    ->trueLabel(__('admin.table.filters.active_true'))
                    ->falseLabel(__('admin.table.filters.active_false')),
            ])
            ->modifyQueryUsing(fn ($query) => $query->withCount('products'))
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
