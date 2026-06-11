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
        Schema::create('about_pages', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Tentang Kami');
            $table->string('hero_image_url');
            $table->string('intro_image_url');
            $table->text('intro_text')->nullable();
            $table->string('vision_title')->default('Visi');
            $table->text('vision_body');
            $table->string('mission_title')->default('Misi');
            $table->text('mission_body');
            $table->json('gallery_images')->nullable();
            $table->string('video_title')->default('Video');
            $table->string('video_url')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_pages');
    }
};
