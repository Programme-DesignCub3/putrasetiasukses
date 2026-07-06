<?php

namespace App\Traits;

use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait WithLocaleImages
{
    public function getLocaleImageUrl(string $collectionName, ?string $defaultUrl = null): string
    {
        $locale = app()->getLocale();

        $media = $this->getMedia($collectionName);

        $localeMedia = $media->first(fn (Media $media): bool => $media->getCustomProperty('locale') === $locale)
            ?? $media->first(fn (Media $media): bool => $media->getCustomProperty('locale') === 'id')
            ?? $media->first();

        return $localeMedia?->getUrl() ?? (string) $defaultUrl;
    }

    public function getLocaleGalleryImages(string $collectionName): array
    {
        $locale = app()->getLocale();
        $media = $this->getMedia($collectionName);

        if ($media->isEmpty()) {
            return [];
        }

        $localeMedia = $media->filter(fn (Media $media): bool => $media->getCustomProperty('locale') === $locale);

        if ($localeMedia->isEmpty()) {
            $localeMedia = $media->filter(fn (Media $media): bool => $media->getCustomProperty('locale') === 'id');
        }

        if ($localeMedia->isEmpty()) {
            $localeMedia = $media;
        }

        return $localeMedia
            ->map(fn (Media $media): array => [
                'url' => $media->getUrl(),
                'alt' => $media->name,
            ])
            ->values()
            ->all();
    }
}
