<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InventoryItemCategory;
use App\Models\InventoryItem;

class BasicGardenInventorySeeder extends Seeder
{
    public function run(): void
    {
        // Categorías mínimas
        $seeds = InventoryItemCategory::firstOrCreate(['name' => 'Seeds']);
        $products = InventoryItemCategory::firstOrCreate(['name' => 'Products']);
        $fert = InventoryItemCategory::firstOrCreate(['name' => 'Fertilizer']);

        // Items esenciales
        $items = [
            ['category_id' => $seeds->id, 'name' => 'Strawberry Seeds', 'price' => 3],
            ['category_id' => $seeds->id, 'name' => 'Carrot Seeds', 'price' => 3],
            ['category_id' => $products->id, 'name' => 'Strawberry', 'price' => 6],
            ['category_id' => $products->id, 'name' => 'Carrot', 'price' => 6],
            ['category_id' => $fert->id, 'name' => 'Fertilizer', 'price' => 4],
        ];

        foreach ($items as $item) {
            InventoryItem::firstOrCreate(
                [
                    'inventory_item_category_id' => $item['category_id'],
                    'name' => $item['name']
                ],
                ['price' => $item['price']]
            );
        }
    }
}
