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
            // Semillas
            ['category' => 'Improved & Special Seeds', 'name' => 'Strawberry Seeds', 'price' => 4],
            ['category' => 'Improved & Special Seeds', 'name' => 'Carrot Seeds', 'price' => 3],

            // Fertilizante
            ['category' => 'Fertilizer', 'name' => 'Organic Fertilizer', 'price' => 5],

            // Productos
            ['category' => 'Products', 'name' => 'Strawberry', 'price' => 7],
            ['category' => 'Products', 'name' => 'Carrot', 'price' => 6],
        ];

        foreach ($items as $item) {
            InventoryItem::firstOrCreate([
                'inventory_item_category_id' => $categories[$item['category']],
                'name' => $item['name'],
            ], [
                'price' => $item['price']
            ]);
        }

        $this->command->info("Items creados exitosamente.");
    }
}
