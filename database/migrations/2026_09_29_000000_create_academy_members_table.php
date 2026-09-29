<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('academy_members', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name', 160);
            $table->string('academic_title', 120)->nullable();
            $table->string('category_bs', 160)->nullable();
            $table->string('category_en', 160)->nullable();
            $table->string('position_bs', 160)->nullable();
            $table->string('position_en', 160)->nullable();
            $table->string('field_bs', 180);
            $table->string('field_en', 180);
            $table->string('institution_bs', 180)->nullable();
            $table->string('institution_en', 180)->nullable();
            $table->string('country_bs', 100)->nullable();
            $table->string('country_en', 100)->nullable();
            $table->text('bio_bs')->nullable();
            $table->text('bio_en')->nullable();
            $table->string('email', 190)->nullable();
            $table->string('website_url', 500)->nullable();
            $table->string('photo_path')->nullable();
            $table->string('status', 20)->default('draft');
            $table->unsignedInteger('sort_order')->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['status', 'sort_order', 'name'], 'idx_academy_members_public');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('academy_members');
    }
};
