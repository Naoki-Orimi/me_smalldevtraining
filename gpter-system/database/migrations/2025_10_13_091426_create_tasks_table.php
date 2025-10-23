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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // タイトル（必須）
            $table->text('description')->nullable(); // 説明（任意）
            $table->tinyInteger('status')->default(0); // ステータス（0:未着手, 1:進行中, 2:保留, 3:完了）
            $table->date('due_date')->nullable(); // 期日（任意・日付）
            $table->tinyInteger('priority')->default(1); // 優先度（0:低, 1:中, 2:高）
            $table->json('assignee_ids')->nullable(); // 担当者（複数のuser_idをJSON配列で保存）
            $table->foreignId('creator_id')->constrained('users'); // 作成者（user_id）
            $table->json('tag_ids')->nullable(); // タグ（複数のタグIDをJSON配列で保存）
            $table->tinyInteger('progress')->default(0); // 進捗率（0, 25, 50, 75, 100）
            $table->json('comments')->nullable(); // コメント（履歴として残す）
            $table->string('attachment_url')->nullable(); // 添付ファイルのURL代替
            $table->timestamps();
            $table->softDeletes(); // ソフトデリート対応
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
