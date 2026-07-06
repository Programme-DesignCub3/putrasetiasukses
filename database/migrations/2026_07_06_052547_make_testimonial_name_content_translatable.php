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
            DB::statement('UPDATE testimonials SET name = JSON_OBJECT("id", name, "en", name, "zh", name) WHERE JSON_VALID(name) = 0 OR name IS NULL');
            DB::statement('UPDATE testimonials SET content = JSON_OBJECT("id", content, "en", content, "zh", content) WHERE JSON_VALID(content) = 0 OR content IS NULL');
        }

        Schema::table('testimonials', function (Blueprint $table) {
            $table->json('name')->change();
            $table->json('content')->change();
        });
    }

    public function down(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->string('name')->change();
            $table->text('content')->change();
        });
    }
};
