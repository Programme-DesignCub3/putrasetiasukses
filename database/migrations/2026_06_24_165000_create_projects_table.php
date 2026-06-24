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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('category');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('client')->nullable();
            $table->string('location');
            $table->string('main_image_url');
            $table->json('gallery_images')->nullable();
            $table->date('completion_date')->nullable();
            $table->boolean('is_published')->default(true);
            $table->unsignedInteger('order_column')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
