<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * STUDENT LEARNING NOTE: Quest/Mission System Design
 * 
 * This migration creates a mission system - a core feature in many modern applications
 * for user engagement, onboarding, and gamification.
 * 
 * Mission systems are found in:
 * - Games (complete quests, earn rewards)
 * - Fitness apps (walk 10,000 steps, get badges)
 * - Learning platforms (complete 5 lessons, unlock next module)
 * - Social media (post your first photo, invite 3 friends)
 * - E-commerce (make your first purchase, write a review)
 * 
 * Key design concepts:
 * - Clear objectives (what the user needs to do)
 * - Reward systems (why users should care)
 * - Status tracking (progress and completion)
 * - Content management (admins can create/modify missions)
 * 
 * This table represents the "mission template" - what missions exist and their rules.
 * The mission_assignments table tracks individual user progress on these missions.
 * 
 * Psychology behind missions:
 * - Provides clear goals and direction
 * - Creates sense of achievement and progress
 * - Builds habits through repeated engagement
 * - Offers rewards that motivate continued use
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Learning Goal: Understanding gamification and user engagement systems
     */
    public function up(): void
    {
        // MISSIONS: Template definitions for tasks users can complete
        Schema::create('missions', function (Blueprint $table) {
            // Primary key: Unique identifier for each mission type
            $table->id();
            
            // STATUS: What state is this mission in?
            // Links to mission_statuses lookup table
            // Examples: "Available" (users can start), "Disabled" (temporarily off), "Expired" (time limited)
            // restrictOnDelete(): Can't delete statuses that missions are using
            $table->foreignId('mission_statuses_id')
                  ->constrained('mission_statuses')
                  ->cascadeOnUpdate()->restrictOnDelete();
            
            // MISSION TITLE: Short, clear description of the goal
            // Examples: "Plant Your First Crop", "Harvest 10 Vegetables", "Sell Items Worth 100 Coins"
            // Should be motivating and easy to understand
            $table->text('title');
            
            // DETAILED DESCRIPTION: Longer explanation of requirements (optional)
            // Examples: "Welcome to gardening! Plant any type of seed in one of your garden plots to complete this mission."
            // Helps users understand exactly what they need to do
            $table->text('description')->nullable();
            
            // REWARD AMOUNT: How much the user earns for completing this mission
            // Could be coins, points, experience, etc.
            // Stored as integer for precision (e.g., 500 = 5.00 coins)
            // nullable(): Some missions might give non-monetary rewards (badges, unlocks)
            $table->integer('reward')->nullable();
            
            // Track when missions were created and last modified
            // Useful for analytics and content management
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * 
     * Warning: This will cascade to mission_assignments if users are currently working on missions!
     */
    public function down(): void
    {
        Schema::dropIfExists('missions');
    }
};
