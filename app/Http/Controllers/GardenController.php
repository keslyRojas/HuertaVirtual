<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GardenPlot;
use App\Models\PlantedCrop;
use App\Models\Plant;
use App\Models\PlantedCropStatus;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth; 

class GardenController extends Controller
{
    public function index()
 {
    $plots = GardenPlot::where('user_id', Auth::id())->get();
    $plants = Plant::all();

    return view('garden.garden', compact('plots', 'plants'));
 }


    public function plant(Request $request)
    {
        if (!$request->garden_plot_id || !$request->plant_id) {
            return back()->with('error', 'Datos incompletos para sembrar.');
        }

        $plot = GardenPlot::find($request->garden_plot_id);

        if (!$plot) {
            return back()->with('error', 'La parcela no existe.');
        }

        if (PlantedCrop::where('garden_plots_id', $plot->id)->whereNull('harvested_at')->exists()) {
            return back()->with('error', 'Esta parcela ya está ocupada.');
        }

        $plant = Plant::find($request->plant_id);
        if (!$plant) {
            return back()->with('error', 'La semilla no existe.');
        }

        $status = PlantedCropStatus::firstOrCreate(['status' => 'seeded']);

        PlantedCrop::create([
            'garden_plots_id' => $plot->id,
            'plants_id' => $plant->id,
            'planted_crop_statuses_id' => $status->id,
            'health' => 100,
            'sell_to_market' => 'N'
        ]);

        $plot->status = 'P';
        $plot->save();

        return back()->with('success', 'Sembrado correctamente.');
    }

    public function water(Request $request)
    {
        $crop = PlantedCrop::where('garden_plots_id', $request->garden_plot_id)
            ->whereNull('harvested_at')
            ->first();

        if (!$crop) {
            return back()->with('error', 'No hay planta para regar.');
        }

        $crop->last_watered_at = Carbon::now();
        $crop->health = min(100, $crop->health + 5);
        $crop->save();

        return back()->with('success', 'La planta fue regada.');
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
        $elapsed = Carbon::now()->diffInHours($crop->created_at);

        if ($elapsed < $plant->growth_hours) {
            return back()->with('error', 'La planta aún no está lista.');
        }

        $harvested = PlantedCropStatus::firstOrCreate(['status' => 'harvested']);

        $crop->harvested_at = Carbon::now();
        $crop->planted_crop_statuses_id = $harvested->id;
        $crop->save();

        $plot = GardenPlot::find($crop->garden_plots_id);
        $plot->status = 'E';
        $plot->save();

        return back()->with('success', 'Cosechado correctamente.');
    }
}
