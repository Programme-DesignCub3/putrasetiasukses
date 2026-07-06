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
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProjectCategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('category_image')
                    ->label('Gambar')
                    ->collection(ProjectCategory::ImageCollection)
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
                TextColumn::make('slug')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('projects_count')
                    ->label('Project')
                    ->counts('projects')
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
                TextColumn::make('updated_at')
                    ->label('Diubah')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Active')
                    ->trueLabel('Active')
                    ->falseLabel('Inactive'),
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
