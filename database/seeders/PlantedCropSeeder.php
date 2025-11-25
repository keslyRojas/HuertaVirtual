<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\GardenPlot;
use App\Models\Plant;
use App\Models\PlantedCrop;
use App\Models\PlantedCropStatus;
use Illuminate\Support\Carbon;

class PlantedCropSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $plots = GardenPlot::all();
        $plants = Plant::all();
        $statuses = PlantedCropStatus::pluck('id', 'name');

        foreach ($plots as $plot) {
            $plant = $plants->random(); // asignar una planta aleatoria
            $statusKey = collect(['seeded', 'growing', 'ready', 'withered'])->random();
            $statusId = $statuses[$statusKey] ?? $statuses->first();

            PlantedCrop::updateOrCreate(
                [
                    'garden_plots_id' => $plot->id,
                    'plants_id' => $plant->id,
                ],
                [
                    'planted_crops_status_id' => $statusId,
                    'health' => rand(70, 100), // salud aleatoria
                    'last_watered_at' => Carbon::now()->subHours(rand(5, 24)),
                    'last_fertilized_at' => rand(0, 1) ? Carbon::now()->subHours(rand(12, 48)) : null,
                    'harvested_at' => $statusKey === 'ready' ? Carbon::now()->subHours(rand(1, 12)) : null,
                    'sell_to_market' => $statusKey === 'ready' ? 'Y' : 'N',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
