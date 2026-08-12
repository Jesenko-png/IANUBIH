<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('slug')->unique();
            $table->string('title_bs');
            $table->string('title_en');
            $table->string('category_bs', 100);
            $table->string('category_en', 100);
            $table->text('excerpt_bs');
            $table->text('excerpt_en');
            $table->longText('body_bs');
            $table->longText('body_en');
            $table->string('image_path');
            $table->string('image_alt_bs')->nullable();
            $table->string('image_alt_en')->nullable();
            $table->string('status', 20)->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'published_at'], 'idx_news_posts_publication');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_posts');
    }
};
