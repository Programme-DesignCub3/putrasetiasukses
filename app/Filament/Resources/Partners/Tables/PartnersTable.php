<?php

namespace App\Filament\Resources\Partners\Tables;

use App\Models\Partner;
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

class PartnersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('logo')
                    ->label('Logo')
                    ->collection(Partner::LogoCollection)
                    ->square()
                    ->width(64)
                    ->height(64)
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
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Status'),
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
            ])
            ->searchPlaceholder('Cari partner...');
    }
}
