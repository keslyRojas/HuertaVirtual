<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\GardenPlot;

class GardenPlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Obtener todos los usuarios existentes
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->warn("⚠️ No hay usuarios registrados. Ejecuta primero el seeder de usuarios.");
            return;
        }

        foreach ($users as $user) {
            
            for($i = 1; $i <= 8; $i++){
            GardenPlot::firstOrCreate(
                ['user_id' => $user->id, 
                'plot_number' => $i,
            ],
                [
                    'status' => '0', // 0 - unlocked, 1 - locked
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
     }
  }
}
