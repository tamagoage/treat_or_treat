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
        Schema::create('shelf_lives', function (Blueprint $table) {
            $table->id();
            // 外部キー
            $table->unsignedBigInteger('treat_id');
            // カラム
            $table->date('shelf_life');
            $table->string('shelf_life_status');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shelf_lives');
    }
};
