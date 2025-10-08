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
            // ロールフィールドを追加（社長/マネージャー/メンバー）
            $table->enum('role', ['president', 'manager', 'member'])->default('member')->after('email_verified_at');
            
            // ソフトデリート用のdeleted_atフィールドを追加
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // ロールフィールドを削除
            $table->dropColumn('role');
            
            // ソフトデリートフィールドを削除
            $table->dropSoftDeletes();
        });
    }
};
