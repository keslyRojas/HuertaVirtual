<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * STUDENT LEARNING NOTE: Financial Transaction Logging and Audit Trails
 * 
 * This migration creates a transaction log - one of the most important tables in any
 * financial system! This demonstrates several crucial concepts:
 * 
 * Immutable transaction history:
 * - Every money movement is recorded and never deleted
 * - Enables full audit trails and dispute resolution
 * - Required for financial compliance and debugging
 * 
 * Double-entry bookkeeping concepts:
 * - Each transaction shows amount and type (debit/credit)
 * - Can reconstruct wallet balance from transaction history
 * - Prevents data corruption and enables balance verification
 * 
 * Business event tracking:
 * - Links transactions to what caused them (purchase, sale, bonus, etc.)
 * - Enables business analytics and user behavior insights
 * - Supports customer service ("Where did this charge come from?")
 * 
 * Real-world parallels:
 * - Bank account statements
 * - Credit card transaction logs  
 * - Cryptocurrency blockchain records
 * - PayPal/Venmo transaction history
 * - Accounting systems (QuickBooks, SAP)
 * 
 * CRITICAL: In production financial systems, this table would have additional
 * security measures like encryption, digital signatures, and backup procedures!
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Learning Goal: Understanding financial data modeling and audit trail design
     */
    public function up(): void
    {
        // WALLET TRANSACTIONS: Complete history of all money movements
        Schema::create('wallet_transactions', function (Blueprint $table) {
            // Primary key: Unique identifier for each transaction (never reused!)
            $table->id();
            
            // WHICH WALLET: Links transaction to specific user's wallet
            // cascadeOnDelete(): If wallet is deleted, delete transaction history too
            // (Though in production, you might want to preserve transaction history!)
            $table->foreignId('wallet_id')->constrained('wallets')->cascadeOnUpdate()->cascadeOnDelete();
            
            // TRANSACTION TYPE: What kind of money movement was this?
            // restrictOnDelete(): Can't delete transaction types that have been used
            // Preserves data integrity and historical accuracy
            $table->foreignId('transaction_types_id')->constrained('transaction_types')->cascadeOnUpdate()->restrictOnDelete();
            
            // AMOUNT: How much money moved (positive or negative integer)
            // Positive = money added to wallet (deposit, sale, bonus)
            // Negative = money removed from wallet (purchase, withdrawal, fee)
            // Stored as integer to avoid floating-point precision errors
            $table->integer('amount');
            
            // EVENT CONTEXT: What caused this transaction? (optional but very useful!)
            // Examples: "Sold tomatoes to market", "Bought watering can", "Daily login bonus"
            // "Completed mission: Water 5 plants", "Purchased premium garden plot"
            // Helps with customer support and user understanding
            $table->text('event')->nullable(); 
            
            // TIMESTAMP: When did this transaction occur?
            // Critical for chronological ordering and dispute resolution
            // Laravel's timestamps() provides both created_at and updated_at
            // (Though financial transactions should rarely be "updated" after creation!)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * 
     * WARNING: Dropping transaction history is extremely dangerous in production!
     * This would permanently destroy financial audit trails.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
