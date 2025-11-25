<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\PlantedCropStatus;

class PlantedCropStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $statuses = [
            ['name' => 'seeded'],   // Just planted
            ['name' => 'growing'],  // In progress, needs care
            ['name' => 'ready'],    // Ready to harvest
            ['name' => 'withered'] // Died or not harvested in time
        ];

        foreach ($statuses as $status) {
            PlantedCropStatus::firstOrCreate(['status' => $status['name']]);
        }
    }
}
