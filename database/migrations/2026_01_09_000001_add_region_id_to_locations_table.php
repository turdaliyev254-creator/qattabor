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
        Schema::table('locations', function (Blueprint $table) {
            // Add foreign key to regions table
            $table->foreignId('region_id')->nullable()->after('slug')->constrained('regions')->nullOnDelete();
            
            // Keep the old region column for backward compatibility during migration
            // We'll remove it later after data migration
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->dropForeign(['region_id']);
            $table->dropColumn('region_id');
        });
    }
};
