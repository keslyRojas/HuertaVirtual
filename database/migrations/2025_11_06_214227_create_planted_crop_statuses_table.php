<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * STUDENT LEARNING NOTE: Crop Lifecycle Management
 * 
 * This lookup table represents the different stages of crop growth - a perfect example
 * of modeling real-world processes in software!
 * 
 * Real-world crop lifecycle:
 * 1. "Planted" - Seeds just put in the ground
 * 2. "Sprouting" - First green shoots appearing
 * 3. "Growing" - Plant is developing
 * 4. "Mature" - Ready to harvest
 * 5. "Harvested" - Crop has been collected
 * 6. "Withered" - Plant died or rotted (if not harvested in time)
 * 
 * This demonstrates how software can model time-based processes and state transitions.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Learning Goal: Modeling lifecycle states and time-based processes
     */
    public function up(): void
    {
        // PLANTED CROP STATUSES: Tracks the lifecycle stage of crops in the garden
        Schema::create('planted_crop_statuses', function (Blueprint $table) {
            // Primary key: Referenced by planted_crops table
            $table->id();
            
            // Crop lifecycle status
            // Examples: "Planted", "Sprouting", "Growing", "Mature", "Harvested", "Withered"
            $table->text('status');
            
            // Track when statuses were added to the system
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planted_crop_statuses');
    }
};
