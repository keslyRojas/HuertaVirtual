<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Models\TransactionType;

use Illuminate\Database\Seeder;

class UsersWithWalletsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
         $types = TransactionType::pluck('id', 'transaction');
        // 10 usuarios base
        $names = [
            'maria.rojas', 'carlos.soto', 'ana.martinez', 'diego.vargas', 'laura.mora',
            'pablo.lopez', 'sofia.gomez', 'ricardo.mendez', 'valeria.diaz', 'andres.romero'
        ];

        foreach ($names as $i => $uname) {
            DB::transaction(function () use ($uname, $types) {
                $email = $uname.'@example.com';

                $user = User::create([
                    'email'    => $email,
                    'name' => $uname,
                    'password' => Hash::make('password123'),
                ]);

                $wallet = Wallet::create([
                    'user_id' => $user->id,
                    'balance' => 10,
                ]);

                // 5 transacciones por usuario
                // Montos sugeridos y signo según tipo (earn suma, spend resta)
                $candidates = [
                    ['key' => 6, 'amount' => 10, 'event' => 'Registration'],
                    ['key' => 6, 'amount' => 10,  'event' => 'Registration'],
                    ['key' => 6, 'amount' => 10,  'event' => 'Registration'],
                    ['key' => 6, 'amount' => 10,  'event' => 'Registration'],
                    ['key' => 6, 'amount' => 10,  'event' => 'Registration'],
                ];

                foreach ($candidates as $tx) {
                    
                    WalletTransaction::create([
                        'wallet_id'           => $wallet->id,
                        'transaction_types_id' => $tx['key'],
                        'amount'              => $tx['amount'],  // siempre positivo en la tabla
                        'event'               => $tx['event'],
                    ]);

                }

                $wallet->save();
            });
        }
    }
}
