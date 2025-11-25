<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * STUDENT LEARNING NOTE: Item Catalog and Foreign Key Constraints
 * 
 * This migration creates the master catalog of all items that can exist in user inventories.
 * This is another example of "master data" - the templates that define what items are possible.
 * 
 * Key concepts demonstrated:
 * - Foreign key relationships with different cascade behaviors
 * - restrictOnDelete vs cascadeOnDelete (important distinction!)
 * - Master-detail relationships (categories -> items -> user inventory instances)
 * - Economic modeling with pricing systems
 * 
 * The relationship chain:
 * inventory_item_categories -> inventory_items -> user_inventories
 * (Category)                -> (Item Template) -> (User's Actual Items)
 * 
 * Example:
 * Category: "Seeds" -> Item: "Tomato Seeds" -> User has: 5 packets of tomato seeds
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Learning Goal: Understanding master data design and foreign key constraint strategies
     */
    public function up(): void
    {
        // INVENTORY ITEMS: Master catalog of all items that can exist in the game
        Schema::create('inventory_items', function (Blueprint $table) {
            // Primary key: Unique identifier for each item type
            $table->id();
            
            // Foreign key to categories: What type of item this is
            // constrained('inventory_item_categories'): Enforces referential integrity
            // cascadeOnUpdate(): If category ID changes, update this reference
            // restrictOnDelete(): CANNOT delete a category if items still reference it
            // This prevents accidentally breaking the database by deleting categories with items!
            $table->foreignId('inventory_item_category_id')
                  ->constrained('inventory_item_categories')
                  ->cascadeOnUpdate()->restrictOnDelete();
            
            // Item name: What users see in their inventory
            // Examples: "Tomato Seeds", "Watering Can", "Rose Fertilizer", "Garden Gnome"
            $table->text('name');
            
            // Base price: How much this item costs in the store (optional)
            // User-to-user marketplace prices might be different
            // Stored as integer to avoid floating-point precision issues
            $table->integer('price')->nullable(); 
            
            // Track when items were added to the catalog
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * 
     * Warning: This will fail if user_inventories or market_listings still reference these items!
     * Always consider dependency chains when dropping tables.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_items');
    }
};
