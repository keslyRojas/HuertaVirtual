<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * STUDENT LEARNING NOTE: Many-to-Many Relationships with Quantities
 * 
 * This is a classic "bridge table" or "junction table" that connects users to inventory items,
 * but with an important twist - it stores additional data (quantity)!
 * 
 * Traditional many-to-many: Users can have Items, Items can belong to Users
 * Enhanced many-to-many: Users can have X quantity of Items
 * 
 * Real-world examples:
 * - Shopping cart (customer has 3 apples, 2 oranges)
 * - Library system (user has 2 copies of "Book A", 1 copy of "Book B")  
 * - Warehouse management (location contains 50 units of product X)
 * - Game inventory (player has 10 health potions, 5 magic scrolls)
 * 
 * Key database concepts:
 * - Composite unique constraints (prevents duplicate entries)
 * - Quantity tracking in junction tables
 * - Different cascade strategies for different relationships
 * 
 * The unique constraint is crucial here - without it, you could have:
 * - User 1 has 5 tomato seeds (first row)
 * - User 1 has 3 tomato seeds (second row) <- This would be confusing!
 * 
 * With the constraint, each user can only have ONE row per item type.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Learning Goal: Understanding enhanced many-to-many relationships and data integrity
     */
    public function up(): void
    {
        // USER INVENTORIES: What items each user owns and how many
        Schema::create('user_inventories', function (Blueprint $table) {
            // Primary key: Unique identifier for each user-item relationship
            $table->id();
            
            // WHO: Which user owns these items?
            // cascadeOnDelete(): If user account is deleted, delete their inventory too
            $table->foreignId('user_id')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            
            // WHAT: What type of item is this?
            // restrictOnDelete(): Can't delete item types that users currently own
            // Protects against accidentally breaking users' inventories
            $table->foreignId('inventory_item_id')->constrained('inventory_items')->cascadeOnUpdate()->restrictOnDelete();
            
            // HOW MANY: Quantity of this item the user owns
            // Default 0 might seem odd, but allows for "placeholder" entries
            // or items that were consumed but we want to track the relationship
            $table->integer('quantity')->default(0);
            
            // Audit trail: When inventory was created/modified
            $table->timestamps();

            // CRITICAL CONSTRAINT: Prevents duplicate entries for same user + item combination
            // Without this: User could have multiple rows for "tomato seeds" with different quantities
            // With this: User can only have ONE row per item type, must update quantity instead
            // Comment: "no duplicar filas del mismo ítem" = "don't duplicate rows for the same item"
            $table->unique(['user_id', 'inventory_item_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_inventories');
    }
};
