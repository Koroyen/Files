<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;

class AccountController extends Controller
{
    public function store(Request $request)
    {
        $account = Account::create([
            'username' => $request->input('username'),
            'email'    => $request->input('email'),
            'password' => bcrypt($request->input('password')), // Always hash
        ]);

        return response()->json($account);
    }
}
