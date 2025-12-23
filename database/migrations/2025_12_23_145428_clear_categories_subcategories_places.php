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
        // Disable foreign key checks based on database driver
        $driver = \DB::getDriverName();
        
        if ($driver === 'mysql') {
            \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        } elseif ($driver === 'sqlite') {
            \DB::statement('PRAGMA foreign_keys = OFF;');
        }
        
        // Clear all tables
        \DB::table('saved_places')->truncate();
        \DB::table('places')->truncate();
        \DB::table('subcategories')->truncate();
        \DB::table('categories')->truncate();
        
        // Re-enable foreign key checks based on database driver
        if ($driver === 'mysql') {
            \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        } elseif ($driver === 'sqlite') {
            \DB::statement('PRAGMA foreign_keys = ON;');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No rollback needed for truncate operations
    }
};
