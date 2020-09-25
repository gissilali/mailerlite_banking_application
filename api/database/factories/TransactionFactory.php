<?php

namespace Database\Factories;

use App\Account;
use App\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        return [
            'from' => Account::factory(),
            'to' => 2,
            'details' => $this->faker->sentence,
            'amount' => "1000",
        ];
    }
}
