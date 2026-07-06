<?php

namespace App\Filament\Resources\Articles\Tables;

use App\Models\Article;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ArticlesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('article_image')
                    ->label(__('admin.table.article.image'))
                    ->collection(Article::ImageCollection),
                TextColumn::make('title')
                    ->label(__('admin.table.article.title'))
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('category_names')
                    ->label(__('admin.table.article.category'))
                    ->badge(),
                IconColumn::make('is_featured')
                    ->label(__('admin.table.article.featured'))
                    ->boolean(),
                IconColumn::make('is_published')
                    ->label(__('admin.table.article.published'))
                    ->boolean(),
                TextColumn::make('published_at')
                    ->label(__('admin.table.article.published_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                TernaryFilter::make('is_published')
                    ->label(__('admin.table.filters.published'))
                    ->trueLabel(__('admin.table.filters.published_true'))
                    ->falseLabel(__('admin.table.filters.published_false')),
                TernaryFilter::make('is_featured')
                    ->label(__('admin.table.filters.featured'))
                    ->trueLabel(__('admin.table.filters.featured_true'))
                    ->falseLabel(__('admin.table.filters.featured_false')),
            ])
            ->modifyQueryUsing(fn ($query) => $query->with('categories'))
            ->defaultSort('published_at', 'desc')
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
