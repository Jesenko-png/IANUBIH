<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['secondary_image_path', 'secondary_image_alt_bs', 'secondary_image_alt_en'] as $column) {
            if (! Schema::hasColumn('news_posts', $column)) {
                Schema::table('news_posts', function (Blueprint $table) use ($column) {
                    $table->string($column)->nullable();
                });
            }
        }
    }

    public function down(): void
    {
        foreach (['secondary_image_path', 'secondary_image_alt_bs', 'secondary_image_alt_en'] as $column) {
            if (Schema::hasColumn('news_posts', $column)) {
                Schema::table('news_posts', function (Blueprint $table) use ($column) {
                    $table->dropColumn($column);
                });
            }
        }
    }
};
