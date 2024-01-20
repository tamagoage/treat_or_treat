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
        Schema::table('treat_interests', function (Blueprint $table) {
            // 型と名前を変更
            $table->string('is_rejected')->default('pending')->change();
            $table->renameColumn('is_rejected', 'status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('treat_interests', function (Blueprint $table) {
            //
        });
    }
};
