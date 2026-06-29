<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['article_categories', 'product_categories', 'project_categories'] as $table) {
            if (! Schema::hasTable($table) || Schema::hasColumn($table, 'order_column')) {
                continue;
            }

            Schema::table($table, function (Blueprint $table): void {
                $table->unsignedInteger('order_column')->nullable()->after('is_active')->index();
            });
        }
    }

    public function down(): void
    {
        foreach (['article_categories', 'product_categories', 'project_categories'] as $table) {
            if (! Schema::hasTable($table) || ! Schema::hasColumn($table, 'order_column')) {
                continue;
            }

            Schema::table($table, function (Blueprint $table): void {
                $table->dropIndex(['order_column']);
                $table->dropColumn('order_column');
            });
        }
    }
};
