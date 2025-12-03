<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * STUDENT LEARNING NOTE: Virtual Space Management
 * 
 * This migration creates garden plots - virtual spaces where users can plant crops.
 * This demonstrates several key concepts in game and application design:
 * 
 * Resource limitation and scarcity:
 * - Users have limited garden space (creates strategic decisions)
 * - Must choose what to plant where and when
 * - Can drive monetization (buy more plots) or progression (unlock plots)
 * 
 * State management:
 * - Each plot has a status (empty, occupied, needs water, etc.)
 * - Enables complex gameplay mechanics and visual feedback
 * 
 * User ownership:
 * - Each plot belongs to a specific user
 * - Creates personal investment and customization
 * 
 * Real-world parallels:
 * - Minecraft building plots
 * - FarmVille crop fields  
 * - City planning simulation games
 * - Cloud computing resource allocation
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Learning Goal: Understanding virtual resource management and user progression systems
     */
    public function up(): void
    {
        // GARDEN PLOTS: Individual spaces in a user's garden where crops can be planted
        Schema::create('garden_plots', function (Blueprint $table) {
            // Primary key: Unique identifier for each plot
            $table->id();
            
            // Foreign key: Links plot to the user who owns it
            // Each user can have multiple plots (one-to-many relationship)
            // Cascade operations ensure data consistency when users are modified/deleted
            $table->foreignId('user_id')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            
            // Plot status: Single character code for current state
            // This is an interesting design choice - very space-efficient!
            // Examples: 'E' = Empty, 'P' = Planted, 'R' = Ready to harvest, 'W' = Needs water
            // Alternative: Could reference a plot_statuses lookup table instead
            // nullable() because new plots might not have a status set initially
            $table->char('status', 1)->nullable();
            // Plot number: Identifies specific plot for the user
            // Allows users to have multiple distinct plots
            $table->unsignedInteger('plot_number');

            
            // Standard timestamps for tracking plot creation/updates
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * 
     * Warning: This will cascade delete to planted_crops if they reference garden plots!
     */
    public function down(): void
    {
        Schema::dropIfExists('garden_plots');
    }
};
