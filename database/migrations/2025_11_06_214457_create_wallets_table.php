<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * STUDENT LEARNING NOTE: Digital Wallet System
 * 
 * This migration creates a digital wallet system - a crucial component in many modern applications
 * that involve virtual currencies, points, or credits.
 * 
 * Real-world examples:
 * - Mobile payment apps (PayPal, Venmo, Cash App)
 * - Gaming platforms (Steam Wallet, PlayStation Store)
 * - Reward systems (Starbucks points, airline miles)
 * - Cryptocurrency wallets
 * 
 * Key concepts demonstrated:
 * - One-to-one relationships (each user has exactly one wallet)
 * - Foreign key constraints and referential integrity
 * - Cascade operations (if user is deleted, wallet is too)
 * - Default values for new records
 * 
 * Important: In production, financial data requires extra security considerations!
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Learning Goal: Understanding digital currency systems and database relationships
     */
    public function up(): void
    {
        // WALLETS: Digital money/points storage for each user
        Schema::create('wallets', function (Blueprint $table) {
            // Primary key: Unique identifier for each wallet
            $table->id();
            
            // Foreign key to users table: Links wallet to specific user
            // constrained('users'): Ensures user_id must exist in users table
            // cascadeOnUpdate(): If user ID changes, update this reference too
            // cascadeOnDelete(): If user is deleted, delete their wallet too
            $table->foreignId('user_id')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            
            // Current wallet balance: stored as integer (cents/points)
            // Why integer instead of decimal? Avoids floating-point precision errors!
            // Example: $5.50 stored as 550 cents
            // default(10): New users start with 10 points/coins as a welcome bonus
            $table->integer('balance')->default(10);
            
            // Standard Laravel timestamps for audit trail
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * 
     * Note: This will fail if wallet_transactions table still exists and references wallets!
     * Always consider the order of dropping tables with foreign key relationships.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
