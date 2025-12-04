<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Models\GardenPlot;
use App\Models\Plant;
use App\Models\PlantedCrop;
use App\Models\PlantedCropStatus;

use App\Models\UserInventory;
use App\Models\InventoryItemCategory;
use App\Models\InventoryItem;

use App\Models\Wallet;
use App\Models\TransactionType;
use App\Models\WalletTransaction;

class GardenController extends Controller
{
    public function index()
    {
        $plots  = GardenPlot::where('user_id', Auth::id())->get();
        $plants = Plant::all();

        $seedCategory = InventoryItemCategory::where('name', 'Improved & Special Seeds')->first();

        $seeds = UserInventory::where('user_id', Auth::id())
            ->whereHas('item', function($q) use ($seedCategory) {
                $q->where('inventory_item_category_id', $seedCategory->id);
            })
            ->sum('quantity');

        $harvestedCount = PlantedCrop::whereNotNull('harvested_at')
            ->whereHas('plot', function ($q) {
                $q->where('user_id', Auth::id());
            })
            ->count();

        $coins = Wallet::where('user_id', Auth::id())->value('balance');

        return view('garden.garden', compact(
            'plots', 'plants', 'seeds', 'harvestedCount', 'coins'
        ));
    }

  
    public function plant(Request $request)
    {
        $seedCategory = InventoryItemCategory::where('name', 'Improved & Special Seeds')->first();
        $seedItem = InventoryItem::where('inventory_item_category_id', $seedCategory->id)->first();

        $inventory = UserInventory::firstOrCreate([
            'user_id' => Auth::id(),
            'inventory_item_id' => $seedItem->id
        ]);

        if ($inventory->quantity < 1) {
            return back()->with('error', 'No tenés semillas suficientes.');
        }

        $inventory->quantity -= 1;
        $inventory->save();

        PlantedCrop::create([
            'garden_plots_id' => $request->garden_plot_id,
            'plants_id' => $request->plant_id,
            'planted_crop_statuses_id' => 1, // planted
            'health' => 100,
            'growth_stage' => 1,
        ]);

        $plot = GardenPlot::find($request->garden_plot_id);
        $plot->status = 'P';
        $plot->save();

        return back()->with('success', 'Semilla plantada con éxito.');
    }

    
    public function water(Request $request)
    {
        $crop = PlantedCrop::where('garden_plots_id', $request->garden_plot_id)
            ->whereNull('harvested_at')->first();

        if (!$crop) {
            return back()->with('error', 'No hay planta para regar.');
        }

        $crop->last_watered_at = now();
        $crop->growth_stage = min($crop->growth_stage + 1, 3);
        $crop->save();

        return back()->with('success', 'Planta regada.');
    }


    public function fertilize(Request $request)
    {
        $crop = PlantedCrop::where('garden_plots_id', $request->garden_plot_id)
            ->whereNull('harvested_at')->first();

        if (!$crop) {
            return back()->with('error', 'No hay planta para fertilizar.');
        }

        $crop->last_fertilized_at = now();
        $crop->growth_stage = min($crop->growth_stage + 1, 3);
        $crop->save();

        return back()->with('success', 'Planta fertilizada.');
    }


    public function harvest(Request $request)
{
    $crop = PlantedCrop::where('garden_plots_id', $request->garden_plot_id)
        ->whereNull('harvested_at')
        ->first();

    if (!$crop) {
        return back()->with('error', 'No hay planta para cosechar.');
    }

    $plant = Plant::find($crop->plants_id);

    if (!$plant) {
        return back()->with('error', 'Error: la planta no existe en la BD.');
    }

    $elapsedMinutes = \Carbon\Carbon::parse($crop->created_at)
        ->diffInMinutes(now(), false); 
    $requiredMinutes = $plant->growth_hours * 60;


    if ($plant->growth_hours == 0) {
        $elapsedMinutes = $requiredMinutes = 0;
    }

    if ($elapsedMinutes < $requiredMinutes) {
        return back()->with('error', 'La planta aún no está lista para cosechar.');
    }

    $harvestedStatus = PlantedCropStatus::firstOrCreate(['status' => 'harvested']);

    $crop->harvested_at = now();
    $crop->planted_crop_statuses_id = $harvestedStatus->id;
    $crop->save();

    $plot = GardenPlot::find($crop->garden_plots_id);
    $plot->status = 'E';
    $plot->save();

    $wallet = Wallet::firstOrCreate(['user_id' => Auth::id()]);
    $wallet->balance += 5;
    $wallet->save();

    return back()->with('success', '¡Cosechado y +5 monedas!');
 }

}