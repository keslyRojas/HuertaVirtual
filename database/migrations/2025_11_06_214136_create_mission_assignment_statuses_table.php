<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * STUDENT LEARNING NOTE: Mission Assignment Status Lookup
 * 
 * This lookup table is different from mission_statuses! Here's why we need both:
 * 
 * - mission_statuses = status of the mission itself (Available, Completed, etc.)
 * - mission_assignment_statuses = status of a USER's attempt at a mission
 * 
 * Real-world analogy:
 * Think of a mission like "Clean the school cafeteria"
 * - Mission status: "Available" (the task exists and can be done)
 * - Assignment status: "Assigned" (John was given this task), "In Progress" (John started), "Submitted" (John finished)
 * 
 * Multiple users can have assignments for the same mission, each with their own status!
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Learning Goal: Understanding the difference between entity status vs assignment status
     */
    public function up(): void
    {
        // MISSION ASSIGNMENT STATUSES: Tracks individual user progress on missions
        Schema::create('mission_assignment_statuses', function (Blueprint $table) {
            // Primary key: Referenced by mission_assignments table
            $table->id();
            
            // Assignment status name
            // Examples: "Assigned", "In Progress", "Submitted", "Reviewed", "Approved", "Rejected"
            $table->text('name');
            
            // Timestamps to track when statuses were added/modified
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mission_assignment_statuses');
    }
};
