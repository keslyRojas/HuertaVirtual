<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * STUDENT LEARNING NOTE: E-commerce Listing Lifecycle
 * 
 * This lookup table tracks the status of items listed for sale in the marketplace.
 * This is a common pattern in e-commerce applications like eBay, Amazon Marketplace, or Facebook Marketplace.
 * 
 * Typical marketplace listing lifecycle:
 * 1. "Draft" - User is creating the listing but hasn't published yet
 * 2. "Active" - Listed and available for purchase
 * 3. "Sold" - Someone bought the item
 * 4. "Expired" - Listing time limit reached without sale
 * 5. "Removed" - User took down the listing
 * 6. "Suspended" - Admin removed due to policy violation
 * 
 * This helps both users and administrators track and manage the marketplace.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Learning Goal: Understanding e-commerce state management and marketplace dynamics
     */
    public function up(): void
    {
        // MARKET LISTING STATUSES: Tracks the lifecycle of marketplace listings
        Schema::create('market_listing_statuses', function (Blueprint $table) {
            // Primary key: Referenced by market_listings table
            $table->id();
            
            // Note: This table appears incomplete - missing the status name column
            // You should add something like: $table->string('name');
            // Examples: "Draft", "Active", "Sold", "Expired", "Removed", "Suspended"
            
            // Track when statuses were added to the system
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('market_listing_statuses');
    }
};
