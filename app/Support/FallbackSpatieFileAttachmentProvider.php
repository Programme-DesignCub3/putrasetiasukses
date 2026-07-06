<?php

namespace App\Support;

use Filament\Forms\Components\RichEditor\FileAttachmentProviders\SpatieMediaLibraryFileAttachmentProvider;
use Illuminate\Support\Facades\Storage;
use Throwable;

class FallbackSpatieFileAttachmentProvider extends SpatieMediaLibraryFileAttachmentProvider
{
    public function getFileAttachmentUrl(mixed $file): ?string
    {
        $url = parent::getFileAttachmentUrl($file);

        if ($url !== null) {
            return $url;
        }

        try {
            $storage = Storage::disk(config('filament.default_filesystem_disk'));
            if ($storage->exists($file)) {
                return $storage->url($file);
            }
        } catch (Throwable) {
            return null;
        }

        return null;
    }

    public function getDefaultFileAttachmentVisibility(): ?string
    {
        return 'public';
    }
}
