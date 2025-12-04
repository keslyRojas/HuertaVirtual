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
                'growth_hours' => 0,         
                'water_need_per_day' => 1,    
                'fertilizer_effect' => 1,    
                'price' => 5,                 
            ],
            [
                'name' => 'Carrot',
                'description' => 'A root crop with a medium-to-long growth cycle, best suited for loose soil and moderate watering.',
                'growth_hours' => 0,        
                'water_need_per_day' => 1,  
                'fertilizer_effect' => 1,  
                'price' =>3,                
            ]
        ];

        foreach ($plants as $plant) {
            Plant::firstOrCreate(['name' => $plant['name']], $plant);
        }

    }
}
