<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('type')->index();
            $table->json('name');
            $table->string('slug');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['type', 'slug']);
        });

        Schema::create('article_category', function (Blueprint $table) {
            $table->foreignId('article_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();

            $table->primary(['article_id', 'category_id']);
        });

        Schema::create('category_product', function (Blueprint $table) {
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();

            $table->primary(['category_id', 'product_id']);
        });

        $this->migrateLegacyCategories('articles', 'article', 'article_category', 'article_id');
        $this->migrateLegacyCategories('products', 'product', 'category_product', 'product_id');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_product');
        Schema::dropIfExists('article_category');
        Schema::dropIfExists('categories');
    }

    private function migrateLegacyCategories(string $table, string $type, string $pivotTable, string $foreignKey): void
    {
        if (! Schema::hasTable($table) || ! Schema::hasColumn($table, 'category')) {
            return;
        }

        DB::table($table)
            ->whereNotNull('category')
            ->orderBy('id')
            ->get(['id', 'category'])
            ->each(function (object $record) use ($type, $pivotTable, $foreignKey): void {
                $name = $this->translations((string) $record->category);
                $slug = Str::slug($name['id'] ?: $name['en'] ?: $name['zh']);

                $categoryId = DB::table('categories')->where([
                    'type' => $type,
                    'slug' => $slug,
                ])->value('id');

                if (! $categoryId) {
                    $categoryId = DB::table('categories')->insertGetId([
                        'type' => $type,
                        'name' => json_encode($name, JSON_THROW_ON_ERROR),
                        'slug' => $slug,
                        'is_active' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                DB::table($pivotTable)->insertOrIgnore([
                    $foreignKey => $record->id,
                    'category_id' => $categoryId,
                ]);
            });
    }

    /**
     * @return array<string, string>
     */
    private function translations(string $value): array
    {
        $decoded = json_decode($value, true);

        if (is_array($decoded)) {
            return [
                'id' => (string) ($decoded['id'] ?? ''),
                'en' => (string) ($decoded['en'] ?? $decoded['id'] ?? ''),
                'zh' => (string) ($decoded['zh'] ?? $decoded['id'] ?? ''),
            ];
        }

        return [
            'id' => $value,
            'en' => $value,
            'zh' => $value,
        ];
    }
};
