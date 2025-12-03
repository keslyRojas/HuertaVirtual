<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GardenPlot;
use App\Models\PlantedCrop;
use App\Models\Plant;
use App\Models\PlantedCropStatus;
use Illuminate\Support\Carbon;

class GardenController extends Controller
{
    public function plant(Request $request)
    {
        // Lógica para sembrar una planta en el huerto
        $data = $request->validate([
            'garden_plot_id' => 'required|integer',
            'plant_id' => 'required|integer',
            'sell_to_market' => 'sometimes|boolean'
        ]);

        $plot = GardenPlot::find($data['garden_plot_id']);
        if (!$plot) {
            return response()->json(['error' => 'Garden plot not found'], 404);
        }

        $existing = PlantedCrop::where('garden_plots_id', $plot->id)->whereNull('harvested_at')->first();
        if ($existing) {
            return response()->json(['error' => 'Plot already occupied'], 409);
        }

        $plant = Plant::find($data['plant_id']);
        if (!$plant) {
            return response()->json(['error' => 'Plant type not found'], 404);
        }

        $status = PlantedCropStatus::where('status', 'seeded')->first();
        if (!$status) {
            $status = PlantedCropStatus::create(['status' => 'seeded']);
        }

        $crop = new PlantedCrop();
        $crop->garden_plots_id = $plot->id;
        $crop->plants_id = $plant->id;
        $crop->planted_crop_statuses_id = $status->id;
        $crop->health = 100;
        $crop->sell_to_market = isset($data['sell_to_market']) && $data['sell_to_market'] ? 'Y' : 'N';
        $crop->save();

        $plot->status = 'P';
        $plot->save();

        return response()->json(['message' => 'Planted', 'crop' => $crop], 201);
        
    }
    public function water(Request $request)
    {
        // Lógica para regar una planta en el huerto
        $data = $request->validate([
            'planted_crop_id' => 'sometimes|integer',
            'garden_plot_id' => 'sometimes|integer'
        ]);

        $crop = null;
        if (isset($data['planted_crop_id'])) {
            $crop = PlantedCrop::find($data['planted_crop_id']);
        } elseif (isset($data['garden_plot_id'])) {
            $crop = PlantedCrop::where('garden_plots_id', $data['garden_plot_id'])->whereNull('harvested_at')->first();
        }

        if (!$crop) {
            return response()->json(['error' => 'Planted crop not found'], 404);
        }

        $crop->last_watered_at = Carbon::now();
        $crop->health = min(100, ($crop->health ?? 100) + 5);

        // Check if ready based on plant growth_hours
        $plant = Plant::find($crop->plants_id);
        if ($plant && $crop->created_at) {
            $elapsedHours = Carbon::now()->diffInHours($crop->created_at);
            if ($elapsedHours >= ($plant->growth_hours ?? 0)) {
                $ready = PlantedCropStatus::where('status', 'ready')->first();
                if ($ready) {
                    $crop->planted_crop_statuses_id = $ready->id;
                    // update plot status to ready
                    $plot = GardenPlot::find($crop->garden_plots_id);
                    if ($plot) {
                        $plot->status = 'R';
                        $plot->save();
                    }
                }
            }
        }

        $crop->save();

        return response()->json(['message' => 'Watered', 'crop' => $crop]);
    }
    public function harvest(Request $request)
    {
        // Lógica para cosechar una planta en el huerto
        $data = $request->validate([
            'planted_crop_id' => 'sometimes|integer',
            'garden_plot_id' => 'sometimes|integer'
        ]);

        $crop = null;
        if (isset($data['planted_crop_id'])) {
            $crop = PlantedCrop::find($data['planted_crop_id']);
        } elseif (isset($data['garden_plot_id'])) {
            $crop = PlantedCrop::where('garden_plots_id', $data['garden_plot_id'])->whereNull('harvested_at')->first();
        }

        if (!$crop) {
            return response()->json(['error' => 'Planted crop not found'], 404);
        }

        $plant = Plant::find($crop->plants_id);
        $elapsedHours = $crop->created_at ? Carbon::now()->diffInHours($crop->created_at) : 0;
        $required = $plant->growth_hours ?? 0;

        if ($elapsedHours < $required) {
            return response()->json(['error' => 'Crop not ready for harvest', 'hours_elapsed' => $elapsedHours, 'hours_needed' => $required], 400);
        }

        $harvestedStatus = PlantedCropStatus::where('status', 'harvested')->first();
        if (!$harvestedStatus) {
            $harvestedStatus = PlantedCropStatus::create(['status' => 'harvested']);
        }

        $crop->harvested_at = Carbon::now();
        $crop->planted_crop_statuses_id = $harvestedStatus->id;
        $crop->save();

        $plot = GardenPlot::find($crop->garden_plots_id);
        if ($plot) {
            $plot->status = 'E';
            $plot->save();
        }

        return response()->json(['message' => 'Harvested', 'crop' => $crop]);
    }
    public function status($id)
    {
        // Lógica para consultar el estado de una parcela del huerto    
        $plot = GardenPlot::find($id);
        if (!$plot) {
            return response()->json(['error' => 'Garden plot not found'], 404);
        }

        $crop = PlantedCrop::where('garden_plots_id', $plot->id)->whereNull('harvested_at')->first();

        $response = ['plot' => $plot];
        if (!$crop) {
            $response['status'] = 'empty';
            return response()->json($response);
        }

        $plant = Plant::find($crop->plants_id);
        $required = $plant->growth_hours ?? 0;
        $elapsed = $crop->created_at ? Carbon::now()->diffInHours($crop->created_at) : 0;
        $progress = $required > 0 ? min(100, intval(($elapsed / $required) * 100)) : 0;

        $response['crop'] = $crop;
        $response['plant'] = $plant;
        $response['progress_percent'] = $progress;
        $response['hours_elapsed'] = $elapsed;
        $response['hours_required'] = $required;

        return response()->json($response);
    }
}
