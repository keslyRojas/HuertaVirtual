<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Plant;

class PlantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $plants = [
            [
                'name' => 'Strawberry',
                'description' => 'A fruit-bearing plant cultivated as an herbaceous perennial, typically grown in loose, well-draining soil with a moderate watering schedule.',
                'growth_hours' => 6,          // tiempo de crecimiento en horas
                'water_need_per_day' => 2,     // cantidad de riegos por día
                'fertilizer_effect' => 10,     // porcentaje de efecto del fertilizante
                'price' => 5,                   // precio de la planta
            ],
            [
                'name' => 'Carrot',
                'description' => 'A root crop with a medium-to-long growth cycle, best suited for loose soil and moderate watering.',
                'growth_hours' => 4,        // tiempo de crecimiento en horas
                'water_need_per_day' => 1,  // cantidad de riegos por día
                'fertilizer_effect' => 15,  // porcentaje de efecto del fertilizante
                'price' =>3,                 // precio de la planta
            ]
        ];

        foreach ($plants as $plant) {
            Plant::firstOrCreate(['name' => $plant['name']], $plant);
        }

    }
}
