<?php

namespace Database\Seeders\Concerns;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

trait SeedsWithAssets
{
    private ?array $cachedAssetFiles = null;

    protected function resolveAssetPath(string $relativePath): ?string
    {
        $fullPath = database_path('seeders/assets/'.$relativePath);

        if (file_exists($fullPath)) {
            return $fullPath;
        }

        return $this->randomAssetPath();
    }

    protected function randomAssetPath(): ?string
    {
        $files = $this->allAssetFiles();

        if (empty($files)) {
            return null;
        }

        return $files[array_rand($files)];
    }

    protected function allAssetFiles(): array
    {
        if ($this->cachedAssetFiles !== null) {
            return $this->cachedAssetFiles;
        }

        $directory = database_path('seeders/assets');
        $files = [];

        if (! is_dir($directory)) {
            return $files;
        }

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS)
        );

        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $files[] = $file->getPathname();
            }
        }

        $this->cachedAssetFiles = $files;

        return $files;
    }
}
