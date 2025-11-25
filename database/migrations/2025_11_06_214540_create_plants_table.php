<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * STUDENT LEARNING NOTE: Master Data and Game Mechanics
 * 
 * This migration creates a "master data" table for plants - the template/blueprint
 * that defines what each type of plant is like. This is different from planted_crops,
 * which represents actual instances of plants in users' gardens.
 * 
 * Think of this like:
 * - plants table = "Recipe book" (how to make chocolate chip cookies)
 * - planted_crops table = "Actual cookies in the oven" (specific cookies baking right now)
 * 
 * This demonstrates several important concepts:
 * - Separation of templates vs instances
 * - Game mechanics modeling (growth time, resource needs)
 * - Economic systems (pricing)
 * - Nullable fields for optional/unknown data
 * 
 * Real-world parallels:
 * - Product catalog vs inventory items
 * - Job descriptions vs actual employees
 * - Course curriculum vs student enrollments
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Learning Goal: Understanding master data design and game mechanics modeling
     */
    public function up(): void
    {
        // PLANTS: Master catalog of all available plant types in the game
        Schema::create('plants', function (Blueprint $table) {
            // Primary key: Unique identifier for each plant type
            $table->id();
            
            // Plant name: What users see in the interface
            // Examples: "Tomato", "Carrot", "Rose", "Sunflower"
            $table->text('name');
            
            // Plant description: Educational or flavor text (optional)
            // Examples: "A juicy red vegetable perfect for salads", "Bright yellow flower that follows the sun"
            $table->text('description')->nullable();
            
            // Game mechanics: How long this plant type takes to grow
            // Stored in hours for precise timing
            // Examples: Lettuce might be 24 hours, Oak tree might be 720 hours (30 days)
            $table->integer('growth_hours')->nullable();
            
            // Resource requirements: How much water this plant needs daily
            // Could be measured in "water units" or liters
            // Helps create resource management gameplay
            $table->integer('water_need_per_day')->nullable();
            
            // Boost mechanics: How much fertilizer helps this plant
            // Could be percentage boost or flat bonus to growth speed
            // Creates strategy around resource investment
            $table->integer('fertilizer_effect')->nullable();
            
            // Economic system: How much this plant costs to buy as seeds
            // Stored as integer (cents/coins) to avoid decimal precision issues
            $table->integer('price')->nullable(); 
            
            // Track when plant types were added to the game
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * 
     * Warning: Dropping this table will break references from planted_crops and inventory_items!
     */
    public function down(): void
    {
        Schema::dropIfExists('plants');
    }
};
