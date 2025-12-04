<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Models\TransactionType;
use Illuminate\Database\Seeder;

class UsersWithWalletsSeeder extends Seeder
{
    public function run(): void
    {
        $types = TransactionType::pluck('id', 'transaction');

        $names = [
            'maria.rojas', 'carlos.soto', 'ana.martinez', 'diego.vargas', 'laura.mora',
            'pablo.lopez', 'sofia.gomez', 'ricardo.mendez', 'valeria.diaz', 'andres.romero'
        ];

        foreach ($names as $uname) {
            DB::transaction(function () use ($uname, $types) {

                $user = User::create([
                    'email'    => $uname.'@example.com',
                    'name'     => $uname,
                    'password' => Hash::make('password123'),
                ]);

                $wallet = Wallet::create([
                    'user_id' => $user->id,
                    'balance' => 10,
                ]);

              
                for ($i = 0; $i < 5; $i++) {
                    WalletTransaction::create([
                        'wallet_id'            => $wallet->id,
                        'transaction_types_id' => $types['Deposit'], 
                        'amount'               => 10,
                        'event'                => 'Registration',
                    ]);
                }

                $wallet->save();
            });
        }
    }
}
