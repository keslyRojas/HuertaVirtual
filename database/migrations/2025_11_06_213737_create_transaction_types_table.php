<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * STUDENT LEARNING NOTE: Lookup Tables and Database Normalization
 * 
 * This migration creates a "lookup table" or "reference table" - a fundamental database concept!
 * 
 * Why do we need lookup tables?
 * Instead of storing "Purchase", "Sale", "Refund" over and over in our main transactions table,
 * we store them once here and just reference the ID. This is called "normalization."
 * 
 * Benefits:
 * - Saves storage space (storing ID "3" vs "Purchase" repeatedly)
 * - Ensures consistency (no typos like "Purchas" or "purchase")  
 * - Easy to change labels (update once here, affects all records)
 * - Better performance (integers are faster to search than text)
 * 
 * Key Learning Concepts:
 * - Database normalization principles
 * - Foreign key relationships
 * - Reference data vs transactional data
 * - Data integrity and consistency
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Learning Goal: Understanding how lookup tables work in relational databases
     */
    public function up(): void
    {
        // TRANSACTION TYPES: Defines what kinds of financial transactions exist
        // This will be referenced by wallet_transactions table via foreign key
        Schema::create('transaction_types', function (Blueprint $table) {
            // Primary key: Each transaction type gets a unique ID
            // Other tables will store this ID instead of the full text
            $table->id();
            
            // Transaction description: The human-readable name
            // Examples: "Purchase", "Sale", "Refund", "Bonus", "Withdrawal"
            // Note: Using 'text' type allows for longer descriptions if needed
            $table->text('transaction'); 
            
            // Standard Laravel timestamps
            // Helps track when transaction types were added/modified
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * 
     * IMPORTANT: Be careful when dropping lookup tables!
     * Make sure no other tables are still referencing this data
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_types');
    }
};
