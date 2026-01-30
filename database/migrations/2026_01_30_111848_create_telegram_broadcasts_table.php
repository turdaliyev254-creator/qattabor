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
        Schema::create('telegram_broadcasts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->enum('media_type', ['photo', 'video', 'text'])->default('text');
            $table->string('media_file_id')->nullable(); // Telegram file_id for reuse
            $table->text('caption');
            $table->json('target_regions')->nullable(); // Array of region IDs or "all"
            $table->json('links')->nullable(); // Social media links
            $table->enum('status', ['draft', 'scheduled', 'sending', 'completed', 'failed'])->default('draft');
            $table->integer('sent_count')->default(0);
            $table->integer('failed_count')->default(0);
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telegram_broadcasts');
    }
};
