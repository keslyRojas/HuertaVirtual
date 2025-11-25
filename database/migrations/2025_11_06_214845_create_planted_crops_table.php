<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * STUDENT LEARNING NOTE: Complex Relationship Modeling and Game State Tracking
 * 
 * This is an excellent example of a "junction table" with additional attributes!
 * It connects multiple entities and tracks the state of their interactions over time.
 * 
 * Relationships demonstrated:
 * - garden_plots (WHERE is this planted?)
 * - plants (WHAT type of plant is this?)  
 * - planted_crop_statuses (WHAT stage of growth?)
 * 
 * This shows how real-world objects often involve multiple relationships:
 * - A planted crop exists in a specific location (garden plot)
 * - It's an instance of a plant template (plant type)
 * - It has a current lifecycle state (status)
 * - It has care history (watering, fertilizing)
 * - It has business logic (can be sold to market)
 * 
 * Game mechanics concepts:
 * - Health system (crops can get sick or die)
 * - Time-based actions (when was it last cared for?)
 * - Economic decisions (sell vs keep)
 * 
 * This pattern is common in:
 * - Gaming (character stats, item instances)
 * - IoT (device readings over time)
 * - Project management (task assignments with progress)
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Learning Goal: Understanding complex relationships and state tracking in databases
     */
    public function up(): void
    {
        // PLANTED CROPS: Actual plant instances growing in users' gardens
        Schema::create('planted_crops', function (Blueprint $table) {
            // Primary key: Unique identifier for this specific planted crop instance
            $table->id();
            
            // WHERE: Which plot is this crop planted in?
            // cascadeOnDelete(): If plot is deleted, remove the crop too (makes sense!)
            $table->foreignId('garden_plots_id')->constrained('garden_plots')->cascadeOnUpdate()->cascadeOnDelete();
            
            // WHAT: What type of plant is this?
            // restrictOnDelete(): Can't delete plant types that are currently planted
            // Prevents breaking existing crops by removing their template
            $table->foreignId('plants_id')->constrained('plants')->cascadeOnUpdate()->restrictOnDelete();
            
            // STATUS: What stage of growth is this crop in?
            // restrictOnDelete(): Can't delete statuses that crops are currently using
            $table->foreignId('planted_crop_statuses_id')->constrained('planted_crop_statuses')->cascadeOnUpdate()->restrictOnDelete();
            
            // HEALTH SYSTEM: How healthy is this crop? (0-100 scale)
            // Default 100 = perfectly healthy when planted
            // Could decrease due to lack of water, pests, disease, etc.
            $table->integer('health')->default(100);
            
            // CARE TRACKING: When was this crop last tended?
            // These timestamps enable gameplay mechanics like:
            // - "Your crops are thirsty!" notifications
            // - Health degradation over time without care
            // - Rewards for consistent care
            $table->timestamp('last_watered_at')->nullable();
            $table->timestamp('last_fertilized_at')->nullable();
            
            // HARVEST TRACKING: When was this crop collected?
            // null = not harvested yet, timestamp = when it was harvested
            // Enables post-harvest analytics and prevents re-harvesting
            $table->timestamp('harvested_at')->nullable();
            
            // BUSINESS LOGIC: Should this crop be auto-sold when harvested?
            // Single character flag (Y/N) - very space efficient
            // Enables automated economic gameplay
            $table->char('sell_to_market', 1)->nullable(); // 'Y'/'N'
            
            // Standard timestamps for audit trail
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planted_crops');
    }
};
