<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\InventoryItemCategory;

class InventoryItemCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
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
    }
}
