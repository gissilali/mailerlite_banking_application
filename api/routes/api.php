<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('accounts/{id}', [\App\Http\Controllers\AccountController::class, 'show'])->name('accounts.show');

Route::get('accounts/{id}/transactions', [\App\Http\Controllers\TransactionController::class, 'index'])->name('transactions.index');

Route::post('accounts/{id}/transactions', [\App\Http\Controllers\TransactionController::class, 'store'])->name('transactions.store');

Route::get('currencies', 'GetCurrency');
