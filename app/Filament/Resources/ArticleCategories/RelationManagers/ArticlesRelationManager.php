<?php

namespace App\Filament\Resources\ArticleCategories\RelationManagers;

use App\Models\Article;
use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ArticlesRelationManager extends RelationManager
{
    protected static string $relationship = 'articles';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitle(fn (Article $record): string => $record->title)
            ->columns([
                TextColumn::make('title')
                    ->label(__('admin.table.relation_manager.article.title'))
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('author')
                    ->label(__('admin.table.relation_manager.article.author'))
                    ->searchable(),
                TextColumn::make('published_at')
                    ->label(__('admin.table.relation_manager.article.published'))
                    ->dateTime()
                    ->sortable(),
                IconColumn::make('is_published')
                    ->label(__('admin.table.relation_manager.article.published_short'))
                    ->boolean(),
            ])
            ->headerActions([
                AttachAction::make()
                    ->recordTitle(fn (Article $record): string => $record->title)
                    ->preloadRecordSelect(),
            ])
            ->actions([
                EditAction::make(),
                DetachAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                ]),
            ]);
    }
}
