<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('academy_pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 80);
            $table->string('locale', 2);
            $table->json('content');
            $table->timestamps();
            $table->unique(['slug', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('academy_pages');
    }
};
