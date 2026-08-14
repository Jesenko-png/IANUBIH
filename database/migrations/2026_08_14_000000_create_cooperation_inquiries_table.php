<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cooperation_inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120);
            $table->string('email', 190);
            $table->string('organization', 190)->nullable();
            $table->string('partner_type', 30);
            $table->string('initiative_title', 190);
            $table->text('message');
            $table->string('locale', 2)->default('bs');
            $table->timestamp('viewed_at')->nullable();
            $table->foreignId('viewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['viewed_at', 'created_at'], 'idx_cooperation_inquiries_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cooperation_inquiries');
    }
};
