<?php

namespace App\Http\Controllers;

use App\Account;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index($accountId)
    {
        return response()->json([
            'data' => Transaction::where('from', $accountId)
                ->orWhere('to', $accountId)
                ->get()
        ], 200);
    }

    public function store(Request $request, $accountId)
    {
        $validatedData = $request->validate([
            'to' => 'required',
            'amount' => 'required',
            'details' => 'required'
        ]);

        $receiverAccountId = $request->input('to');
        $amount = $request->input('amount');
        $details = $request->input('details');

        $senderAccount = Account::find($accountId);
        //deduct amount from the sender
        $senderAccount->deductAmount($amount);

        $receiverAccount = Account::find($receiverAccountId);
        //add amount to receiver
        $receiverAccount->addAmount($amount);

        $transaction = $senderAccount->senderTransactions()->create($validatedData);

        return response()->json([
            'data' => $transaction
        ], 201);
    }
}
