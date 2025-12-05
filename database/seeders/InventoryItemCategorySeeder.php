<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InventoryItemCategory;

class InventoryItemCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Improved & Special Seeds'],
            ['name' => 'Fertilizer'],
            ['name' => 'Products']
        ];

        foreach ($categories as $category) {
            InventoryItemCategory::firstOrCreate(['name' => $category['name']]);
        }

        $this->command->info("Categorías creadas exitosamente.");
    }
}
