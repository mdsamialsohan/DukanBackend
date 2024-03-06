<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    public function index()
    {
        $Acc = Account::all();
        return response()->json($Acc);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'AccName' => 'required|string',
            'Balance' => 'required|numeric|min:0',
        ]);
        //dd($request->all(), $validatedData);
        $Acc = Account::create($validatedData);

        return response()->json(['message' => 'Account created successfully', 'Accounts' => $Acc]);
    }
    public function transfer(Request $request)
    {
        $user = auth()->user();
        // Validate the incoming request data
        $request->validate([
            'AccID' => 'required',
            'Amount' => 'required|numeric|min:0',
        ]);
        try {
            // Start a database transaction
            DB::beginTransaction();
            $Account = Account::find($request->input('AccID'));
            $Account->Balance -= $request->input('Amount');
            $newCashBalance = $user->Cash + $request->input('Amount');
            $Account->save();
            $user->update(['Cash' => $newCashBalance]);
            DB::commit();
            return response()->json(['message' => 'Balance Transfer successfully'], 201);
        } catch (\Exception $e) {
            // Rollback the database transaction in case of an error
            DB::rollBack();

            return response()->json(['error' => 'Failed to Balance Transfer'], 500);
        }

    }
    public function Declare(Request $request)
    {
        $user = auth()->user();
        // Validate the incoming request data
        $request->validate([
            'AccID' => 'required',
            'Amount' => 'required|numeric|min:0',
        ]);
        try {
            // Start a database transaction
            DB::beginTransaction();
            $Account = Account::find($request->input('AccID'));
            $Account->Balance += $request->input('Amount');;
            $newCashBalance = $user->Cash - $request->input('Amount');
            $Account->save();
            $user->update(['Cash' => $newCashBalance]);
            DB::commit();
            return response()->json(['message' => 'Balance Transfer successfully'], 201);
        } catch (\Exception $e) {
            // Rollback the database transaction in case of an error
            DB::rollBack();

            return response()->json(['error' => 'Failed to Balance Transfer'], 500);
        }

    }
}
