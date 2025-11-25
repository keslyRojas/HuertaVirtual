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
                'name' => 'Tomato',
                'description' => 'A versatile mid-cycle crop that grows faster with regular watering and vertical support.',
                'growth_hours' => 48,          // tiempo de crecimiento en horas
                'water_need_per_day' => 2,     // cantidad de riegos por día
                'fertilizer_effect' => 10,     // porcentaje de efecto del fertilizante
                'price' => 30,
            ],
            [
                'name' => 'Carrot',
                'description' => 'A root crop with a medium-to-long growth cycle, best suited for loose soil and moderate watering.',
                'growth_hours' => 72,
                'water_need_per_day' => 1,
                'fertilizer_effect' => 15,
                'price' => 25,
            ],
            [
                'name' => 'Onion',
                'description' => 'A hardy bulb with slow growth that tolerates slight variations in watering and temperature.',
                'growth_hours' => 96,
                'water_need_per_day' => 1,
                'fertilizer_effect' => 12,
                'price' => 28,
            ],
            [
                'name' => 'Potato',
                'description' => 'A tuber crop with a long growth cycle, requiring consistent watering and benefiting greatly from fertilization.',
                'growth_hours' => 120,
                'water_need_per_day' => 2,
                'fertilizer_effect' => 20,
                'price' => 35,
            ],
            [
                'name' => 'Lettuce',
                'description' => 'A fast-growing leafy vegetable that thrives with frequent watering and light fertilization.',
                'growth_hours' => 36,
                'water_need_per_day' => 2,
                'fertilizer_effect' => 8,
                'price' => 20,
            ],
        ];

        foreach ($plants as $plant) {
            Plant::firstOrCreate(['name' => $plant['name']], $plant);
        }

    }
}
