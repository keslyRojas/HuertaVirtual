<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\NotificationType;

class NotificationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $types = [
            ['name' => 'Reminder'],
            ['name' => 'Market'],
            ['name' => 'Mission'],
        ];

        foreach ($types as $type) {
            NotificationType::firstOrCreate(['name' => $type['name']]);
        }
    }
}
