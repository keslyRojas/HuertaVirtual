<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Mission;
use App\Models\MissionAssignment;
use App\Models\MissionAssignmentStatus;
use Illuminate\Support\Carbon;

class MissionAssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Obtener los datos base
        $users = User::all();
        $missions = Mission::all();
        $statuses = MissionAssignmentStatus::pluck('id', 'name');

        // Ciclo para asignar una misión a cada usuario
        $missionIndex = 0;

        foreach ($users as $user) {
            // Obtener una misión de forma rotativa
            $mission = $missions[$missionIndex % $missions->count()];

            MissionAssignment::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'missions_id' => $mission->id,
                ],
                [
                    'mission_assignment_statuses_id' => $statuses['active'] ?? 1,
                    'assigned_at' => now(),
                    'expires_at' => Carbon::now()->addDays(7),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            $missionIndex++;
        }
    }
}
