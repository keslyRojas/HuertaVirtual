<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * STUDENT LEARNING NOTE: User Progress Tracking and Time-Based Systems
 * 
 * This migration creates the connection between users and missions - tracking individual
 * progress on tasks. This is the "instance" table that pairs with the "template" (missions).
 * 
 * Key relationship pattern:
 * - missions table = "What tasks exist?" (templates)
 * - mission_assignments table = "Who is working on what?" (instances)
 * 
 * This pattern is everywhere in software:
 * - Course catalog vs student enrollments
 * - Job postings vs job applications  
 * - Event listings vs event registrations
 * - Product catalog vs shopping cart items
 * 
 * Time-based concepts demonstrated:
 * - Assignment tracking (when did user start?)
 * - Deadline management (when must it be completed?)
 * - Automatic timestamping (useCurrent for immediate assignment)
 * 
 * Progress tracking concepts:
 * - Individual user progress on shared goals
 * - Status transitions (assigned -> in progress -> completed)
 * - Historical record of user engagement
 * 
 * This enables powerful features like:
 * - "Your mission expires in 2 hours!"
 * - "You have 3 active missions"  
 * - "Complete your daily quests for bonus rewards"
 * - Analytics: "Most users complete mission A but abandon mission B"
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Learning Goal: Understanding progress tracking and time-based user engagement
     */
    public function up(): void
    {
        // MISSION ASSIGNMENTS: Individual user progress on specific missions
        Schema::create('mission_assignments', function (Blueprint $table) {
            // Primary key: Unique identifier for each user-mission pairing
            $table->id();
            
            // WHO: Which user is working on this mission?
            // cascadeOnDelete(): If user account deleted, remove their mission progress
            // This makes sense - no point keeping assignments for non-existent users
            $table->foreignId('user_id')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            
            // STATUS: What's the current progress on this assignment?
            // Links to mission_assignment_statuses lookup table
            // Examples: "Assigned", "In Progress", "Submitted", "Completed", "Failed"
            // restrictOnDelete(): Can't delete statuses that are currently in use
            $table->foreignId('mission_assignment_statuses_id')->constrained('mission_assignment_statuses')->cascadeOnUpdate()->restrictOnDelete();
            
            // WHICH MISSION: What task is this assignment for?
            // cascadeOnDelete(): If mission template deleted, remove all user assignments
            // Alternative design: You might want restrictOnDelete to preserve historical data
            $table->foreignId('missions_id')->constrained('missions')->cascadeOnUpdate()->cascadeOnDelete();
            
            // ASSIGNMENT TIME: When was this mission given to the user?
            // useCurrent(): Automatically set to current time when record is created
            // Critical for calculating how long users take to complete missions
            $table->timestamp('assigned_at')->useCurrent();
            
            // DEADLINE: When does this mission expire? (optional)
            // nullable(): Not all missions have time limits
            // Examples: "Complete within 24 hours", "Daily quest expires at midnight"
            // Enables urgent/time-pressure gameplay mechanics
            $table->timestamp('expires_at')->nullable();
            
            // Standard Laravel timestamps for additional tracking
            // created_at = when assignment record was created (same as assigned_at?)
            // updated_at = when assignment was last modified (status changes, etc.)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mission_assignments');
    }
};
