<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('categories') || Schema::hasColumn('categories', 'order_column')) {
            return;
        }

        Schema::table('categories', function (Blueprint $table): void {
            $table->unsignedInteger('order_column')->nullable()->after('is_active')->index();
        });

        DB::table('categories')
            ->select('type')
            ->distinct()
            ->pluck('type')
            ->each(function (string $type): void {
                DB::table('categories')
                    ->where('type', $type)
                    ->orderBy('id')
                    ->pluck('id')
                    ->each(function (int $id, int $index): void {
                        DB::table('categories')
                            ->where('id', $id)
                            ->update(['order_column' => $index + 1]);
                    });
            });
    }

    public function down(): void
    {
        if (! Schema::hasTable('categories') || ! Schema::hasColumn('categories', 'order_column')) {
            return;
        }

        Schema::table('categories', function (Blueprint $table): void {
            $table->dropIndex(['order_column']);
            $table->dropColumn('order_column');
        });
    }
};
