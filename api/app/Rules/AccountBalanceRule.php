<?php

namespace App\Rules;

use App\Account;
use Illuminate\Contracts\Validation\Rule;

class AccountBalanceRule implements Rule
{
    public $account;

    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    public function passes($attribute, $value)
    {
        return $this->account->balance >= $value;
    }

    public function message()
    {
        return 'your account balance is insufficient';
    }
}
