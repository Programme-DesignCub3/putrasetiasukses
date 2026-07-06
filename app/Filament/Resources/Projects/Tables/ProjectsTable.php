<?php

namespace App\Filament\Resources\Projects\Tables;

use App\Models\Project;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ProjectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('main_image')
                    ->label(__('admin.table.project.image'))
                    ->collection(Project::MainImageCollection),
                TextColumn::make('name')
                    ->label(__('admin.table.project.name'))
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('client')
                    ->label(__('admin.table.project.client'))
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('category_names')
                    ->label(__('admin.table.project.category'))
                    ->badge()
                    ->searchable(),
                TextColumn::make('completion_date')
                    ->label(__('admin.table.project.completed'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                IconColumn::make('is_published')
                    ->label(__('admin.table.project.published'))
                    ->boolean(),
                TextColumn::make('updated_at')
                    ->label(__('admin.table.project.updated'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                TernaryFilter::make('is_published')
                    ->label(__('admin.table.filters.published')),
            ])
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
