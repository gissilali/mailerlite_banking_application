<?php

namespace Tests\Feature;

use App\Account;
use App\Rules\AccountBalanceRule;
use App\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AccountTest extends TestCase
{
    public function testCustomerCannotOverdrawAccount()
    {
        $this->withoutExceptionHandling();
        $senderAccount = Account::factory()->create([
            'balance' => 10
        ]);
        $receiverAccount = Account::factory()->create();

        $rules = [
            'amount' => [
                new AccountBalanceRule($senderAccount)
            ]
        ];

        $data = Transaction::factory()->make([
            'from' => $senderAccount->id,
            'to' => $receiverAccount->id,
            'amount' => 200
        ]);

        $validation = $this->app['validator']->make($data->toArray(), $rules);

        $this->assertTrue($validation->fails());
    }

    public function testCustomerCanWithdrawWithSufficientBalance()
    {
        $this->withoutExceptionHandling();
        $senderAccount = Account::factory()->create([
            'balance' => 10
        ]);
        $receiverAccount = Account::factory()->create();

        $rules = [
            'amount' => [
                new AccountBalanceRule($senderAccount)
            ]
        ];

        $data = Transaction::factory()->make([
            'from' => $senderAccount->id,
            'to' => $receiverAccount->id,
            'amount' => 10
        ]);

        $validation = $this->app['validator']->make($data->toArray(), $rules);

        $this->assertTrue($validation->passes());
    }

    public function testAccountBalanceIsCorrectAfterTransaction()
    {
        $this->withoutExceptionHandling();
        $senderAccount = Account::factory()->create([
            'balance' => 1000
        ]);
        $receiverAccount = Account::factory()->create([
            'balance' => 100
        ]);

        $amountSent = 100;

        $transactionData = Transaction::factory()->make([
            'from' => $senderAccount->id,
            'to' => $receiverAccount->id,
            'amount' => $amountSent
        ]);
        $response = $this->post(
            route('transactions.store', ['id' => $transactionData->from]),
            $transactionData->toArray()
        );

        $response->assertStatus(201);
        $this->assertDatabaseHas('accounts', [
            'id' => $senderAccount->id,
            'name' => $senderAccount->name,
            'balance' => (string)($senderAccount->balance - $amountSent)
        ]);
        $this->assertDatabaseHas('accounts', [
            'id' => $receiverAccount->id,
            'name' => $receiverAccount->name,
            'balance' => (string)($receiverAccount->balance + $amountSent)
        ]);

    }
}
