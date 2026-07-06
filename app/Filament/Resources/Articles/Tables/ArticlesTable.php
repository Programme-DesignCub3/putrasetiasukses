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
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ArticlesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('article_image')
                    ->label('Gambar')
                    ->collection(Article::ImageCollection)
                    ->filterMediaUsing(function (Collection $media): Collection {
                        $locale = app()->getLocale();
                        $filtered = $media->filter(fn (Media $item): bool => $item->getCustomProperty('locale') === $locale);

                        if ($filtered->isNotEmpty()) {
                            return $filtered;
                        }

                        return $media->filter(fn (Media $item): bool => $item->getCustomProperty('locale') === 'id');
                    }),
                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('category_names')
                    ->label('Kategori')
                    ->badge(),
                IconColumn::make('is_featured')
                    ->label('Unggulan')
                    ->boolean(),
                IconColumn::make('is_published')
                    ->label('Published')
                    ->boolean(),
                TextColumn::make('published_at')
                    ->label('Dipublikasi')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                TernaryFilter::make('is_published')
                    ->label('Published')
                    ->trueLabel('Published')
                    ->falseLabel('Draft'),
                TernaryFilter::make('is_featured')
                    ->label('Unggulan')
                    ->trueLabel('Unggulan')
                    ->falseLabel('Biasa'),
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
