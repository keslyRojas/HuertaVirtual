<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\MissionStatus;

class MissionStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $statuses = [
            ['name' => 'Active'],
            ['name' => 'Canceled'],
            ['name' => 'Draft'],
        ];

        foreach ($statuses as $status) {
            MissionStatus::firstOrCreate(['name' => $status['name']]);
        }
    }
}
