<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Transaction::truncate();
        $sampleTransactions = [
            [
                'from' => 1,
                'to' => 2,
                'details' => 'sample transaction',
                'amount' => 14
            ],
            [
                'from' => 1,
                'to' => 2,
                'details' => 'sample transaction 2',
                'amount' => 24
            ],
            [
                'from' => 2,
                'to' => 1,
                'details' => 'sample transaction 3',
                'amount' => 15
            ]
        ];
        foreach ($sampleTransactions as $sampleTransaction) {
            \App\Transaction::create($sampleTransaction);
        }

    }
}
