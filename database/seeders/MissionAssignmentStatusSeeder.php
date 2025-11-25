<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\MissionAssignmentStatus;

class MissionAssignmentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $statuses = [
            ['name' => 'active'],
            ['name' => 'completed'],
            ['name' => 'failed'],
            ['name' => 'expired'],
        ];

        foreach ($statuses as $status) {
            MissionAssignmentStatus::firstOrCreate(['name' => $status['name']]);
        }

    }
}
