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
            $table->string('instagram')->nullable()->after('website');
            $table->string('telegram')->nullable()->after('instagram');
            $table->string('facebook')->nullable()->after('telegram');
            $table->string('youtube')->nullable()->after('facebook');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('places', function (Blueprint $table) {
            $table->dropColumn(['instagram', 'telegram', 'facebook', 'youtube']);
        });
    }
};
