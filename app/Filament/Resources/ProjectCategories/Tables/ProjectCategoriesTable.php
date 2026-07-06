<?php

namespace App\Filament\Resources\ProjectCategories\Tables;

use App\Models\ProjectCategory;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ProjectCategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('category_image')
                    ->label(__('admin.table.project_category.image'))
                    ->collection(ProjectCategory::ImageCollection),
                TextColumn::make('name')
                    ->label(__('admin.table.project_category.name'))
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('slug')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('projects_count')
                    ->label(__('admin.table.project_category.project_count'))
                    ->counts('projects')
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label(__('admin.table.project_category.active'))
                    ->boolean(),
                TextColumn::make('updated_at')
                    ->label(__('admin.table.project_category.updated'))
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
            ->modifyQueryUsing(fn ($query) => $query->withCount('projects'))
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
