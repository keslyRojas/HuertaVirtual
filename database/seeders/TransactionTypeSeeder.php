<?php

namespace Database\Seeders;

use App\Models\TransactionType;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $types = [
            ['transaction' => 'Earn'],
            ['transaction' => 'Spend'],
            ['transaction' => 'Refund'],
            ['transaction' => 'Transfer'],
            ['transaction' => 'Withdrawal'],
            ['transaction' => 'Deposit']
        ];

        foreach ($types as $t) {
            TransactionType::firstOrCreate(['transaction' => $t['transaction']]);
        }
    }
}
