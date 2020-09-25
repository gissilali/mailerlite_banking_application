<?php

namespace Tests\Feature;

use App\Account;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    public function testCanRetrieveAccountById()
    {
        $this->withoutExceptionHandling();
        $account = Account::factory()->create();
        $response = $this->get(route('accounts.show', ['id' => $account->id]));

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $account->id,
                    'name' => $account->name,
                    'balance' => (string)$account->balance,
                    'created_at' => Carbon::parse($account->created_at)->toString(),
                    'updated_at' => Carbon::parse($account->updated_at)->toString()
                ]
            ]);
    }

    public function testCanGetTransactionsByAccountId()
    {
        $expectedNumberOfTransactions = 3;
        $this->withoutExceptionHandling();
        $account = Account::factory()
            ->has(Transaction::factory()->count($expectedNumberOfTransactions), 'senderTransactions')
            ->create();
        $response = $this->get(route('transactions.index', ['id' => $account->id]));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [ 'id', 'from', 'to', 'details', 'amount']
                ]
            ]);

        $this->assertCount($expectedNumberOfTransactions, json_decode($response->getContent())->data);
    }

    public function testDoesNotGetTransactionsByAccountId()
    {
        $expectedNumberOfTransactions = 1;
        $this->withoutExceptionHandling();
        $account = Account::factory()
            ->has(Transaction::factory()->count($expectedNumberOfTransactions), 'senderTransactions')
            ->create();
        $response = $this->get(route('transactions.index', ['id' => $account->id]));

        $transaction1 = Transaction::factory()->create();
        $transaction2 = Transaction::factory()->create();

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [ 'id', 'from', 'to', 'details', 'amount']
                ]
            ]);
        $this->assertDatabaseCount('transactions', 3);
        $this->assertCount($expectedNumberOfTransactions, json_decode($response->getContent())->data);
    }

    public function testCanStoreTransactionInDatabase()
    {
        $this->withoutExceptionHandling();
        $senderAccount = Account::factory()->create();
        $receiverAccount = Account::factory()->create();
        $transactionData = Transaction::factory()->make([
            'from' => $senderAccount->id,
            'to' => $receiverAccount->id
        ]);
        $response = $this->post(
            route('transactions.store', ['id' => $transactionData['from']]),
            $transactionData->toArray()
        );

        $response->assertStatus(201)
            ->assertJson([
                'data' => $transactionData->toArray()
            ]);

        $this->assertDatabaseHas('transactions', $transactionData->toArray());
    }
}
