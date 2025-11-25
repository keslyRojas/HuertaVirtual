<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * STUDENT LEARNING NOTE: Notification System Categories
 * 
 * This lookup table categorizes different types of notifications in the system.
 * Modern applications need to notify users about various events, and categorizing
 * these helps with organization and user preferences.
 * 
 * Examples of notification types:
 * - "Mission Completed" - User finished a garden task
 * - "Crop Ready" - Plants are ready to harvest
 * - "Market Sale" - Someone bought your item
 * - "System Maintenance" - App will be down for updates
 * - "Achievement Unlocked" - User reached a milestone
 * 
 * Users might want to control which types of notifications they receive!
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Learning Goal: Understanding notification systems and user communication
     */
    public function up(): void
    {
        // NOTIFICATION TYPES: Categories for different kinds of app notifications
        Schema::create('notification_types', function (Blueprint $table) {
            // Primary key: Referenced by notifications table
            $table->id();
            
            // Note: This table seems incomplete - missing the 'name' or 'type' column
            // You should add something like: $table->string('name');
            // Examples: "Mission Alert", "Crop Update", "Market Activity", "System Notice"
            $table->string('name')->unique()->comment('Type of notification, e.g., Mission Completed, Crop Ready');
            // Track when notification types were added
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_types');
    }
};
