<?php

namespace App\Filament\Resources\ArticleCategories\Tables;

use App\Models\ArticleCategory;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ArticleCategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('category_image')
                    ->label(__('admin.table.article_category.image'))
                    ->collection(ArticleCategory::ImageCollection),
                TextColumn::make('name')
                    ->label(__('admin.table.article_category.name'))
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('slug')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('articles_count')
                    ->label(__('admin.table.article_category.article_count'))
                    ->counts('articles')
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label(__('admin.table.article_category.active'))
                    ->boolean(),
                TextColumn::make('updated_at')
                    ->label(__('admin.table.article_category.updated'))
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
            ->modifyQueryUsing(fn ($query) => $query->withCount('articles'))
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
