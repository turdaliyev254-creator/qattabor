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
        Schema::table('regions', function (Blueprint $table) {
            $table->decimal('center_latitude', 10, 8)->nullable()->after('is_active');
            $table->decimal('center_longitude', 11, 8)->nullable()->after('center_latitude');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('regions', function (Blueprint $table) {
            $table->dropColumn(['center_latitude', 'center_longitude']);
        });
    }
};
