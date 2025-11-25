<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Mission;
use App\Models\MissionStatus;
use Illuminate\Support\Carbon;

class MissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Obtener los IDs de los estados por nombre
        $statuses = MissionStatus::pluck('id', 'name');

        // Definición de las misiones
        $missions = [
            [
                'mission_statuses_id' => $statuses['active'] ?? 1,
                'title' => 'Daily Harvest Challenge',
                'description' => 'Harvest at least 5 crops from your garden plots today.',
                'reward' => 100,
                'expires_at' => Carbon::now()->addDays(3),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mission_statuses_id' => $statuses['draft'] ?? 2,
                'title' => 'Planting Expansion Plan',
                'description' => 'Plant 10 new seeds to expand your farm production capacity.',
                'reward' => 150,
                'expires_at' => Carbon::now()->addDays(5),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mission_statuses_id' => $statuses['canceled'] ?? 3,
                'title' => 'Composting Station Setup',
                'description' => 'Build your first composting station to recycle organic waste. (Mission canceled)',
                'reward' => 200,
                'expires_at' => Carbon::now()->addDays(7),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insertar o actualizar misiones
        foreach ($missions as $mission) {
            Mission::updateOrCreate(['title' => $mission['title']], $mission);
        }

    }
}
