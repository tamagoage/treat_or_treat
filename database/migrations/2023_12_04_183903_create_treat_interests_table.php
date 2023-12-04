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
        Schema::create('treat_interests', function (Blueprint $table) {
            $table->id();
            // 上二つは外部キー
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('treat_id');
            // デフォルトでリジェクトする
            $table->boolean('is_rejected')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treat_interests');
    }
};
