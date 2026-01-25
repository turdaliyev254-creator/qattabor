<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->integer('order')->default(0)->after('image');
            $table->index('order');
        });

        Schema::table('subcategories', function (Blueprint $table) {
            $table->integer('order')->default(0)->after('icon');
            $table->index('order');
        });

        Schema::table('places', function (Blueprint $table) {
            $table->integer('order')->default(0)->after('social_clicks');
            $table->index('order');
        });

        // Set initial order values based on existing records
        DB::statement('SET @row_number = 0');
        DB::statement('UPDATE categories SET `order` = (@row_number:=@row_number + 1) ORDER BY id');
        
        DB::statement('SET @row_number = 0');
        DB::statement('UPDATE subcategories SET `order` = (@row_number:=@row_number + 1) ORDER BY id');
        
        DB::statement('SET @row_number = 0');
        DB::statement('UPDATE places SET `order` = (@row_number:=@row_number + 1) ORDER BY id');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex(['order']);
            $table->dropColumn('order');
        });

        Schema::table('subcategories', function (Blueprint $table) {
            $table->dropIndex(['order']);
            $table->dropColumn('order');
        });

        Schema::table('places', function (Blueprint $table) {
            $table->dropIndex(['order']);
            $table->dropColumn('order');
        });
    }
};
