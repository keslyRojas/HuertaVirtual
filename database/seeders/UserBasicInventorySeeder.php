<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\InventoryItem;
use App\Models\UserInventory;
use App\Models\InventoryItemCategory;

class UserBasicInventorySeeder extends Seeder
{
    public function run(): void
    {
        // Categorías correctas
        $seedCat = InventoryItemCategory::where('name', 'Seeds')->first();
        $prodCat = InventoryItemCategory::where('name', 'Products')->first();
        $fertCat = InventoryItemCategory::where('name', 'Fertilizer')->first();

        // Items
        $strawberrySeeds = InventoryItem::where('name', 'Strawberry Seeds')->first();
        $carrotSeeds = InventoryItem::where('name', 'Carrot Seeds')->first();
        $fertilizer = InventoryItem::where('name', 'Fertilizer')->first();
        $strawberry = InventoryItem::where('name', 'Strawberry')->first();
        $carrot = InventoryItem::where('name', 'Carrot')->first();

        foreach (User::all() as $user) {
            
            UserInventory::updateOrCreate(
                ['user_id' => $user->id, 
                'inventory_item_id' => $strawberrySeeds->id],
                ['quantity' => 2]
            );

            UserInventory::updateOrCreate(
                ['user_id' => $user->id, 
                'inventory_item_id' => $carrotSeeds->id],
                ['quantity' => 2]
            );

            UserInventory::updateOrCreate(
                ['user_id' => $user->id, 
                'inventory_item_id' => $fertilizer->id],
                ['quantity' => 0]
            );

            UserInventory::updateOrCreate(
                ['user_id' => $user->id, 
                'inventory_item_id' => $strawberry->id],
                ['quantity' => 0]
            );

            UserInventory::updateOrCreate(
                ['user_id' => $user->id, 
                'inventory_item_id' => $carrot->id],
                ['quantity' => 0]
            );
        }
    }
}
