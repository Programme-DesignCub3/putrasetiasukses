<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['article_categories', 'product_categories', 'project_categories'] as $table) {
            if (! Schema::hasTable($table)) {
                continue;
            }

            Schema::table($table, function (Blueprint $table): void {
                $table->json('description')->nullable()->after('name');
                $table->string('image_url')->nullable()->after('slug');
                $table->json('gallery_images')->nullable()->after('image_url');
            });
        }
    }

    public function down(): void
    {
        foreach (['article_categories', 'product_categories', 'project_categories'] as $table) {
            if (! Schema::hasTable($table)) {
                continue;
            }

            Schema::table($table, function (Blueprint $table): void {
                $table->dropColumn([
                    'description',
                    'image_url',
                    'gallery_images',
                ]);
            });
        }
    }
};
