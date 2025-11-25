<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\InventoryItem;
use App\Models\InventoryItemCategory;

class InventoryItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Obtener los IDs de categorías según su nombre
        $categories = InventoryItemCategory::pluck('id', 'name');

        $items = [
            // Category 1: Fertilizers & Soil Enhancers
            ['category' => 'Fertilizers & Soil Enhancers', 'name' => 'Organic Compost', 'price' => 150],
            ['category' => 'Fertilizers & Soil Enhancers', 'name' => 'Slow-Release Fertilizer', 'price' => 250],
            ['category' => 'Fertilizers & Soil Enhancers', 'name' => 'Bio-Stimulant', 'price' => 300],
            ['category' => 'Fertilizers & Soil Enhancers', 'name' => 'Soil Conditioner', 'price' => 400],
            ['category' => 'Fertilizers & Soil Enhancers', 'name' => 'Microbial Inoculant', 'price' => 350],

            // Category 2: Tools & Equipment
            ['category' => 'Tools & Equipment', 'name' => 'Drip Irrigation System (Upgrade)', 'price' => 600],
            ['category' => 'Tools & Equipment', 'name' => 'Automated Sprinkler System', 'price' => 850],
            ['category' => 'Tools & Equipment', 'name' => 'Mini-Tractor', 'price' => 1200],
            ['category' => 'Tools & Equipment', 'name' => 'Modular Greenhouse', 'price' => 950],
            ['category' => 'Tools & Equipment', 'name' => 'Anti-Pest Netting', 'price' => 400],

            // Category 3: Technology & Automation
            ['category' => 'Technology & Automation', 'name' => 'Scout Drone', 'price' => 1500],
            ['category' => 'Technology & Automation', 'name' => 'Soil Moisture Sensor', 'price' => 700],
            ['category' => 'Technology & Automation', 'name' => 'Personal Weather Station', 'price' => 900],
            ['category' => 'Technology & Automation', 'name' => 'Crop AI System', 'price' => 2000],

            // Category 4: Improved & Special Seeds
            ['category' => 'Improved & Special Seeds', 'name' => 'Hybrid Seeds (Tier 2)', 'price' => 180],
            ['category' => 'Improved & Special Seeds', 'name' => 'GMO Seeds (Tier 3)', 'price' => 250],
            ['category' => 'Improved & Special Seeds', 'name' => 'Heirloom Seeds', 'price' => 300],
            ['category' => 'Improved & Special Seeds', 'name' => 'Cover Crop (Clover)', 'price' => 100],

            // Category 5: Infrastructure & Utility Upgrades
            ['category' => 'Infrastructure & Utility Upgrades', 'name' => 'Expanded Storage Silo', 'price' => 1200],
            ['category' => 'Infrastructure & Utility Upgrades', 'name' => 'Online Marketplace (Building Upgrade)', 'price' => 1500],
            ['category' => 'Infrastructure & Utility Upgrades', 'name' => 'Research Lab', 'price' => 2000],
            ['category' => 'Infrastructure & Utility Upgrades', 'name' => 'Composting Station', 'price' => 1000],
        ];

        foreach ($items as $item) {
            InventoryItem::firstOrCreate([
                'inventory_item_category_id' => $categories[$item['category']] ?? null,
                'name' => $item['name'],
                'price' => $item['price'],
            ]);
        }
    }
}
