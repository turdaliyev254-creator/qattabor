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
        // Add multilingual fields to categories
        Schema::table('categories', function (Blueprint $table) {
            $table->string('name_uz')->nullable()->after('name');
            $table->string('name_ru')->nullable()->after('name_uz');
            $table->string('name_en')->nullable()->after('name_ru');
        });

        // Add multilingual fields to subcategories
        Schema::table('subcategories', function (Blueprint $table) {
            $table->string('name_uz')->nullable()->after('name');
            $table->string('name_ru')->nullable()->after('name_uz');
            $table->string('name_en')->nullable()->after('name_ru');
        });

        // Add multilingual fields to places
        Schema::table('places', function (Blueprint $table) {
            $table->string('name_uz')->nullable()->after('name');
            $table->string('name_ru')->nullable()->after('name_uz');
            $table->string('name_en')->nullable()->after('name_ru');
            $table->text('description_uz')->nullable()->after('description');
            $table->text('description_ru')->nullable()->after('description_uz');
            $table->text('description_en')->nullable()->after('description_ru');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['name_uz', 'name_ru', 'name_en']);
        });

        Schema::table('subcategories', function (Blueprint $table) {
            $table->dropColumn(['name_uz', 'name_ru', 'name_en']);
        });

        Schema::table('places', function (Blueprint $table) {
            $table->dropColumn(['name_uz', 'name_ru', 'name_en', 'description_uz', 'description_ru', 'description_en']);
        });
    }
};
