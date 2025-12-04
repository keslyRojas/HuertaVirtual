<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InventoryItem;
use App\Models\InventoryItemCategory;

class InventoryItemSeeder extends Seeder
{
    public function run(): void
    {
        
        $categories = InventoryItemCategory::pluck('id', 'name')->toArray();

        
        $items = [
            ['category' => 'Fertilizers & Soil Enhancers', 'name' => 'Organic Compost', 'price' => 150],
            ['category' => 'Fertilizers & Soil Enhancers', 'name' => 'Slow-Release Fertilizer', 'price' => 250],
            ['category' => 'Fertilizers & Soil Enhancers', 'name' => 'Bio-Stimulant', 'price' => 300],
            ['category' => 'Fertilizers & Soil Enhancers', 'name' => 'Soil Conditioner', 'price' => 400],
            ['category' => 'Fertilizers & Soil Enhancers', 'name' => 'Microbial Inoculant', 'price' => 350],

            
            ['category' => 'Tools & Equipment', 'name' => 'Drip Irrigation System (Upgrade)', 'price' => 600],
            ['category' => 'Tools & Equipment', 'name' => 'Automated Sprinkler System', 'price' => 850],
            ['category' => 'Tools & Equipment', 'name' => 'Mini-Tractor', 'price' => 1200],
            ['category' => 'Tools & Equipment', 'name' => 'Modular Greenhouse', 'price' => 950],
            ['category' => 'Tools & Equipment', 'name' => 'Anti-Pest Netting', 'price' => 400],

            
            ['category' => 'Technology & Automation', 'name' => 'Scout Drone', 'price' => 1500],
            ['category' => 'Technology & Automation', 'name' => 'Soil Moisture Sensor', 'price' => 700],
            ['category' => 'Technology & Automation', 'name' => 'Personal Weather Station', 'price' => 900],
            ['category' => 'Technology & Automation', 'name' => 'Crop AI System', 'price' => 2000],

          
            ['category' => 'Improved & Special Seeds', 'name' => 'Hybrid Seeds (Tier 2)', 'price' => 180],
            ['category' => 'Improved & Special Seeds', 'name' => 'GMO Seeds (Tier 3)', 'price' => 250],
            ['category' => 'Improved & Special Seeds', 'name' => 'Heirloom Seeds', 'price' => 300],
            ['category' => 'Improved & Special Seeds', 'name' => 'Cover Crop (Clover)', 'price' => 100],

       
        ];

        foreach ($items as $item) {
            if (!isset($categories[$item['category']])) {
                throw new \Exception("Categoría NO encontrada: " . $item['category']);
            }

            InventoryItem::firstOrCreate([
                'inventory_item_category_id' => $categories[$item['category']],
                'name' => $item['name'],
            ], [
                'price' => $item['price'],
            ]);
        }

        echo "InventoryItemSeeder completado sin errores.\n";
    }
}
