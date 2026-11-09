<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title_bs');
            $table->string('title_en');
            $table->string('kind_bs', 160);
            $table->string('kind_en', 160);
            $table->string('programme_bs', 160);
            $table->string('programme_en', 160);
            $table->text('summary_bs');
            $table->text('summary_en');
            $table->json('meta_bs');
            $table->json('meta_en');
            $table->string('project_status', 20)->default('active');
            $table->string('status', 20)->default('draft');
            $table->unsignedInteger('sort_order')->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['status', 'sort_order'], 'idx_projects_public');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
