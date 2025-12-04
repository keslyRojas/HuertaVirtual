<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            
          
            TransactionTypeSeeder::class,
         
            UsersWithWalletsSeeder::class,

            GardenPlotSeeder::class,

            InventoryItemCategorySeeder::class,
            InventoryItemSeeder::class,
            UsersStartWithSeedsSeeder::class,


            //NotificationTypeSeeder::class,

            PlantSeeder::class,


            PlantedCropStatusSeeder::class,

            //MissionStatusSeeder::class,
            //MissionSeeder::class,
            //MissionAssignmentStatusSeeder::class,
            //MissionAssignmentSeeder::class,
        ]);
    }
}
