<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * STUDENT LEARNING NOTE: Item Classification System
 * 
 * This lookup table creates categories for organizing inventory items - a fundamental
 * concept in inventory management and user experience design.
 * 
 * Why categorize items?
 * - Makes browsing easier for users ("Show me all seeds")
 * - Enables filtering and search functionality
 * - Helps with inventory organization and reporting
 * - Allows different business rules per category
 * 
 * Examples for a garden store app:
 * - "Seeds" (tomato seeds, carrot seeds, etc.)
 * - "Tools" (shovels, watering cans, pruners)
 * - "Fertilizers" (compost, plant food, soil amendments)
 * - "Decorations" (garden gnomes, planters, lights)
 * - "Harvested Crops" (fresh vegetables from your garden)
 * 
 * This is similar to how Amazon has categories like "Electronics", "Books", "Home & Garden"
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Learning Goal: Understanding data organization and user experience design
     */
    public function up(): void
    {
        // INVENTORY ITEM CATEGORIES: Organizes items into logical groups
        Schema::create('inventory_item_categories', function (Blueprint $table) {
            // Primary key: Referenced by inventory_items table
            $table->id();
            
            // Category name: Human-readable classification
            // Examples: "Seeds", "Tools", "Fertilizers", "Decorations", "Harvested Crops"
            $table->text('name');
            
            // Track when categories were added/modified
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_item_categories');
    }
};
