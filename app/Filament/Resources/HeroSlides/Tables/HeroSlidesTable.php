<?php

namespace App\Filament\Resources\HeroSlides\Tables;

use App\Models\HeroSlide;
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

class HeroSlidesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('hero_image')
                    ->label(__('admin.table.hero_slide.image'))
                    ->collection(HeroSlide::ImageCollection)
                    ->width(80)
                    ->height(40)
                    ->filterMediaUsing(function (Collection $media): Collection {
                        $locale = app()->getLocale();
                        $filtered = $media->filter(fn (Media $item): bool => $item->getCustomProperty('locale') === $locale);

                        if ($filtered->isNotEmpty()) {
                            return $filtered;
                        }

                        $fallback = $media->filter(fn (Media $item): bool => $item->getCustomProperty('locale') === 'id');

                        return $fallback->isNotEmpty() ? $fallback : $media;
                    }),
                TextColumn::make('label')
                    ->label(__('admin.table.hero_slide.label'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('title')
                    ->label(__('admin.table.hero_slide.title'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('subtitle')
                    ->label(__('admin.table.hero_slide.subtitle'))
                    ->limit(40)
                    ->wrap(),
                IconColumn::make('is_active')
                    ->label(__('admin.table.hero_slide.active'))
                    ->boolean(),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label(__('admin.table.hero_slide.status')),
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
