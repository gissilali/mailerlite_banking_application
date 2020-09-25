<?php

namespace App\Http\Controllers;

use App\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function show($id)
    {
        return response()->json( [
            'data' => Account::find($id)
        ], 200);
    }
}
