<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * STUDENT LEARNING NOTE: Mission Status Lookup Table
 * 
 * Another example of a lookup/reference table! This one tracks the lifecycle of missions.
 * 
 * Think of this like quest statuses in a video game:
 * - "Available" (you can start this quest)
 * - "In Progress" (you're currently working on it)
 * - "Completed" (you finished it successfully) 
 * - "Failed" (something went wrong)
 * - "Expired" (time ran out)
 * 
 * This table will be referenced by the 'missions' table via foreign key relationship
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Learning Goal: Understanding state management in applications
     */
    public function up(): void
    {
        // MISSION STATUSES: Defines the possible states a mission can be in
        Schema::create('mission_statuses', function (Blueprint $table) {
            // Primary key: Referenced by missions table
            $table->id();
            
            // Status name: Human-readable mission state
            // Examples: "Available", "Active", "Completed", "Failed", "Expired"
            $table->text('name');
            
            // Note: No timestamps needed here since these are relatively static reference values
            // Mission statuses don't change often once defined
        });
    }

    /**
     * Reverse the migrations.
     * 
     * Drop the lookup table
     * Make sure missions table is dropped first if it references this!
     */
    public function down(): void
    {
        Schema::dropIfExists('mission_statuses');
    }
};
