<?php

namespace Database\Factories;

use App\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountFactory extends Factory
{
    protected $model = Account::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'balance' => 0
        ];
    }
}
