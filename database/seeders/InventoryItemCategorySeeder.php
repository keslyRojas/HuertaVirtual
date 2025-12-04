<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InventoryItemCategory;

class InventoryItemCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Fertilizers & Soil Enhancers'],
            ['name' => 'Tools & Equipment'],
            ['name' => 'Technology & Automation'],
            ['name' => 'Improved & Special Seeds'], 
            ['name' => 'Infrastructure & Utility Upgrades'],
        ];

        foreach ($categories as $category) {
            InventoryItemCategory::firstOrCreate(['name' => $category['name']]);
        }

        $this->command->info("Categorías creadas exitosamente.");
    }
}
