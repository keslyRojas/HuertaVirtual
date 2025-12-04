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
        Schema::table('planted_crops', function (Blueprint $table) {
            $table->integer('growth_stage')->default(1);
            $table->boolean('boosted')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('planted_crops', function (Blueprint $table) {
            $table->dropColumn(['growth_stage', 'boosted']);
        });
    }
};
