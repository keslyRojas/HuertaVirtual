<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\GardenPlot;

class GardenPlotSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->warn("No hay usuarios para asignar parcelas.");
            return;
        }

        foreach ($users as $user) {
            for ($i = 1; $i <= 2; $i++) {   // ⬅️ SOLO 2 PARCELAS

                GardenPlot::firstOrCreate(
                    [
                        'user_id' => $user->id,
                        'plot_number' => $i
                    ],
                    [
                        'status' => 'E',
                    ]
                );

            }
        }
    }
}
