<?php namespace Database\Seeders; 
use Illuminate\Database\Seeder; 
use App\Models\User; 
use App\Models\InventoryItem; 
use App\Models\UserInventory; 
use App\Models\InventoryItemCategory; 

class UsersStartWithSeedsSeeder extends Seeder 
{ 
    public function run(): void 
    { 
        $seedCategory = InventoryItemCategory::where('name', 'Improved 
        & Special Seeds')->first(); 
        
        if (!$seedCategory) { 
            dd("ERROR: La categoría 'Improved & Special Seeds' no existe."); 
        } 
        $seedItems = InventoryItem::where('inventory_item_category_id',
         $seedCategory->id)->get(); 
        
        if ($seedItems->count() === 0) { 
            dd("ERROR: No existen items de semillas. Revisa 
            InventoryItemSeeder."); 
        } 
        foreach (User::all() as $user) { 
            $seedItem = 
            $seedItems->first(); 
            
        UserInventory::create([ 
            'user_id' => $user->id, 
            'inventory_item_id' => $seedItem->id, 
            'quantity' => 2, 
        ]); 
    } 
    
    echo "Usuarios iniciados con 2 semillas.\n"; 
} 

}