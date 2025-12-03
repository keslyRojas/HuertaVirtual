<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('garden_plots', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->unsignedInteger('plot_number');

            $table->char('status', 1)->default('E'); 

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('garden_plots');
    }
};
