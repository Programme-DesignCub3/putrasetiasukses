<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::connection()->getDriverName() === 'mysql') {
            DB::statement('UPDATE hero_slides SET label = JSON_OBJECT("id", label, "en", label, "zh", label) WHERE JSON_VALID(label) = 0 OR label IS NULL');
            DB::statement('UPDATE hero_slides SET title = JSON_OBJECT("id", title, "en", title, "zh", title) WHERE JSON_VALID(title) = 0 OR title IS NULL');
            DB::statement('UPDATE hero_slides SET subtitle = JSON_OBJECT("id", subtitle, "en", subtitle, "zh", subtitle) WHERE JSON_VALID(subtitle) = 0 OR subtitle IS NULL');
        }

        Schema::table('hero_slides', function (Blueprint $table) {
            $table->json('label')->change();
            $table->json('title')->change();
            $table->json('subtitle')->change();
        });
    }

    public function down(): void
    {
        Schema::table('hero_slides', function (Blueprint $table) {
            $table->string('label', 255)->change();
            $table->string('title', 255)->change();
            $table->string('subtitle', 255)->change();
        });
    }
};
