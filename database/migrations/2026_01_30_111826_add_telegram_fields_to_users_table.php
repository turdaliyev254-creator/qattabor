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
        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('telegram_chat_id')->unique()->nullable()->after('phone');
            $table->string('telegram_username')->nullable()->after('telegram_chat_id');
            $table->string('telegram_first_name')->nullable()->after('telegram_username');
            $table->foreignId('telegram_region_id')->nullable()->constrained('regions')->nullOnDelete()->after('telegram_first_name');
            $table->string('telegram_language', 2)->default('uz')->after('telegram_region_id');
            $table->boolean('is_telegram_verified')->default(false)->after('telegram_language');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['telegram_region_id']);
            $table->dropColumn([
                'telegram_chat_id',
                'telegram_username',
                'telegram_first_name',
                'telegram_region_id',
                'telegram_language',
                'is_telegram_verified'
            ]);
        });
    }
};
