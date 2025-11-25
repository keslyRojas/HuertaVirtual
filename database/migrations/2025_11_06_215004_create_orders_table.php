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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete(); // comprador
            $table->foreignId('planted_crops_id')->nullable()->constrained('planted_crops')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('market_listings_id')->nullable()->constrained('market_listings')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('inventory_item_id')->nullable()->constrained('inventory_items')->cascadeOnUpdate()->nullOnDelete();
            $table->integer('total')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
