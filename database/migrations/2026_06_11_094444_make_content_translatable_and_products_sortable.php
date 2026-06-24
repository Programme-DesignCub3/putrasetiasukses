<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('site_settings');

        $this->makeProductsTranslatable();
        $this->makeArticlesTranslatable();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $this->makeProductsPlain();
        $this->makeArticlesPlain();
        $this->createSiteSettingsTable();
    }

    private function makeProductsTranslatable(): void
    {
        if (! Schema::hasTable('products') || Schema::hasColumn('products', 'category_translations')) {
            return;
        }

        Schema::table('products', function (Blueprint $table): void {
            $table->json('category_translations')->nullable()->after('category');
            $table->json('name_translations')->nullable()->after('name');
            $table->json('description_translations')->nullable()->after('description');
            $table->unsignedInteger('order_column')->nullable()->index()->after('is_published');
        });

        DB::table('products')
            ->orderBy('id')
            ->get()
            ->each(function (object $product, int $index): void {
                DB::table('products')
                    ->where('id', $product->id)
                    ->update([
                        'category_translations' => $this->translations($product->category),
                        'name_translations' => $this->translations($product->name),
                        'description_translations' => $this->translations($product->description),
                        'order_column' => $index + 1,
                    ]);
            });

        Schema::table('products', function (Blueprint $table): void {
            $table->dropColumn(['category', 'name', 'description']);
        });

        Schema::table('products', function (Blueprint $table): void {
            $table->renameColumn('category_translations', 'category');
            $table->renameColumn('name_translations', 'name');
            $table->renameColumn('description_translations', 'description');
        });
    }

    private function makeArticlesTranslatable(): void
    {
        if (! Schema::hasTable('articles') || Schema::hasColumn('articles', 'category_translations')) {
            return;
        }

        Schema::table('articles', function (Blueprint $table): void {
            $table->json('category_translations')->nullable()->after('category');
            $table->json('title_translations')->nullable()->after('title');
            $table->json('excerpt_translations')->nullable()->after('excerpt');
            $table->json('body_translations')->nullable()->after('body');
        });

        DB::table('articles')
            ->orderBy('id')
            ->get()
            ->each(function (object $article): void {
                DB::table('articles')
                    ->where('id', $article->id)
                    ->update([
                        'category_translations' => $this->translations($article->category),
                        'title_translations' => $this->translations($article->title),
                        'excerpt_translations' => $this->translations($article->excerpt),
                        'body_translations' => $this->translations($article->body),
                    ]);
            });

        Schema::table('articles', function (Blueprint $table): void {
            $table->dropColumn(['category', 'title', 'excerpt', 'body']);
        });

        Schema::table('articles', function (Blueprint $table): void {
            $table->renameColumn('category_translations', 'category');
            $table->renameColumn('title_translations', 'title');
            $table->renameColumn('excerpt_translations', 'excerpt');
            $table->renameColumn('body_translations', 'body');
        });
    }

    private function makeProductsPlain(): void
    {
        if (! Schema::hasTable('products') || Schema::hasColumn('products', 'category_plain')) {
            return;
        }

        Schema::table('products', function (Blueprint $table): void {
            $table->string('category_plain')->nullable()->after('category');
            $table->string('name_plain')->nullable()->after('name');
            $table->text('description_plain')->nullable()->after('description');
        });

        DB::table('products')
            ->get()
            ->each(function (object $product): void {
                DB::table('products')
                    ->where('id', $product->id)
                    ->update([
                        'category_plain' => $this->plain($product->category),
                        'name_plain' => $this->plain($product->name),
                        'description_plain' => $this->plain($product->description),
                    ]);
            });

        Schema::table('products', function (Blueprint $table): void {
            $table->dropColumn(['category', 'name', 'description', 'order_column']);
        });

        Schema::table('products', function (Blueprint $table): void {
            $table->renameColumn('category_plain', 'category');
            $table->renameColumn('name_plain', 'name');
            $table->renameColumn('description_plain', 'description');
        });
    }

    private function makeArticlesPlain(): void
    {
        if (! Schema::hasTable('articles') || Schema::hasColumn('articles', 'category_plain')) {
            return;
        }

        Schema::table('articles', function (Blueprint $table): void {
            $table->string('category_plain')->nullable()->after('category');
            $table->string('title_plain')->nullable()->after('title');
            $table->text('excerpt_plain')->nullable()->after('excerpt');
            $table->longText('body_plain')->nullable()->after('body');
        });

        DB::table('articles')
            ->get()
            ->each(function (object $article): void {
                DB::table('articles')
                    ->where('id', $article->id)
                    ->update([
                        'category_plain' => $this->plain($article->category),
                        'title_plain' => $this->plain($article->title),
                        'excerpt_plain' => $this->plain($article->excerpt),
                        'body_plain' => $this->plain($article->body),
                    ]);
            });

        Schema::table('articles', function (Blueprint $table): void {
            $table->dropColumn(['category', 'title', 'excerpt', 'body']);
        });

        Schema::table('articles', function (Blueprint $table): void {
            $table->renameColumn('category_plain', 'category');
            $table->renameColumn('title_plain', 'title');
            $table->renameColumn('excerpt_plain', 'excerpt');
            $table->renameColumn('body_plain', 'body');
        });
    }

    private function createSiteSettingsTable(): void
    {
        if (Schema::hasTable('site_settings')) {
            return;
        }

        Schema::create('site_settings', function (Blueprint $table): void {
            $table->id();
            $table->string('company_name');
            $table->string('tagline');
            $table->string('website_url');
            $table->string('email');
            $table->string('whatsapp_number');
            $table->json('phones');
            $table->text('head_office_address');
            $table->text('warehouse_address');
            $table->timestamps();
        });
    }

    private function translations(?string $value): string
    {
        return json_encode([
            'id' => $value,
            'en' => $value,
            'zh' => $value,
        ], JSON_THROW_ON_ERROR);
    }

    private function plain(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $decoded = json_decode($value, true);

        if (! is_array($decoded)) {
            return $value;
        }

        return $decoded['id'] ?? $decoded['en'] ?? $decoded['zh'] ?? collect($decoded)->first();
    }
};
