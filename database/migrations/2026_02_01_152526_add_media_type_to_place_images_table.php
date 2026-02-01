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
        Schema::table('place_images', function (Blueprint $table) {
            $table->string('media_type')->default('image')->after('image_path'); // image or video
            $table->string('thumbnail_path')->nullable()->after('media_type'); // thumbnail for videos
            $table->integer('duration')->nullable()->after('thumbnail_path'); // video duration in seconds
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('place_images', function (Blueprint $table) {
            $table->dropColumn(['media_type', 'thumbnail_path', 'duration']);
        });
    }
};
