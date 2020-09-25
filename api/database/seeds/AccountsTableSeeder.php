<?php

namespace Database\Seeders;

use App\Account;
use App\Transaction;
use Illuminate\Database\Seeder;

class AccountsTableSeeder extends Seeder
{
    public function run()
    {
        Account::truncate();
        Transaction::truncate();
        Account::create([
            'name' => 'Gibson Silali',
            'balance' => '2300'
        ]);

        Account::create([
            'name' => 'Wes Gibbons',
            'balance' => '400'
        ]);
    }
}
