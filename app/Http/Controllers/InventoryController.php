<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserInventory;
use Illuminate\Support\Facades\Auth;
use App\Models\Plant;
use App\Models\PlantedCrop;

class InventoryController extends Controller
{
    public function index()
    {
      $user = Auth::user();

        // Inventario (semillas y fertilizante)
        $inventory = UserInventory::with(['item.category'])
            ->where('user_id', $user->id)
            ->get();

        // Buscar plantas por nombre EXACTO
        $carrot = Plant::where('name', 'Carrot')->first();
        $strawberry = Plant::where('name', 'Strawberry')->first();

        // Contar cosechas (si existe la planta)
        $carrotCount = $carrot
            ? PlantedCrop::where('plants_id', $carrot->id)
                ->whereNotNull('harvested_at')
                ->count()
            : 0;

        $strawberryCount = $strawberry
            ? PlantedCrop::where('plants_id', $strawberry->id)
                ->whereNotNull('harvested_at')
                ->count()
            : 0;

        return view('inventory.inventory', [
            'inventory' => $inventory,
            'carrots_harvested' => $carrotCount,
            'strawberries_harvested' => $strawberryCount,
        ]);
    }
}
