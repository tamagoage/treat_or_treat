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
        Schema::table('shelf_lives', function (Blueprint $table) {
            // 外部キー
            // 自分で選択肢を増やした場合、自分が増やしたもののみ表示するため必要
            $table->unsignedBigInteger('user_id')->after('id');
            $table->dropColumn('shelf_life');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shelf_lives', function (Blueprint $table) {
            //
        });
    }
};
