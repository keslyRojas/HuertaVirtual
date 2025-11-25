<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * STUDENT LEARNING NOTE: Health Data Management and Calculated Fields
 * 
 * This migration creates a results table for storing health/fitness calculations.
 * This appears to be from a different part of the application (health tracking)
 * rather than the garden game system.
 * 
 * Key concepts demonstrated:
 * - Decimal precision for scientific/health data
 * - Column comments for documentation
 * - Calculated vs stored values (BMI could be calculated on-the-fly)
 * - Health data categorization
 * 
 * Design considerations:
 * - Should BMI be stored or calculated? (Performance vs storage trade-off)
 * - How to handle data privacy and sensitivity?
 * - Should this link to a user_id for user-specific results?
 * - How to handle different measurement systems (metric vs imperial)?
 * 
 * Real-world applications:
 * - Fitness tracking apps (MyFitnessPal, Fitbit)
 * - Medical record systems
 * - Insurance health assessments
 * - Research data collection
 * 
 * Data types explained:
 * - decimal(5,2) = up to 999.99 (5 digits total, 2 after decimal)
 * - Perfect for measurements that need exact precision
 * - Better than float/double for financial or scientific data
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Learning Goal: Understanding precision data types and health data modeling
     */
    public function up(): void
    {
        // RESULTS: Health calculation results and body measurements
        Schema::create('results', function (Blueprint $table) {
            // Primary key: Unique identifier for each result record
            $table->id();
            
            // WEIGHT: Body weight measurement
            // decimal(5,2) allows values like 999.99 kg (covers most human weights)
            // Comment helps developers understand units and expected range
            $table->decimal('weight', 5, 2)->comment('Weight in kilograms');
            
            // HEIGHT: Body height measurement  
            // decimal(5,2) allows values like 999.99 meters (way more than needed, but safe)
            // Typical human range: 0.50m (infant) to 2.50m (very tall adult)
            $table->decimal('height', 5, 2)->comment('Height in meters');
            
            // BMI: Body Mass Index calculation result
            // Formula: BMI = weight(kg) / height(m)²
            // Storing calculated values enables faster queries and historical tracking
            // Alternative: Calculate on-demand to save space and ensure accuracy
            $table->decimal('bmi', 5, 2)->comment('Body Mass Index');
            
            // CATEGORY: BMI interpretation for user understanding
            // Examples: "Underweight", "Normal", "Overweight", "Obese"
            // Could reference a lookup table, but string is simpler for stable categories
            $table->string('category')->comment('BMI Category');
            
            // Standard timestamps for tracking when results were recorded
            // Important for health tracking over time
            $table->timestamps();
            
            // MISSING DESIGN ELEMENTS: Consider adding:
            // - user_id (whose results are these?)
            // - measurement_date (when was this measured, vs when recorded?)
            // - measurement_method (scale type, self-reported, clinical, etc.)
            // - notes (additional context or observations)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};
