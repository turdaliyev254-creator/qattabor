<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * This migration adds database indexes to improve search performance.
     * These indexes speed up LIKE queries used in the search functionality.
     */
    public function up(): void
    {
        // Use raw SQL to add indexes if they don't exist
        $connection = Schema::getConnection();
        $database = $connection->getDatabaseName();
        
        // Helper function to check if index exists
        $indexExists = function($table, $index) use ($connection, $database) {
            $result = $connection->select(
                "SELECT COUNT(*) as count FROM information_schema.statistics 
                 WHERE table_schema = ? AND table_name = ? AND index_name = ?",
                [$database, $table, $index]
            );
            return $result[0]->count > 0;
        };

        // Places table indexes
        if (!$indexExists('places', 'places_name_index')) {
            Schema::table('places', function (Blueprint $table) {
                $table->index('name', 'places_name_index');
            });
        }
        if (!$indexExists('places', 'places_address_index')) {
            Schema::table('places', function (Blueprint $table) {
                $table->index('address', 'places_address_index');
            });
        }

        // Categories table index
        if (!$indexExists('categories', 'categories_name_index')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->index('name', 'categories_name_index');
            });
        }

        // Subcategories table index
        if (!$indexExists('subcategories', 'subcategories_name_index')) {
            Schema::table('subcategories', function (Blueprint $table) {
                $table->index('name', 'subcategories_name_index');
            });
        }

        // Locations table index
        if (!$indexExists('locations', 'locations_name_index')) {
            Schema::table('locations', function (Blueprint $table) {
                $table->index('name', 'locations_name_index');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('places', function (Blueprint $table) {
            $table->dropIndex('places_name_index');
            $table->dropIndex('places_address_index');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex('categories_name_index');
        });

        Schema::table('subcategories', function (Blueprint $table) {
            $table->dropIndex('subcategories_name_index');
        });

        Schema::table('locations', function (Blueprint $table) {
            $table->dropIndex('locations_name_index');
        });
    }
};
