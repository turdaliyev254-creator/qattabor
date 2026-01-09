<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subcategory_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('location_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->boolean('is_popular')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->string('navigate_link')->nullable();
            $table->string('instagram')->nullable();
            $table->string('telegram')->nullable();
            $table->string('facebook')->nullable();
            $table->string('youtube')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->json('working_hours')->nullable();
            $table->decimal('rating', 3, 2)->default(0);
            $table->unsignedInteger('views_count')->default(0);
            $table->unsignedInteger('phone_clicks')->default(0);
            $table->unsignedInteger('website_clicks')->default(0);
            $table->unsignedInteger('social_clicks')->default(0);
            $table->timestamps();

            $table->index(['category_id', 'location_id']);
            $table->index(['subcategory_id', 'location_id']);
            $table->fullText(['name', 'description', 'address']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('places');
    }
};
