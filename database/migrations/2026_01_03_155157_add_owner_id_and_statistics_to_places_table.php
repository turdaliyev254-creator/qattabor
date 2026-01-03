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
        Schema::table('places', function (Blueprint $table) {
            $table->foreignId('owner_id')->nullable()->after('id')->constrained('users')->onDelete('set null');
            $table->integer('views_count')->default(0)->after('rating');
            $table->integer('phone_clicks')->default(0)->after('views_count');
            $table->integer('website_clicks')->default(0)->after('phone_clicks');
            $table->integer('social_clicks')->default(0)->after('website_clicks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('places', function (Blueprint $table) {
            $table->dropForeign(['owner_id']);
            $table->dropColumn(['owner_id', 'views_count', 'phone_clicks', 'website_clicks', 'social_clicks']);
        });
    }
};
