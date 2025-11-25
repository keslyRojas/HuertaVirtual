<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * STUDENT LEARNING NOTE: Marketplace and User-Generated Commerce
 * 
 * This migration creates a marketplace where users can sell items to each other -
 * a common feature in many modern applications.
 * 
 * Examples of similar systems:
 * - eBay (users sell items to other users)
 * - Facebook Marketplace (local peer-to-peer sales)
 * - Steam Community Market (game item trading)
 * - Etsy (handmade/vintage item marketplace)
 * - Amazon Marketplace (third-party sellers)
 * 
 * Key concepts demonstrated:
 * - User-generated commerce (users create their own listings)
 * - Dynamic pricing (users set their own prices)
 * - Lifecycle management (listings have statuses: active, sold, expired)
 * - Optional relationships (nullable foreign keys)
 * 
 * Business considerations:
 * - How to handle pricing and currency?
 * - What happens when items are sold?
 * - How to prevent fraud or inappropriate listings?
 * - How to facilitate discovery (search, categories, recommendations)?
 * 
 * Note: This table structure seems incomplete for a full marketplace.
 * Missing elements might include: seller_id, buyer_id, quantity, category, description, etc.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Learning Goal: Understanding peer-to-peer commerce and marketplace design
     */
    public function up(): void
    {
        // MARKET LISTINGS: Items that users have put up for sale
        Schema::create('market_listings', function (Blueprint $table) {
            // Primary key: Unique identifier for each listing
            $table->id();
            
            // WHAT'S FOR SALE: Reference to the plant type being sold (optional!)
            // nullable(): Not all listings might be plants (could be tools, decorations, etc.)
            // This suggests the marketplace might need to be more flexible
            // restrictOnDelete(): Can't delete plant types that are currently listed for sale
            $table->foreignId('plants_id')->nullable()
                  ->constrained('plants')->cascadeOnUpdate()->restrictOnDelete();
            
            // LISTING STATUS: What state is this listing in?
            // Examples: "Active" (available for purchase), "Sold", "Expired", "Removed"
            // Links to market_listing_statuses lookup table for consistency
            $table->foreignId('market_listings_status_id')
                  ->constrained('market_listing_statuses')
                  ->cascadeOnUpdate()->restrictOnDelete();
            
            // ASKING PRICE: How much the seller wants for this item
            // Stored as integer to avoid floating-point precision issues
            // Example: 550 = 5.50 coins/dollars
            $table->integer('price'); // Note: Design shows this as integer
            
            // Track when listings were created and last modified
            // Important for sorting ("newest listings") and analytics
            $table->timestamps();
            
            // DESIGN OBSERVATION: This table seems to be missing some important fields:
            // - seller_id (who is selling this?)
            // - quantity (how many items?)
            // - description (item details?)
            // - inventory_item_id (what if it's not a plant?)
            // You might want to consider adding these for a complete marketplace!
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('market_listings');
    }
};
