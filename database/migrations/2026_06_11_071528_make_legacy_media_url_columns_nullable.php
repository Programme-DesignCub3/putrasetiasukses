<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('about_pages', function (Blueprint $table) {
            $table->string('hero_image_url')->nullable()->change();
            $table->string('intro_image_url')->nullable()->change();
        });

        Schema::table('articles', function (Blueprint $table) {
            $table->string('image_url')->nullable()->change();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->string('main_image_url')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('about_pages', function (Blueprint $table) {
            $table->string('hero_image_url')->nullable(false)->change();
            $table->string('intro_image_url')->nullable(false)->change();
        });

        Schema::table('articles', function (Blueprint $table) {
            $table->string('image_url')->nullable(false)->change();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->string('main_image_url')->nullable(false)->change();
        });
    }
};
